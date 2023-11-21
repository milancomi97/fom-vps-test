<?php

namespace App\Modules\Osnovnipodaci\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Osnovnipodaci\Repository\OpstineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;

class FirmaController extends Controller
{

    /**
     * @param PodaciofirmiRepositoryInterface $podaciofirmiInterface
     */
    public function __construct(
        private readonly PodaciofirmiRepositoryInterface $podaciofirmiInterface,
        private readonly OpstineRepositoryInterface $opstineInterface
    )
    {
    }


    public function view()
    {


        return view('osnovnipodaci::firma.firma_view');
    }


    public function edit()
    {
        $firma = $this->podaciofirmiInterface->getAll();
        $drzave = $this->opstineInterface->getSelectOptionData();


        return view('osnovnipodaci::firma.firma_edit', ['firma' => $firma->first(),'drzave'=>$drzave]);

    }

    public function update(Request $request)
    {
        return  $this->podaciofirmiInterface->createCompany($request->all());
    }
}
