<?php

namespace App\Modules\Osnovnipodaci\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
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
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface
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

            if (strlen($requestData['maticni_broj']) !== 4) {
                return redirect()->route('radnici.create')->with('error', 'Neispravan matični broj.');

            }

//            if(){
//
//            }
            $requestData['maticni_broj'] = '000' . $requestData['maticni_broj'];
            $requestData['active'] = ($requestData['active'] ?? "") == 'on';

           if($requestData['active'] && $requestData['datum_zasnivanja_radnog_odnosa']==null){
               return redirect()->route('radnici.create')->with('error', 'Unesite datum zasnivanja radnog odnosa.');

           }
            $user = $this->radniciRepositoryInterface->createUser($requestData);
            return redirect()->route('radnici.index');
        } catch (\Exception $e) {
            if($e->getCode()=='23000'){
                return redirect()->route('radnici.create')->with('error', 'Podatak već postoji');
            }
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
//interni_maticni_broj
//maticni_broj
}
