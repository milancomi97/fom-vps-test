<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index(Request $request){

        $ipAdresa = $request->ip();
        $userAgent = $request->server('HTTP_USER_AGENT');
        $platform = $request->server('HTTP_SEC_CH_UA_PLATFORM');


        return view('no_permission');

    }
}
