<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMaterijalRequest;
use App\Models\Materijal;
use Illuminate\Http\Request;

class MaterijalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materijals = Materijal::all();

        $materijalData = [];
        foreach ($materijals as $materijal) {
            $materijalData[] = [
                $materijal->category_id,
                $materijal->sifra_materijala,
                $materijal->naziv_materijala,
                $materijal->standard,
                $materijal->dimenzija,
                $materijal->tezina,
                $materijal->sifra_standarda,
                $materijal->id
            ];
        }

        return view('materijali.materijali_show_all', ['materijals' => json_encode($materijalData)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materijali.create_materijal');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $materijal = Materijal::create([
            'adress' => $input['adress'],
            'contact_employee' => $input['contact_employee'],
            'email' => $input['email'],
            'maticni_broj' => $input['maticni_broj'],
            'mesto' => intval($input['mesto']),
            'name' => $input['name'],
            'odgovorno_lice' => $input['odgovorno_lice'],
            'phone' => $input['phone'],
            'pib' => $input['pib'],
            'pripada_pdvu' => $input['pripada_pdvu'] == 'true',
            'registarski_broj' => $input['registarski_broj'],
            'short_name' => $input['short_name'],
            'sifra_delatnosti' => $input['sifra_delatnosti'],
            'web_site' => $input['web_site'],
            'adress' => $input['adress'],
            'active' => $input['active'] == 'true',
            'internal_sifra' => $input['internal_sifra']
        ]);


        return  ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Materijal $materijal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materijal $materijal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterijalRequest $request, Materijal $materijal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $status = Materijal::destroy($request->materijal_id);

        if($status){
            return  response()->json([
                'status' => (bool) $status
            ], 200);
        }else{
            return  response()->json([
                'status' => (bool) $status
            ],  404 );
        }

    }
}
