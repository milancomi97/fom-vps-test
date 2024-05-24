<?php

namespace App\Http\Middleware;

use App\Modules\Obracunzarada\Consts\UserRoles;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class CheckUserRole
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);
//        if(Auth::user() !== null){
//            $userData=Auth::user()->load(['permission']);
//            $permissions  =$userData->permission;
//            $path = $request->path();
//            $parts = explode('/', $path);
//            $requiredModule = $parts[0];
//
//            if($requiredModule=='osnovnipodaci' && $permissions->osnovni_podaci == true){
//                return $next($request);
//             } else if ($requiredModule=='osnovnipodaci' && $permissions->osnovni_podaci == true){
//                return $next($request);
//
//            }else if(UserRoles::POENTER==$permissions->role_id){
//
//                    if(isset($parts[0]) && isset($parts[1]) && isset($parts[2]) && $parts[2]=='odobravanje_poenter'){
//                        return $next($request);
//                    }
//                    return redirect('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje_poenter?month_id=1');
//
//            }
//        } else{
////            $userData=Auth::user()->load(['permission']);
////
////            if(){
////
////            }
//
//            return $next($request);
//        }
        return $response;

    }

}
