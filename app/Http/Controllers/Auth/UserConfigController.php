<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\UserRoles;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserConfigController extends Controller
{

    public function __construct(
        readonly private OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
        private readonly PermesecnatabelapoentRepositoryInterface $permesecnatabelapoentInterface

    )
    {
    }

    public function permissionsConfig()
    {
        $orgCeline= $this->organizacionecelineInterface->getAll();
        $userData =User::with('permission')->find(Auth::id());
        $poenterPermission  = json_decode($userData->permission->troskovna_mesta_poenter,true);
        return view('auth.user-permissions-config',
            [
                'userData' => $userData,
                'permissions'=>$userData->permission,
                'organizacioneCeline'=>$orgCeline,
                'poenterPermission'=>$poenterPermission
            ]);
    }

    public function permissionsUpdate(Request $request)
    {
        $input = $request->all();
       $userPermission = UserPermission::where('user_id',$input['user_id'])->first();
        $userPermissionFields =$userPermission->getFillable();
        $permissionData=[];

        foreach ($userPermissionFields as $key =>$data){

            if(!in_array($data,['user_id','user_permissions_id','role_name'])) {
                if (isset($input[$data])) {
                    $permissionData[$data] = true;
                } else {
                    $permissionData[$data] = false;
                }
            }

        }
        $userPermission->update($permissionData);
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     */


    public function index()
    {

        $permissionConstants =UserRoles::all();
        $users = User::with('permission')->get();

        $userData = [];
        foreach ($users as $user) {
            if($user->permission !==null){
            $roleId=$user->permission->role_id;
            if($roleId){
                $userData[] = [
                    $user->maticni_broj,
                    $user->prezime,
                    $user->ime,
                    $permissionConstants[$roleId],
                    $user->datum_odlaska,
                    $user->active,
                    $user->id
                ];
            }
            }

        }

        return view('users.user_show_all', ['users' => json_encode($userData)]);
    }


    public function permissionsConfigByUserId(Request $request)
    {
        $orgCeline= $this->organizacionecelineInterface->getAll();
        $userData =User::with('permission')->find($request->user_id);
        $poenterPermission  = json_decode($userData->permission->troskovna_mesta_poenter,true);
        $poenterPermissionOdgovornost = $this->permesecnatabelapoentInterface->where('status',1)->get();

        return view('auth.user-permissions-config', [
            'userData' => $userData,
            'permissions'=>$userData->permission,
            'organizacioneCeline'=>$orgCeline,
            'poenterPermission'=>$poenterPermission,
            'poenterPermissionOdgovornost'=>$poenterPermissionOdgovornost
        ],         );
    }

    public function permissionsUpdatePoenter(Request $request)
    {
        $input = $request->all();
        $userPermission = UserPermission::where('user_id',$input['user_id'])->first();
        $userPermissionFields =$userPermission->getFillable();
        $permissionData=[];

        foreach ($userPermissionFields as $key =>$data){

            if(!in_array($data,['user_id','user_permissions_id','role_name'])) {
                if (isset($input[$data])) {
                    $permissionData[$data] = true;
                } else {
                    $permissionData[$data] = false;
                }
            }

        }
        $troskovnaMestaPoenter = $this->updateTroskovnaMestaData($request->input('troskovna_mesta_data'));
        $permissionData['troskovna_mesta_poenter'] = $troskovnaMestaPoenter;
        $permissionData['role_id'] = $input['role_id'];
        $userPermission->update($permissionData);

        $this->updateTroskovnaMestaDataOdgovornosti($request->input('troskovna_mesta_data_odgovornost'),$input['user_id']);
        return redirect()->back()->with('success','Uspesno azurirani pristupi');
    }

    private function updateTroskovnaMestaDataOdgovornosti($ukljucenaTroskovnaMesta,$user_id){
        $organizacioneCelineData = $this->permesecnatabelapoentInterface->where('status',1)->get()->keyBy('organizaciona_celina_id');

        $userId=(int)$user_id;
        if($ukljucenaTroskovnaMesta==null) {
            $ukljucenaTroskovnaMesta = ['iskljuci'=>1];
        }
        $ukljucenaTroskovnaMestaIds=array_keys($ukljucenaTroskovnaMesta);
        foreach ($organizacioneCelineData as $orgCelina){

            if(in_array($orgCelina->organizaciona_celina_id,$ukljucenaTroskovnaMestaIds)){
                $test='test';



            $test='test';

            $poenterJsonData = json_decode($orgCelina->poenteri_ids, true);
            $poenterStatusjsonData = json_decode($orgCelina->poenteri_status, true);


            // da li user postoji


                if(in_array($userId,$poenterJsonData)){

                    $test='test';
                }else{
                    $poenterJsonData[]=(int)$userId;
                    $poenterStatusjsonData[$userId]=0;
                }

            $orgCelina->poenteri_ids = json_encode($poenterJsonData);
            $orgCelina->poenteri_status = json_encode($poenterStatusjsonData);
            $orgCelina->save();


            }else{
                // iskljuci ako nema
                $poenterJsonData = json_decode($orgCelina->poenteri_ids, true);
                $poenterStatusjsonData = json_decode($orgCelina->poenteri_status, true);


                // da li user postoji


                if(in_array($userId,$poenterJsonData)){
               $testtt='test';


                    unset($poenterStatusjsonData[$userId]);

                $key = array_search($userId, $poenterJsonData);

                if ($key !== false) {
                    unset($poenterJsonData[$key]);
                }

                    $test='test';
                }else{
//                    $poenterJsonData[]=(int)$userId;
//                    $poenterStatusjsonData[$userId]=0;

                }

                $orgCelina->poenteri_ids = json_encode($poenterJsonData);
                $orgCelina->poenteri_status = json_encode($poenterStatusjsonData);

                $orgCelina->save();
            }
        }



    }
    private function updateTroskovnaMestaData($data){

        $orgCeline= $this->organizacionecelineInterface->getAll();
//        $orgCelineNew = json_decode($data,true);
        $orgCelineUpdate = [];
        foreach ($orgCeline->toArray() as $troskMestoSifra =>$troskMesto){
            $test='test';

            if(isset($data[$troskMesto['id']]) && $data[$troskMesto['id']] =='on'){
                $orgCelineUpdate[$troskMesto['id']]= true;
            }else{
                $orgCelineUpdate[$troskMesto['id']]= false;
            }

        }

        return json_encode($orgCelineUpdate);
    }
}
