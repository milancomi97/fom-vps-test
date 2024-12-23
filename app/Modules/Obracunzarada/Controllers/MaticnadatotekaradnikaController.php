<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\VrstaradasifarnikRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmFiksnaPlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\OblikradaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OpstineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaticnadatotekaradnikaController extends Controller
{

    public function __construct(
        private readonly OpstineRepositoryInterface $opstineInterface,
        private readonly RadnamestaRepositoryInterface $radnamestaInterface,
        private readonly IsplatnamestaRepositoryInterface $isplatnamestaInterface,
        private readonly VrstaradasifarnikRepositoryInterface $vrstaradasifarnikInterface,
        private readonly StrucnakvalifikacijaRepositoryInterface $strucnakvalifikacijaInterface,
        private readonly RadniciRepositoryInterface $radniciRepositoryInterface,
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly OblikradaRepositoryInterface $oblikradaInterface,
        private readonly  DpsmKreditiRepositoryInterface $dpsmKreditiInterface,
        private readonly  DpsmFiksnaPlacanjaRepositoryInterface $dpsmFiksnaPlacanjaInterface,
        private readonly MesecnatabelapoentazaRepositoryInterface $mesecnatabelapoentazaInterface,
    ) {
    }

    public function index(){

        $test="test";
        $maticnadatotekaradnika = $this->maticnadatotekaradnikaInterface->getAll();
        $maticnadatotekaradnikaData=[];
//        Matični
//Prezime
//Ime
//Aktivan
//Action
        foreach ($maticnadatotekaradnika as $radnik) {
            $maticnadatotekaradnikaData[] = [
                $radnik->MBRD_maticni_broj,
                $radnik->PREZIME_prezime,
                $radnik->IME_ime,
                $radnik->ACTIVE_aktivan,
                $radnik->id
            ];
        }


        return view('obracunzarada::maticnadatotekaradnika.maticnadatotekaradnika_index', ['maticnadatotekaradnika'=>json_encode($maticnadatotekaradnikaData)]);
    }
    public function create(){

        $radnaMesta = $this->radnamestaInterface->getSelectOptionData();
        $opstine = $this->opstineInterface->getSelectOptionData();
        $isplatnaMesta = $this->isplatnamestaInterface->getSelectOptionData(); // add key
        $vrstaRada = $this->vrstaradasifarnikInterface->getSelectOptionData(); // add key
        $kvalifikacije =  $this->strucnakvalifikacijaInterface->getSelectOptionData();
        $troskMesta = $this->organizacionecelineInterface->getSelectOptionData(); // ADD KEY

        return view('obracunzarada::maticnadatotekaradnika.maticnadatotekaradnika_create',
            [
                'opstine'=>$opstine,
                'radnaMesta'=>$radnaMesta,
                'isplatnaMesta'=>$isplatnaMesta,
                'vrstaRada'=>$vrstaRada,
                'kvalifikacije'=>$kvalifikacije,
                'troskMesta' =>$troskMesta
            ]);

    }



    public function createFromUser(Request $request){

        $radnaMesta = $this->radnamestaInterface->getSelectOptionData();
        $opstine = $this->opstineInterface->getSelectOptionData();
        $isplatnaMesta = $this->isplatnamestaInterface->getSelectOptionData(); // add key
        $vrstaRada = $this->vrstaradasifarnikInterface->getSelectOptionData(); // add key
        $kvalifikacije =  $this->strucnakvalifikacijaInterface->getSelectOptionData();
        $troskMesta = $this->organizacionecelineInterface->getSelectOptionData(); // ADD KEY

        $oblikRada = $this->oblikradaInterface->getSelectOptionData();

        return view('obracunzarada::maticnadatotekaradnika.maticnadatotekaradnika_create_by_user',
            [
                'opstine'=>$opstine,
                'radnaMesta'=>$radnaMesta,
                'isplatnaMesta'=>$isplatnaMesta,
                'vrstaRada'=>$vrstaRada,
                'kvalifikacije'=>$kvalifikacije,
                'troskMesta' =>$troskMesta,
                'user_id'=>$request->user_id,
                'oblikRada'=>$oblikRada,
            ]);

    }






    public function edit(Request $request){

        $radnikId = $request->radnik_id;
        $maticnadatotekaradnikData = $this->maticnadatotekaradnikaInterface->getById($radnikId);
        $radnaMesta = $this->radnamestaInterface->getSelectOptionData();
        $opstine = $this->opstineInterface->getSelectOptionData();
        $isplatnaMesta = $this->isplatnamestaInterface->getSelectOptionData(); // add key
        $vrstaRada = $this->vrstaradasifarnikInterface->getSelectOptionData(); // add key
        $kvalifikacije =  $this->strucnakvalifikacijaInterface->getSelectOptionData();
        $troskMesta = $this->organizacionecelineInterface->getSelectOptionData(); // ADD KEY

        return view('obracunzarada::maticnadatotekaradnika.maticnadatotekaradnika_edit',
            [
                'opstine'=>$opstine,
                'radnaMesta'=>$radnaMesta,
                'isplatnaMesta'=>$isplatnaMesta,
                'vrstaRada'=>$vrstaRada,
                'kvalifikacije'=>$kvalifikacije,
                'troskMesta' =>$troskMesta,
                'radnikData'=>$maticnadatotekaradnikData
            ]);

    }

    public function editByUserId(Request $request){

        $radnikId = $request->user_id;
        $maticnadatotekaradnikData = $this->maticnadatotekaradnikaInterface->where('user_id',$radnikId)->first();
        $userData =User::with('permission')->find(Auth::id());

        if($maticnadatotekaradnikData==null){
            return redirect()->route('maticnadatotekaradnika.createFromUser',['user_id'=>$radnikId]);

        }
        $radnaMesta = $this->radnamestaInterface->getSelectOptionData();
        $opstine = $this->opstineInterface->getSelectOptionData();
        $isplatnaMesta = $this->isplatnamestaInterface->getSelectOptionData();
        $vrstaRada = $this->vrstaradasifarnikInterface->getSelectOptionData();
        $kvalifikacije =  $this->strucnakvalifikacijaInterface->getSelectOptionData();
        $troskMesta = $this->organizacionecelineInterface->getSelectOptionData();

        $oblikRada = $this->oblikradaInterface->getSelectOptionData();
        return view('obracunzarada::maticnadatotekaradnika.maticnadatotekaradnika_edit',
            [
                'opstine'=>$opstine,
                'radnaMesta'=>$radnaMesta,
                'isplatnaMesta'=>$isplatnaMesta,
                'vrstaRada'=>$vrstaRada,
                'oblikRada'=>$oblikRada,
                'kvalifikacije'=>$kvalifikacije,
                'troskMesta' =>$troskMesta,
                'radnikData'=>$maticnadatotekaradnikData,
                'userData'=>$userData
            ]);

    }

    public function findByMat(Request $request)
    {
        $inputString = $request->q;


//                $test = User::where('maticni_broj', 'like', '%' . $inputString . '%')
//            ->orWhere('ime', 'like', '%' . $inputString . '%')->get();
//        $data2 = $this->radniciRepositoryInterface->likeOrLike('maticni_broj','prezime',$inputString);


        $userCollection = $this->radniciRepositoryInterface->like('maticni_broj', $inputString);
        $result = $userCollection->map(function ($item) {
            return ['id' => $item['id'], 'text' => $item['maticni_broj'] . ' - ' . $item['prezime'] . ' ' . $item['srednje_ime'] . '. ' .$item['ime'] . ' - jmbg: ' . $item['jmbg']];
        });

        return response()->json($result);
    }

    public function findByPrezime(Request $request)
    {
        $inputString = $request->q;

        $userCollection = $this->radniciRepositoryInterface->like('prezime', $inputString);
        $result = $userCollection->map(function ($item) {
            return ['id' => $item['id'], 'text' => $item['maticni_broj'] . ' - ' . $item['prezime'] . ' '.$item['srednje_ime'] . '. ' . $item['ime'] . ' - jmbg: ' . $item['jmbg']];
        });

        return response()->json($result);
    }

    public function getById(Request $request){

        $userId = $request->radnikId;
        $userData = $this->radniciRepositoryInterface->getById($userId);
        $userArray = $userData->toArray();
        return response()->json($userArray);
    }


    public function store(Request $request){

//maticni_broj
//prezime
//ime
//radno_mesto
//isplatno_mesto
//tekuci_racun
//redosled_poentazi
//vrsta_rada
//radna_jedinica
//brigada
//godine
//meseci
//minuli_rad_aktivan
//stvarna_strucna_sprema
//priznata_strucna_sprema
//osnovna_zarada
//jmbg
//pol_muski
//prosecni_sati
//prosecna_zarada
//adresa_ulica_broj
//opstina_id
        $this->maticnadatotekaradnikaInterface->createMaticnadatotekaradnika($request->all());
        $test='testt';
        return redirect()->route('maticnadatotekaradnika.index');
    }

    public function update(Request $request)
    {
        $maticni_broj=$request->maticni_broj;
        $attributes = $request->except(['_token','maticni_broj']); // Exclude _token if needed
        $attributes['MRAD_minuli_rad_aktivan'] = ( $attributes['MRAD_minuli_rad_aktivan'] ?? "") =='on';
//        $attributes['POL_pol'] = ( $attributes['POL_pol'] ?? "") =='M';
        $attributes['email_za_plate_poslat'] =(int)$attributes['email_za_plate_poslat'] ;
        $attributes['ACTIVE_aktivan'] = ( $attributes['ACTIVE_aktivan'] ?? "") =='on';

        $radnik=$this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$maticni_broj)->first();


        if($radnik->ACTIVE_aktivan && (!$attributes['ACTIVE_aktivan'] )){
            return $this->proveraPriDeaktiviranju($maticni_broj);
        }



        $radnik->update($attributes);

        $kadr=User::where('maticni_broj',$maticni_broj)->first();
        $kadr->active= $attributes['ACTIVE_aktivan'];
        $kadr->save();
        session()->flash('success', 'Podaci su uspesno izmenjeni'); // Flash success message

        return redirect()->route('maticnadatotekaradnika.editByUserId',[
            'user_id'=>$radnik->user_id
        ]);

    }

    public function proveraPriDeaktiviranju($maticniBroj){

        $message='Radnik nije uklonjen zbog: <br>';
        $krediti = $this->dpsmKreditiInterface->where('maticni_broj',$maticniBroj)->get();
        $fiksnaPlacanja =$this->dpsmFiksnaPlacanjaInterface->where('maticni_broj',$maticniBroj)->get();

        if(count($krediti)){
            $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->where('maticni_broj',$maticniBroj)->first();
            $id =$mesecnaTabelaPoentaza->id;

            $message .= '<a href="' . url('obracunzarada/datotekaobracunskihkoeficijenata/show_krediti?radnik_id=' . $id) . '">Kredita</a>: ' . count($fiksnaPlacanja) . '<br>';

        }

        if(count($fiksnaPlacanja)){
            $mesecnaTabelaPoentaza = $this->mesecnatabelapoentazaInterface->where('maticni_broj',$maticniBroj)->first();
            $id =$mesecnaTabelaPoentaza->id;

            $message .= '<a href="' . url('obracunzarada/datotekaobracunskihkoeficijenata/show_fiksnap?radnik_id=' . $id) . '">Fiksnih plaćanja</a>: ' . count($fiksnaPlacanja) . '<br>';
        }
        if($krediti || $fiksnaPlacanja){
            return redirect()->back()->with('error', $message);
        }

    }
    }
