<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index(Request $request){
        return "Nemate pristup modulu"; // TODO add page and back button

    }
}
