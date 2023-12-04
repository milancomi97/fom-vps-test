<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\VrstaradasifarnikRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OpstineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepositoryInterface;
use Illuminate\Http\Request;

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
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface
    ) {
    }

    public function index(){

        $test="test";
        $maticnadatotekaradnikaData = $this->maticnadatotekaradnikaInterface->getAll();

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
        $request->all();
        $this->maticnadatotekaradnikaInterface->createMaticnadatotekaradnika($request->all());
        $test='testt';
        return redirect()->route('maticnadatotekaradnika.index');
    }

}
