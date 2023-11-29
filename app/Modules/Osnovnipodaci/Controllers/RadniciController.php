<?php

namespace App\Modules\Osnovnipodaci\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Osnovnipodaci\Repository\RadniciRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class RadniciController extends Controller
{

    public function __construct(private readonly RadniciRepositoryInterface $radniciRepositoryInterface)
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

        $users = User::all();

        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                $user->ime,
                $user->prezime,
                $user->email,
                $user->datum_odlaska,
                $user->active,
                $user->id
            ];
        }

        return view('osnovnipodaci::radnici.radnici_index', ['users' => json_encode($userData)]);
    }


    public function edit(Request $request)
    {
        $userId = $request->radnikId;

       $radnik =  User::findOrFail($userId);
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


        return view('osnovnipodaci::radnici.radnici_edit',
            [
                'radnik' => $radnik,
                'gradovi' => $gradovi,
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

    public function findByMat(Request $request)
    {
        $inputString = $request->q;


//                $test = User::where('maticni_broj', 'like', '%' . $inputString . '%')
//            ->orWhere('ime', 'like', '%' . $inputString . '%')->get();
//        $data2 = $this->radniciRepositoryInterface->likeOrLike('maticni_broj','prezime',$inputString);


        $userCollection = $this->radniciRepositoryInterface->like('maticni_broj', $inputString);
        $result = $userCollection->map(function ($item) {
            return ['id' => $item['id'], 'text' => $item['maticni_broj'] . ' - ' . $item['prezime'] . ' ' . $item['ime'] . ' - jmbg: ' . $item['jmbg']];
        });

        return response()->json($result);
    }


    public function getById(Request $request){

        $userId = $request->radnikId;
        $userData = $this->radniciRepositoryInterface->getById($userId);
        $userArray = $userData->toArray();
        return response()->json($userArray);
    }
//interni_maticni_broj
//maticni_broj
}
