<?php

namespace App\Modules\Osnovnipodaci\Controllers;

use App\Http\Controllers\Controller;
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
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface
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


        return view('osnovnipodaci::radnici.radnici_create',
            [
                'gradovi' => $gradovi,
                'drzave'=>$drzave,
                'trosMesta'=>$trosMesta
            ]);

    }


    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $requestData = $request->all();
        $user = $this->radniciRepositoryInterface->createUser($requestData);
        if($user){
        return redirect()->route('radnici.index');
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

        $userId = $request->radnikId;
        $user = User::findOrFail($userId);
        $status = $user->update($requestData);

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
