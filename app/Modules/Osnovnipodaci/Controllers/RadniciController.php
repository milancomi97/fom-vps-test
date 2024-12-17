<?php

namespace App\Modules\Osnovnipodaci\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Osnovnipodaci\Repository\OpstineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class RadniciController extends Controller
{

    public function __construct(
        private readonly RadniciRepositoryInterface $radniciRepositoryInterface,
        private readonly OpstineRepositoryInterface $opstineInterface,
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly KreirajObracunskeKoeficiente                        $kreirajObracunskeKoeficienteService,
        private readonly MesecnatabelapoentazaRepositoryInterface $mesecnatabelapoentazaInterface

    )
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gradovi = [
            1=>'Smederevska Palanka',
            2=>'Velika Plana',
            3=>'Kragujevac'
        ];
        $drzave = [
            1=>'Srbija',
            2=>'Francuska',
            3=>'Italija'
        ];
        $trosMesta = [
            1=>'Troskovno mesto 1',
            2=>'Troskovno mesto 2',
            3=>'Troskovno mesto 3',
            4=>'Troskovno mesto 4',
        ];

        $troskMesta = $this->organizacionecelineInterface->getSelectOptionData();

        return view('osnovnipodaci::radnici.radnici_create',
            [
                'gradovi' => $gradovi,
                'drzave'=>$drzave,
                'troskMesta'=>$troskMesta
            ]);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $requestData = $request->all();

        try {


              $checkDuplicate = User::where('maticni_broj',$requestData['maticni_broj'])->first();

              if($checkDuplicate){
                  return redirect()->route('radnici.create')->with('error', 'Radnik sa maticnim'. $requestData['maticni_broj'].' vec postoji: .');
              }



//            if(){
//
//            }
            $requestData['active'] = ($requestData['active'] ?? "") == 'on';
            $requestData['email']= $requestData['maticni_broj'].'@fom.com';

           if($requestData['active'] && $requestData['datum_zasnivanja_radnog_odnosa']==null){
               return redirect()->route('radnici.create')->with('error', 'Unesite datum zasnivanja radnog odnosa.');

           }
            $user = $this->radniciRepositoryInterface->createUser($requestData);
           $test='testtt';


            Maticnadatotekaradnika::create([
                'MBRD_maticni_broj'=>$user->maticni_broj,
                'PREZIME_prezime'=>$user->prezime,
                'IME_ime'=>$user->ime,
                'ACTIVE_aktivan'=>$user->active,
                'troskovno_mesto_id'=>$user->sifra_mesta_troska_id,
                'user_id'=>$user->id,
                'MRAD_minuli_rad_aktivan'=>true,
                'BRCL_redosled_poentazi'=>'9999'
            ]);
            return redirect()->route('radnici.index')->with('success', 'Radnik uspešno dodat');
        } catch (\Exception $e) {

        }
    }


    public function index()
    {

        $users = User::all()->sortByDesc('active');

        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                $user->maticni_broj,
                $user->prezime,
                $user->srednje_ime,
                $user->ime,
                $user->active,
                $user->id
            ];
        }

        return view('osnovnipodaci::radnici.radnici_index', ['users' => json_encode($userData)]);
    }


    public function edit(Request $request)
    {
        $userId = $request->radnikId;
        $opstine = $this->opstineInterface->getSelectOptionData();

       $radnik =  User::findOrFail($userId);

        $drzave = [
            1=>'Srbija',
            2=>'Francuska',
            3=>'Italija'
        ];
        $trosMesta = [
            1=>'Troskovno mesto 1',
            2=>'Troskovno mesto 2',
            3=>'Troskovno mesto 3',
            4=>'Troskovno mesto 4',
        ];


        return view('osnovnipodaci::radnici.radnici_edit',
            [
                'radnik' => $radnik,
                'opstine' => $opstine,
                'drzave'=>$drzave,
                'trosMesta'=>$trosMesta
            ]);

    }

    public function update(Request $request)
    {
        $requestData = $request->all();

        $requestData['active'] = ( $requestData['active'] ?? "") =='on';

        $active =  $requestData['active'];
        $userId = $request->radnikId;
        $user = User::findOrFail($userId);


        $status = $user->update($requestData);

        $maticniBroj  = $user->maticni_broj;
        $mdrResult =$this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$maticniBroj)->get();

        $test='test';

        if(count($mdrResult)){
            $mdrData = $mdrResult->first();
            $mdrData->ACTIVE_aktivan= (int) $active;
            $mdrData->save();
            $test='test';
        }
        if($status){
         return redirect()->route('radnici.index');
        }
    }


    public function editRadnik(Request $request)
    {
        $userId = $request->user_id;
        $opstine = $this->opstineInterface->getSelectOptionData();

        $radnik =  User::findOrFail($userId);

        $drzave = [
            1=>'Srbija',
            2=>'Francuska',
            3=>'Italija'
        ];
        $troskMesta = $this->organizacionecelineInterface->getSelectOptionData();


        return view('osnovnipodaci::radnici.radnici_edit',
            [
                'radnik' => $radnik,
                'opstine' => $opstine,
                'drzave'=>$drzave,
                'troskMesta'=>$troskMesta
            ]);

    }
    public function updateDeactivate(Request $request){

        $maticnoBroj =$request->maticni_broj;


        $radnikData= Mesecnatabelapoentaza::where('maticni_broj',$maticnoBroj)->first();
        $mdrData=Maticnadatotekaradnika::where('MBRD_maticni_broj',$maticnoBroj)->first();

        if($mdrData){
            $mdrData->ACTIVE_aktivan=false;
            $mdrData->save();

        }

        $userData =User::where('maticni_broj',$maticnoBroj)->first();
        if($userData){
            $userData->active=true;
            $userData->save();
        }



        if(!$radnikData) {

            return   redirect()->back()->with('success', 'Radnika nije aktivan');

        }else{


            $radnikData->delete();

            return   redirect()->back()->with('success', 'Radnika uklonjen');

        }

    }



    public function updateActivate(Request $request){
        $maticnoBroj =$request->maticni_broj;


        $radnikData= Mesecnatabelapoentaza::where('maticni_broj',$maticnoBroj)->first();
        $mdrData=Maticnadatotekaradnika::where('MBRD_maticni_broj',$maticnoBroj)->first();
        $userData =User::where('maticni_broj',$maticnoBroj)->first();
        if($radnikData) {
            return redirect()->back()->with('success', 'Radnik postoji');

            $test = 'tesyt';
        }else{
            if($userData){
                $userData->active=true;
                $userData->save();
            }

            if($mdrData){
                $mdrData->ACTIVE_aktivan=true;
                $mdrData->save();

            }


            $result = $this->datotekaobracunskihkoeficijenataInterface->where('status',1)->first();

            $resultOk = $this->kreirajObracunskeKoeficienteService->otvoriJednogRadnika($result,$maticnoBroj);
            $resultDatoteka = $this->mesecnatabelapoentazaInterface->createMany($resultOk);

            return redirect()->back()->with('success', 'Radnik je ponovo aktivan');

        }


    }



//interni_maticni_broj
//maticni_broj
}
