<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePartnerRequest;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partners = Partner::all();

        $partnerData = [];
        foreach ($partners as $partner) {
            $partnerData[] = [
                $partner->internal_sifra, // TODO ostaje
                $partner->name, // TODO ostaje
                $partner->short_name, // TODO ostaje
                $partner->pib,// TODO ostaje
                $partner->active, // TODO ostaje
                $partner->email, // TODO ostaje
                $partner->web_site, // TODO ostaje
                $partner->id
            ];
        }

        return view('partneri.partneri_show_all', ['partners' => json_encode($partnerData)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partneri.create_partner');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $partner = Partner::create([
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
    public function show(Partner $partner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $status = Partner::destroy($request->partner_id);

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
