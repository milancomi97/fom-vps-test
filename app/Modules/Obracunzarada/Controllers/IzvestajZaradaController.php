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



    public function ranglistazarade(Request $request)
    {

        $obracunskiKoeficijentId = $request->month_id;

        $dkopData =$this->obradaDkopSveVrstePlacanjaInterface->where('obracunski_koef_id',$obracunskiKoeficijentId)->get();
        $zaraData =  $this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id',$obracunskiKoeficijentId)->get();

        $orgCelineData = $this->organizacionecelineInterface->getAll()->mapWithKeys(function($orgCelina){
            return [
                $orgCelina->id=>$orgCelina->toArray()
            ];
        })
        ;
       $groupedZara = $zaraData->map(function($zaraRadnik) use($orgCelineData){
           $zaraRadnik['org_celina_data']= $orgCelineData[$zaraRadnik['organizaciona_celina_id']];
           return $zaraRadnik;
       })->groupBy('organizaciona_celina_id')->sortBy('organizaciona_celina_id');

        return view('obracunzarada::izvestaji.ranglista_zarade',['groupedZara'=>$groupedZara]);
    }

    public function rekapitulacijazarade(Request $request)
    {

        $obracunskiKoeficijentId = $request->month_id;

        $dkopData =$this->obradaDkopSveVrstePlacanjaInterface
            ->where('obracunski_koef_id',$obracunskiKoeficijentId)
            ->orderBy('sifra_vrste_placanja')
            ->groupBy('sifra_vrste_placanja','naziv_vrste_placanja')
            ->selectRaw('sifra_vrste_placanja,naziv_vrste_placanja, SUM(iznos) as iznos, SUM(sati) as sati')
            ->get();


        $zaraData =$this->obradaZaraPoRadnikuInterface->where('obracunski_koef_id',$obracunskiKoeficijentId)
            ->selectRaw('
        SUM(IZNETO_zbir_ukupni_iznos_naknade_i_naknade) AS IZNETO_zbir_ukupni_iznos_naknade_i_naknade,
        SUM(SID_ukupni_iznos_doprinosa) AS SID_ukupni_iznos_doprinosa,
        SUM(SIP_ukupni_iznos_poreza) AS SIP_ukupni_iznos_poreza,
        SUM(SIOB_ukupni_iznos_obustava) AS SIOB_ukupni_iznos_obustava,
        SUM(ZARKR_ukupni_zbir_kredita) AS ZARKR_ukupni_zbir_kredita,
        SUM(POROSL_poresko_oslobodjenje) AS POROSL_poresko_oslobodjenje,
        SUM(NETO_neto_zarada) AS NETO_neto_zarada,
        SUM(PIOR_penzijsko_osiguranje_na_teret_radnika) AS PIOR_penzijsko_osiguranje_na_teret_radnika,
        SUM(ZDRR_zdravstveno_osiguranje_na_teret_radnika) AS ZDRR_zdravstveno_osiguranje_na_teret_radnika,
        SUM(ONEZR_osiguranje_od_nezaposlenosti_teret_radnika) AS ONEZR_osiguranje_od_nezaposlenosti_teret_radnika,
        SUM(PIOP_penzijsko_osiguranje_na_teret_poslodavca) AS PIOP_penzijsko_osiguranje_na_teret_poslodavca,
        SUM(ZDRP_zdravstveno_osiguranje_na_teret_poslodavca) AS ZDRP_zdravstveno_osiguranje_na_teret_poslodavca
    ')->first();
        return view('obracunzarada::izvestaji.rekapitulacija_zarade',['dkopData'=>$dkopData,'zaraData'=>$zaraData]);
    }


}
