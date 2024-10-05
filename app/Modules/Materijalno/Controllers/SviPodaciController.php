<?php

namespace App\Modules\Materijalno\Controllers;

use App\Models\Kartice;
use App\Models\Magacin;
use App\Models\Materijal;
use App\Models\Partner;
use App\Models\Porudzbine;
use App\Models\StanjeZaliha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SviPodaciController extends Controller
{
    public function allDataTestt()
    {
        return view('materijalno::test.index');

    }


    public function getDataMaterijal()
    {
        $materijali = Materijal::select(
            'sifra_materijala',
            'naziv_materijala',
            'standard',
            'dimenzija',
            'kvalitet',
            'jedinica_mere',
            'tezina',
            'dimenzije',
            'konto',
            'sifra_standarda',
        )->get();

        return response()->json(['data' => $materijali]);
    }

    public function getStanjeMagacinaData()
    {
        $stanjeMaterijala = StanjeZaliha::select(
            'magacin_id',
            DB::raw('SUM(kolicina) as total_kolicina'),
            DB::raw('SUM(vrednost) as total_vrednost')
        )->groupBy('magacin_id')
            ->get()->map(function ($item) {
                $item->total_kolicina = number_format($item->total_kolicina, 3);
                $item->total_vrednost = number_format($item->total_vrednost, 3);
                return $item;
            });
        return response()->json(['data' => $stanjeMaterijala]);

    }
    public function getDataStanjeMaterijala(Request $request){

//        $limit = $request->input('length');
//        $start = $request->input('start');
//        $search = $request->input('search.value');

        $stanjeMaterijala = StanjeZaliha::select('magacin_id', 'sifra_materijala', 'konto', 'cena', 'kolicina', 'vrednost',
            'pocst_kolicina', 'pocst_vrednost', 'ulaz_kolicina', 'ulaz_vrednost',
            'izlaz_kolicina', 'izlaz_vrednost', 'stanje_kolicina', 'stanje_vrednost')->get();

        return response()->json(['data' => $stanjeMaterijala]);

    }
    public function getDataKartice()
    {
//        $kartice = Kartice::select('sd', 'idbr', 'datum_k', 'kolicina', 'vrednost')
//            ->with('materijal', 'magacin', 'dokument')
//            ->get();

        $karticeQuery = Kartice::select('idbr')
            ->selectRaw('SUM(vrednost) as sum_total_vrednost')
            ->groupBy('idbr')
            ->get();


        return response()->json(['data' => $karticeQuery]);
    }
    public function getDataPorudzbine()
    {
        $porudzbine = Porudzbine::select('rbpo', 'napo', 'dident', 'dclose', 'ugovor')->get();
        return response()->json(['data' => $porudzbine]);
    }



    public function getDataPartner()
    {
        $partneri = Partner::select(
            'id',
            'name',
            'short_name',
            'pib',
            'phone',
            'email'
        )->get();

        // Vraćanje podataka u JSON formatu
        return response()->json(['data' => $partneri]);
    }

    public function getDataKonta()
    {
        $konta = StanjeZaliha::select('magacin_id', 'konto', DB::raw('SUM(vrednost) as ukupna_vrednost'))
            ->groupBy('magacin_id', 'konto')->get()->map(function ($item) {
                $item->ukupna_vrednost = number_format($item->ukupna_vrednost, 3);
                return $item;
            });


        return response()->json(['data' => $konta]);
    }
    public function pregledKartice($id){


        $karticeData = Kartice::where('id', $id)->with('materijal', 'magacin', 'dokument')->get();

        $kartice = Kartice::where('idbr', $karticeData->first()->idbr)->with('materijal', 'magacin', 'dokument')->get();

        $idbr=$karticeData->first()->idbr;
        // Vrati prikaz sa podacima o karticama
        return view('materijalno::test.pregled_kartice',compact('kartice','idbr'));
    }


    public function getKarticaId(Request $request){
        $kartice = Kartice::where('idbr', $request->idbr)->with('materijal', 'magacin', 'dokument')->first();

        $id=$kartice->id;
        // Vrati prikaz sa podacima o karticama
        return response()->json(['id' => $id]);
    }


public function materijaliPrikaz(){
        $activeTab = 'materijal';
        return view('materijalno::test.materijali',compact('activeTab'));
}
public function stanjeMaterijalaPrikaz(){
        $activeTab = 'stanje-materijala';
        return view('materijalno::test.stanje-materijala',compact('activeTab'));
}
public function karticePrikaz(){
        $activeTab = 'kartice';
        return view('materijalno::test.kartice',compact('activeTab'));
}
public function porudzbinePrikaz(){
        $activeTab = 'porudzbine';
        return view('materijalno::test.porudzbine',compact('activeTab'));
}

    public function partneriPrikaz(){
        $activeTab = 'partneri';
        return view('materijalno::test.partneri',compact('activeTab'));
    }

    public function kontaPrikaz(){
        $activeTab = 'konta';
        return view('materijalno::test.konta',compact('activeTab'));
    }


public function stanjeMagacinaPrikaz(){
    $activeTab = 'materijal_magacin';

    return view('materijalno::test.stanje-magacina',compact('activeTab'));
}

public function pregledMaterijala($sifraMaterijala){
        $test='testt';
    $selectedSifraMaterijala = $sifraMaterijala;
    $selectedChartType = 'bar';

    // Query the StanjeZaliha table based on sifra_materijala
    $stanjeZaliha = StanjeZaliha::where('sifra_materijala', $selectedSifraMaterijala)
        ->with('magacin')  // Load magacin relationship
        ->get();

    // Prepare data for charting (group by magacin)
    $chartData = $stanjeZaliha->groupBy('magacin_id')->map(function ($items, $key) {
        return [
            'magacin' => $key,
            'kolicina' => $items->sum('kolicina'),
            'vrednost' => $items->sum('vrednost'),
        ];
    });

    // Fetch all materials with the same sifra_materijala
    $materijali = StanjeZaliha::where('sifra_materijala', $selectedSifraMaterijala)
        ->with(['materijal', 'magacin'])  // Eager load the relationships
        ->get();
    return view('materijalno::testprikaz.materijal_magacin', compact('chartData', 'materijali', 'selectedChartType', 'selectedSifraMaterijala'));
}
    public function pregledMaterijalaDiagram(Request $request){
        $test='';
        $selectedSifraMaterijala = $request->input('sifra_materijala', null);
        $selectedChartType = $request->input('chartType', 'bar');


        // Query the StanjeZaliha table based on sifra_materijala
        $stanjeZaliha = StanjeZaliha::where('sifra_materijala', $selectedSifraMaterijala)
            ->get();

        // Prepare data for charting (group by magacin)
        $chartData = $stanjeZaliha->groupBy('magacin_id')->map(function ($items, $key) {
            return [
                'magacin' => $key,
                'kolicina' => $items->sum('kolicina'),
                'vrednost' => $items->sum('vrednost'),
            ];
        });

        // Fetch all materials with the same sifra_materijala
        $materijali = Materijal::where('sifra_materijala', $selectedSifraMaterijala)->get();

        return view('materijalno::testprikaz.materijal_magacin', compact('chartData', 'materijali', 'selectedChartType', 'selectedSifraMaterijala'));
    }


    public function pregledMagacina($magacinId){

            // Dohvatanje svih materijala iz odabranog magacina
            $materijali = StanjeZaliha::where('magacin_id', $magacinId)->with('materijal')->get();

            // Vraćanje prikaza sa materijalima
            return view('materijalno::testprikaz.magacin_materijal', compact('materijali', 'magacinId'));

    }
}
