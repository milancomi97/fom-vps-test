<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index(Request $request){

        $ipAdresa = $request->ip();
        $userAgent = $request->server('HTTP_USER_AGENT');
        $platform = $request->server('HTTP_SEC_CH_UA_PLATFORM');


        return "Nemate pristup modulu" ."<br>"."IP adressa: ".$ipAdresa."<br>"."User agent: ".$userAgent."<br>"."Platform: ".$platform; // TODO add page and back button

    }
}
