<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Consts\StatusRadnikaObracunskiKoef;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Service\ObradaObracunavanjeService;
use App\Modules\Obracunzarada\Service\PripremiPermisijePoenteriOdobravanja;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;

class IzvestajZaradaController extends Controller
{

    public function __construct(
        private readonly ObradaObracunavanjeService                          $obradaObracunavanjeService,
        private readonly VrsteplacanjaRepositoryInterface                    $vrsteplacanjaInterface,
        private readonly PodaciofirmiRepositoryInterface                     $podaciofirmiInterface,
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface       $obradaDkopSveVrstePlacanjaInterface,
        private readonly ObradaZaraPoRadnikuRepositoryInterface              $obradaZaraPoRadnikuInterface,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly PripremiPermisijePoenteriOdobravanja $pripremiPermisijePoenteriOdobravanja,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly ObradaKreditiRepositoryInterface $obradaKreditiInterface,
        private readonly OrganizacionecelineRepositoryInterface $organizacionecelineInterface,
    )
    {
    }

    public function rekapitulacijazarade()
    {
        return view('obracunzarada::izvestaji.rekapitulacija_zarade');
    }

    public function ranglistazarade()
    {
        return view('obracunzarada::izvestaji.ranglista_zarade');
    }


}
