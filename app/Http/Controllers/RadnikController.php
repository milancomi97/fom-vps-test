<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Session;


class RadnikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::all();

        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                $user->internal_sifra,
                $user->name,
                $user->short_name,
                $user->pib,
                $user->active,
                $user->email,
                $user->web_site,
                $user->id
            ];
        }

        return view('users.user_show_all', ['users' => json_encode($userData)]);
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

        $checkPartner = $this->checkForDuplicates($input);
        if (!$checkPartner) {
            $partner = Partner::create([
                PartnerFields::FIELD_ADDRESS->value => $input[PartnerFields::FIELD_ADDRESS->value],
                PartnerFields::FIELD_CONTACT_EMPLOYEE->value => $input[PartnerFields::FIELD_CONTACT_EMPLOYEE->value],
                PartnerFields::FIELD_EMAIL->value => $input[PartnerFields::FIELD_EMAIL->value],
                PartnerFields::FIELD_MATICNI_BROJ->value => $input[PartnerFields::FIELD_MATICNI_BROJ->value],
                PartnerFields::FIELD_MESTO->value => intval($input[PartnerFields::FIELD_MESTO->value]),
                PartnerFields::FIELD_NAME->value => $input[PartnerFields::FIELD_NAME->value],
                PartnerFields::FIELD_ODGOVORNO_LICE->value => $input[PartnerFields::FIELD_ODGOVORNO_LICE->value],
                PartnerFields::FIELD_PHONE->value => $input[PartnerFields::FIELD_PHONE->value],
                PartnerFields::FIELD_PIB->value => $input[PartnerFields::FIELD_PIB->value],
                PartnerFields::FIELD_PRIPADA_PDVU->value => $input[PartnerFields::FIELD_PRIPADA_PDVU->value] == 'true',
                PartnerFields::FIELD_SHORTNAME->value => $input[PartnerFields::FIELD_SHORTNAME->value],
                PartnerFields::FIELD_SIFRA_DELATNOSTI->value => $input[PartnerFields::FIELD_SIFRA_DELATNOSTI->value],
                PartnerFields::FIELD_WEB_SITE->value => $input[PartnerFields::FIELD_WEB_SITE->value],
                PartnerFields::FIELD_ADDRESS->value => $input[PartnerFields::FIELD_ADDRESS->value],
                PartnerFields::FIELD_ACTIVE->value => $input[PartnerFields::FIELD_ACTIVE->value] == 'true',
                PartnerFields::FIELD_INTERNAL_SIFRA->value => $input[PartnerFields::FIELD_INTERNAL_SIFRA->value]
            ]);
            Session::flash('message', 'Partner:  ' . $partner->name . '  je uspešno kreiran.');
        }

        return $checkPartner;

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
        return view('partneri.edit_partner', ['partner' => $partner]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $input = $request->all();
        $partner->update([
            PartnerFields::FIELD_ADDRESS->value => $input[PartnerFields::FIELD_ADDRESS->value],
            PartnerFields::FIELD_CONTACT_EMPLOYEE->value => $input[PartnerFields::FIELD_CONTACT_EMPLOYEE->value],
            PartnerFields::FIELD_EMAIL->value => $input[PartnerFields::FIELD_EMAIL->value],
            PartnerFields::FIELD_MATICNI_BROJ->value => $input[PartnerFields::FIELD_MATICNI_BROJ->value],
            PartnerFields::FIELD_MESTO->value => intval($input[PartnerFields::FIELD_MESTO->value]),
            PartnerFields::FIELD_NAME->value => $input[PartnerFields::FIELD_NAME->value],
            PartnerFields::FIELD_ODGOVORNO_LICE->value => $input[PartnerFields::FIELD_ODGOVORNO_LICE->value],
            PartnerFields::FIELD_PHONE->value => $input[PartnerFields::FIELD_PHONE->value],
//                PartnerFields::FIELD_PIB->value => $input[PartnerFields::FIELD_PIB->value],
            PartnerFields::FIELD_PRIPADA_PDVU->value => $input[PartnerFields::FIELD_PRIPADA_PDVU->value] == 'true',
            PartnerFields::FIELD_SHORTNAME->value => $input[PartnerFields::FIELD_SHORTNAME->value],
            PartnerFields::FIELD_SIFRA_DELATNOSTI->value => $input[PartnerFields::FIELD_SIFRA_DELATNOSTI->value],
            PartnerFields::FIELD_WEB_SITE->value => $input[PartnerFields::FIELD_WEB_SITE->value],
            PartnerFields::FIELD_ADDRESS->value => $input[PartnerFields::FIELD_ADDRESS->value],
            PartnerFields::FIELD_ACTIVE->value => $input[PartnerFields::FIELD_ACTIVE->value] == 'true'
//                PartnerFields::FIELD_INTERNAL_SIFRA->value => $input[PartnerFields::FIELD_INTERNAL_SIFRA->value]
        ]);
        Session::flash('message', 'Partner:  ' . $partner->name . '  je uspešno izmenjen.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $status = Partner::destroy($request->partner_id);

        if ($status) {
            return response()->json([
                'status' => (bool)$status
            ], 200);
        } else {
            return response()->json([
                'status' => (bool)$status
            ], 404);
        }

    }

    private function checkForDuplicates($data)
    {
        $uniqueFields = [
            PartnerFields::FIELD_INTERNAL_SIFRA->value,
            PartnerFields::FIELD_PIB->value
        ];

        foreach ($uniqueFields as $field) {
            $partner = Partner::where($field, $data[$field])->get();
            if (count($partner)) {
                return [
                    'status' => false,
                    'duplicateFieldName' => $field =='pib'?'PIB':'Interna šifra',
                    'duplicateFieldValue' => $data[$field],
                    'duplicateRecordNameValue' => $partner->first()->name,
                    'duplicateRecordId' => $partner->first()->id
                ];
            }
        }

        return false;
    }
}
