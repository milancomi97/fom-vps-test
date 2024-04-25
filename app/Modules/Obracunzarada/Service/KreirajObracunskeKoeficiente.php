<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;

class KreirajObracunskeKoeficiente
{
    public function __construct(
        private readonly MesecnatabelapoentazaRepositoryInterface  $mesecnatabelapoentazaInterface,
        private readonly RadniciRepository                         $radniciInterface,
        private readonly VrsteplacanjaRepositoryInterface          $vrsteplacanjaInterface,
        private readonly OrganizacionecelineRepositoryInterface    $organizacionecelineInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly DpsmPoentazaslogRepositoryInterface        $dpsmPoentazaslogInterface,

    )
    {
    }

    public function otvoriAktivneRadnike($datotekaobracunskihkoeficijenata)
    {

        // 1. Svi aktivni
        // 2. Dodeli
        // Dodati logiku koja radi update za vrste placanja  || Varijablina
        // Dodati logiku za akontacije
        // Optimizovati logiku sa sto manje querija i ako moze kroz jedan foreach, i da ide kroz array/kolekcija umesto Queru
        $radnici = $this->radniciInterface->getAllActive();

        $vrstePlacanja = $this->getPoenterVrstePlacanjaInitData($datotekaobracunskihkoeficijenata);

        $placanja = [];

        foreach ($radnici as $key => $radnik) {
            if (isset($radnik->maticnadatotekaradnika->id)) {

                if ($radnik->sifra_mesta_troska_id > 0) {

                    $data[] = [
                        'organizaciona_celina_id' => $radnik->sifra_mesta_troska_id,
//                    'vrste_placanja' => $vrstePlacanja,
                        'vrste_placanja' => $vrstePlacanja,
                        'user_id' => $radnik->id,
                        'datum' => $datotekaobracunskihkoeficijenata->datum->format('Y-m-d'),
                        'maticni_broj' => $radnik->maticni_broj,
                        'ime' => $radnik->ime,
                        'prezime' => $radnik->prezime,
                        'srednje_ime' => $radnik->srednje_ime,
                        'obracunski_koef_id' => $datotekaobracunskihkoeficijenata->id,
                        'status_poentaze' => 1,
                        'user_mdr_id' => $radnik->maticnadatotekaradnika->id
                    ];
                }

            }
        }

        return $data;
    }


    private function updateVrstePlacanja($vrstePlacanja, $datotekaobracunskihkoeficijenata)
    {
        $vrstePlacanjaUpdated = [];
        foreach ($vrstePlacanja as $placanje) {

            if ($placanje['key'] == '001' || $placanje['key'] == '019') {
                $placanje['sati'] = (int)$datotekaobracunskihkoeficijenata->mesecni_fond_sati;
                $placanje['iznos'] = '';
                $placanje['procenat'] = '';
                $placanje['RJ_radna_jedinica'] = '';
                $placanje['BRIG_brigada'] = '';
            }

            $vrstePlacanjaUpdated[] = $placanje;
        }

        return $vrstePlacanjaUpdated;

    }

    private function addAkontacijaInitial($vrstePlacanjaUpdated, $datotekaobracunskihkoeficijenata)
    {

        $akontacijaVrstaPlacanja = $this->vrsteplacanjaInterface->where('rbvp_sifra_vrste_placanja', '061')->first();
        $vrstePlacanjaUpdated[] = [
            'key' => '061',
            'sati' => 0,
            'id' => $akontacijaVrstaPlacanja->id,
            'name' => strtolower(str_replace(' ', '_', $akontacijaVrstaPlacanja->naziv_naziv_vrste_placanja)),
            'iznos' => (int)$datotekaobracunskihkoeficijenata->vrednost_akontacije,
            'procenat' => '',
            'RJ_radna_jedinica' => '',
            'BRIG_brigada' => ''
        ];

        return $vrstePlacanjaUpdated;

    }

    private function updateRadnaJedinicaBrigada($vrstePlacanja, $radnik)
    {
        //
        $vrstePlacanjaUpdated = [];
        foreach ($vrstePlacanja as $placanje) {
            $placanje['RJ_radna_jedinica'] = $radnik->maticnadatotekaradnika->RJ_radna_jedinica;
            $placanje['BRIG_brigada'] = $radnik->maticnadatotekaradnika->BRIG_brigada;
            $vrstePlacanjaUpdated[] = $placanje;
        }

        return json_encode($vrstePlacanjaUpdated);
    }

    public function getPoenterVrstePlacanjaInitData($datotekaobracunskihkoeficijenata)
    {
        $data = $this->vrsteplacanjaInterface->getAll()->sortBy('redosled_poentaza_zaglavlje')->take(19);
        // Prvo sortiraj pa onda kada dodjes do 19, prestani
        // Treba da bude 19

        $fondSati = $datotekaobracunskihkoeficijenata->mesecni_fond_sati;
        $fondSatiPraznika = $datotekaobracunskihkoeficijenata->mesecni_fond_sati_praznika;

        $filteredData = $data->map(function ($item) use ($fondSati, $fondSatiPraznika) {

            $newValue = strtolower(str_replace(' ', '_', $item['naziv_naziv_vrste_placanja']));
            $mesecniFondSati = 0;


            if ($item['rbvp_sifra_vrste_placanja'] == '003' && $fondSatiPraznika !== null) {
                $mesecniFondSati == $fondSatiPraznika;
            }


            if ($item['rbvp_sifra_vrste_placanja'] == '001' || $item['rbvp_sifra_vrste_placanja'] == '019') {
                // Uslovi za otvaranje radnika varijabilna vrste placanja poenterska
                $mesecniFondSati = (int)$fondSati;
            }

            // Otvaranje praznih Vrsta placanja
            return $item['id'] = [
                'key' => $item['rbvp_sifra_vrste_placanja'],
                'name' => $newValue,
                'sati' => $mesecniFondSati,
                'id' => $item['id'],
                'iznos' => '',
                'procenat' => '',
                'RJ_radna_jedinica' => '',
                'BRIG_brigada' => '',
                'redosled_poentaza_zaglavlje' => $item['redosled_poentaza_zaglavlje']
            ];
        });
        return $filteredData;
    }


    public function dodeliPocetnaPoenterPlacanja($idsRadnika, $mesecniFondSati, $mesecId)
    {

        $data = [];
        foreach ($idsRadnika as $radnik) {
            $data[] = [
                'user_dpsm_id' => $radnik->id,
                'sati' => $mesecniFondSati,
                'maticni_broj' => $radnik->maticni_broj,
                'sifra_vrste_placanja' => '001',
                'obracunski_koef_id' => $mesecId
            ];
            $data[] = [
                'user_dpsm_id' => $radnik->id,
                'sati' => $mesecniFondSati,
                'maticni_broj' => $radnik->maticni_broj,
                'sifra_vrste_placanja' => '019',
                'obracunski_koef_id' => $mesecId
            ];
        }
        return $data;

    }

    public function dodeliPocetneAkontacijePlacanja($idsRadnika, $vrednostAkontacije, $mesecId)
    {

        $data = [];
        foreach ($idsRadnika as $radnik) {
            $data[] = [
                'user_dpsm_id' => $radnik->id,
                'iznos' => $vrednostAkontacije,
                'maticni_broj' => $radnik->maticni_broj,
                'sifra_vrste_placanja' => '019',
                'obracunski_koef_id' => $mesecId

            ];
        }
        return $data;
    }

    public function otvoriAktivneRadnikeImport($datotekaobracunskihkoeficijenata, $varijabilneVrtsePlacanjaReader,$vrstePlacanjaSifarnik)
    {
        $varijabilneVrtsePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAll()->sortBy('redosled_poentaza_zaglavlje')->take(19);
        $vrstePlacanjaPoenterIds = $varijabilneVrtsePlacanjaSifarnik->pluck('rbvp_sifra_vrste_placanja')->toArray();

        $vrstaPlacanjaRadnik = [];
        $varijabilneVrtsePlacanja = [];

        $radnikNewData=[];


        foreach ($varijabilneVrtsePlacanjaReader as $vrstaPlacanja) {
            $varijabilneVrtsePlacanja[] = $vrstaPlacanja;
        }
        $testCounter = 0;
        $collectRadnikGroup = collect($varijabilneVrtsePlacanja)->groupBy('MBRD');

        foreach ($collectRadnikGroup as $radnik) {
            $nonPoenterVarijabilneVrsteP = [];
            $PoenterVarijabilneVrsteP = [];

//            $mdr->loadWhere MBRD_maticni_broj $radnik['MBRD'];
            $radnikMdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj', $radnik[0]['MBRD'])->first()->toArray();

            foreach ($radnik as $vrstaPlacanja) {
                $sifraVrstePlacanja = $vrstaPlacanja['RBVP'];
                if (in_array($sifraVrstePlacanja, $vrstePlacanjaPoenterIds)) {
                    $PoenterVarijabilneVrsteP[] = $vrstaPlacanja;
                } else {
                    $nonPoenterVarijabilneVrsteP[] = $vrstaPlacanja;
                }
                $testCounter++;
                $test = 'test';
            }


            try {
                $radnikNewData[] = $this->initRadnikVariabilnaAndUpdate($PoenterVarijabilneVrsteP, $varijabilneVrtsePlacanjaSifarnik, $radnikMdrData,$datotekaobracunskihkoeficijenata);

            }catch (\Exception $exception){
                $test='Test';
            }

           if($nonPoenterVarijabilneVrsteP){
               foreach ($nonPoenterVarijabilneVrsteP as $nonPoVarVrstaP){
                   $test='test';


                   $data = [
////                       'user_dpsm_id' => (int)$userMonthId,
                       'sifra_vrste_placanja' => $nonPoVarVrstaP['RBVP'],
                       'naziv_vrste_placanja' => $vrstePlacanjaSifarnik[$nonPoVarVrstaP['RBVP']]['naziv_naziv_vrste_placanja'],
                       'sati' => (int) $nonPoVarVrstaP['SATI'] ?? 0,
                       'iznos' => (float) $nonPoVarVrstaP['IZNO'] ?? 0,
                       'procenat' => (int) $nonPoVarVrstaP['PERC'] ?? 0,
                       'user_mdr_id' => $radnikMdrData['id'],
                       'obracunski_koef_id' => $datotekaobracunskihkoeficijenata['id'],
                       'maticni_broj'=>$nonPoVarVrstaP['MBRD']
                   ];
                   $this->dpsmPoentazaslogInterface->create($data);
               }


           }


        }

        return $radnikNewData;
    }

    /**
     * @throws \Exception
     */
    public function initRadnikVariabilnaAndUpdate($PoenterVarijabilneVrsteP,$varijabilneVrtsePlacanjaSifarnik, $radnikMdrData, $mesecData)
    {

        $data=[];

        $vrstePlacanja=[];

        foreach ($varijabilneVrtsePlacanjaSifarnik as $initVrstaPlacanja) {
            $newValue = strtolower(str_replace(' ', '_', $initVrstaPlacanja['naziv_naziv_vrste_placanja']));

            $sati =0;
            foreach ($PoenterVarijabilneVrsteP as $poenterImportVrstaP){

                if($poenterImportVrstaP['RBVP']==$initVrstaPlacanja->rbvp_sifra_vrste_placanja){
                    $sati = $poenterImportVrstaP['SATI'];
                }
                $test="test";
            }
            $vrstePlacanja[$initVrstaPlacanja['id']] = [
                'key' => $initVrstaPlacanja['rbvp_sifra_vrste_placanja'],
                'name' => $newValue,
                'sati' => (int) $sati,
                'id' => $initVrstaPlacanja['id'],
                'iznos' => 0,
                'procenat' => '',
                'RJ_radna_jedinica' => '',
                'BRIG_brigada' => '',
                'redosled_poentaza_zaglavlje' => $initVrstaPlacanja['redosled_poentaza_zaglavlje']
            ];

        }

                   return [
                        'organizaciona_celina_id' => $radnikMdrData['troskovno_mesto_id'],
                        'vrste_placanja'=> json_encode($vrstePlacanja),
                        'user_id' => $radnikMdrData['user_id'],
                        'datum' => $mesecData->datum,
                        'maticni_broj' => $radnikMdrData['MBRD_maticni_broj'],
                        'ime' => $radnikMdrData['IME_ime'],
                        'prezime' => $radnikMdrData['PREZIME_prezime'],
//                        'srednje_ime' => $radnik->srednje_ime,
                        'obracunski_koef_id' => $mesecData->id,
                        'status_poentaze' => 1,
                        'user_mdr_id' => $radnikMdrData['id'],
                    ];
    }

}
