<?php

namespace App\Modules\Materijalno\Controllers;

use App\Models\Kartice;
use App\Models\Magacin;
use App\Models\Materijal;
use App\Models\Porudzbine;
use App\Models\StanjeZaliha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SviPodaciController extends Controller
{
    public function allDataTestt()
    {
        return view('materijalno::test.index');

    }


    public function getDataMaterijal()
    {
        $materijali = Materijal::select('sifra_materijala', 'naziv_materijala', 'standard', 'dimenzija', 'jedinica_mere')->get();
        return response()->json(['data' => $materijali]);
    }

    public function getDataStanjeMaterijala(Request $request){

        $limit = $request->input('length');
        $start = $request->input('start');
        $search = $request->input('search.value');

        $query = StanjeZaliha::with('magacin', 'materijal')
            ->when($search, function($query, $search) {
                return $query->where('sifra_materijala', 'LIKE', "%$search%");
            });

        $totalRecords = $query->count();

        $stanjeMaterijala = $query
            ->offset($start)
            ->limit($limit)
            ->get();

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($totalRecords),
            "data" => $stanjeMaterijala
        ];
        return response()->json(['data' => $stanjeMaterijala]);

    }
    public function getDataKartice()
    {
        $kartice = Kartice::select('sd', 'idbr', 'datum_k', 'kolicina', 'vrednost')
            ->with('materijal', 'magacin', 'dokument')
            ->get();
        return response()->json(['data' => $kartice]);
    }
    public function getDataPorudzbine()
    {
        $porudzbine = Porudzbine::select('rbpo', 'napo', 'dident', 'dclose', 'ugovor')->get();
        return response()->json(['data' => $porudzbine]);
    }

}
