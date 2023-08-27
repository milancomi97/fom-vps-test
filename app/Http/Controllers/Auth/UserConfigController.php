<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserConfigController extends Controller
{

    public function permissionsConfig()
    {
        $userData =User::with('permission')->find(Auth::id());
        return view('auth.user-permissions-config', ['userData' => $userData,'permissions'=>$userData->permission]);
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

        return view('users.user_show_all', ['users' => json_encode($userData)]);
    }


    public function permissionsConfigByUserId(Request $request)
    {
        $userData =User::with('permission')->find($request->user_id);
        return view('auth.user-permissions-config', ['userData' => $userData,'permissions'=>$userData->permission]);
    }


}
