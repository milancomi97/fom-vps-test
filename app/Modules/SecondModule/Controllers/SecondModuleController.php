<?php

namespace Modules\SecondModule\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SecondModule;
use Illuminate\Http\Request;

class SecondModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('secondmodule::secondmodule.create_secondmodule');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('secondmodule.create_secondmodule');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SecondModule $secondmodule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SecondModule $secondmodule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SecondModule $secondmodule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SecondModule $secondmodule)
    {
        //
    }
}
