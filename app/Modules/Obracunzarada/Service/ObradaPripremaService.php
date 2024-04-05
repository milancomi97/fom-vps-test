<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;

class ObradaPripremaService
{
    public function __construct(
        private readonly ObradaFormuleService                   $obradaFormuleService,
        private readonly ObradaZaraPoRadnikuRepositoryInterface $obradaZaraPoRadnikuInterface
    )
    {
    }

    public function pripremiUnosPoentera($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData)
    {

        $cenaRada = (int)$monthData->cena_rada_tekuci;
        $sveVrstePlacanjaPoenteri = [];
        foreach ($data as $radnik) {
            $vrstePlacanjaData = json_decode($radnik->vrste_placanja, true);
            foreach ($vrstePlacanjaData as $key => $vrstaPlacanja) {

                $newPlacanje = [];
                if ($vrstaPlacanja['sati'] !== '' && $vrstaPlacanja['sati'] > 0) {
                    $newPlacanje['sati'] = $vrstaPlacanja['sati'];
                    $newPlacanje['sifra_vrste_placanja'] = $vrstaPlacanja['key'];

                    $mdrData = $radnik->maticnadatotekaradnika;
                    // RADNIK-MESEC
                    $newPlacanje['maticni_broj'] = $radnik['maticni_broj'];
                    $newPlacanje['user_mdr_id'] = $radnik['user_mdr_id'];
                    $newPlacanje['tip_unosa'] = 'poenter_varijabilno';
                    $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];
                    $newPlacanje['user_dpsm_id'] = $radnik['id'];
                    // MDR
                    $newPlacanje['KOEF_osnovna_zarada'] = $mdrData->KOEF_osnovna_zarada;
                    $newPlacanje['RBRM_radno_mesto'] = $mdrData->RBRM_radno_mesto;
                    $newPlacanje['P_R_oblik_rada'] = $mdrData->P_R_oblik_rada;
                    $newPlacanje['RBIM_isplatno_mesto_id'] = $mdrData->RBIM_isplatno_mesto_id;
                    $newPlacanje['troskovno_mesto_id'] = $mdrData->troskovno_mesto_id;
                    // DVPL


                    $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['naziv_naziv_vrste_placanja'];
                    $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['SLOV_grupe_vrsta_placanja'];
                    $newPlacanje['POK2_obracun_minulog_rada'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['POK2_obracun_minulog_rada'];
                    $newPlacanje['KESC_prihod_rashod_tip'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['KESC_prihod_rashod_tip'];

                    // DPOR

                    $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
                    $newPlacanje['iznos'] = $vrstaPlacanja['sati'] * $cenaRada;

                    $sveVrstePlacanjaPoenteri[] = $newPlacanje;
//                }


                }
            }
        }
        return $sveVrstePlacanjaPoenteri;

    }

    public function pripremiFiksnaPlacanja($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik)
    {
        $radnik = $data[0]->maticnadatotekaradnika; // TODO proveriti da li je ovako ili kroz relaciju bolje
        foreach ($data as $key => $vrstaPlacanja) {

            $newPlacanje = [];
            if ($vrstaPlacanja['sati'] !== '' && $vrstaPlacanja['sati'] > 0) {
                $newPlacanje['sati'] = $vrstaPlacanja['sati'];
                $newPlacanje['sifra_vrste_placanja'] = $vrstaPlacanja['sifra_vrste_placanja'];

                // RADNIK-MESEC
                $newPlacanje['maticni_broj'] = $radnik['MBRD_maticni_broj'];
                $newPlacanje['user_mdr_id'] = $radnik['id'];
                $newPlacanje['tip_unosa'] = 'fiksno_placanje';
                $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];
                $newPlacanje['user_dpsm_id'] = $radnik['user_dpsm_id'];
                // MDR
                $newPlacanje['KOEF_osnovna_zarada'] = $radnik->KOEF_osnovna_zarada;
                $newPlacanje['RBRM_radno_mesto'] = $radnik->RBRM_radno_mesto;
                $newPlacanje['P_R_oblik_rada'] = $radnik->P_R_oblik_rada;
                $newPlacanje['RBIM_isplatno_mesto_id'] = $radnik->RBIM_isplatno_mesto_id;
                $newPlacanje['troskovno_mesto_id'] = $radnik->troskovno_mesto_id;
                // DVPL


                $vrstaPlacanjaData = $vrstePlacanjaSifarnik[$vrstaPlacanja['sifra_vrste_placanja']];

                $newPlacanje['naziv_vrste_placanja'] = $vrstaPlacanjaData['naziv_naziv_vrste_placanja'];
                $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstaPlacanjaData['SLOV_grupe_vrsta_placanja'];
                $newPlacanje['POK2_obracun_minulog_rada'] = $vrstaPlacanjaData['POK2_obracun_minulog_rada'];
                $newPlacanje['KESC_prihod_rashod_tip'] = $vrstaPlacanjaData['KESC_prihod_rashod_tip'];

                // DPOR
                $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
//                $this->checkParsingAllFormulas();
                $sveVrstePlacanjaFiksna[] = $newPlacanje;
//                }
//                if($vrstaPlacanja['iznos'] !== ''){
//                    $newPlacanje['iznos'] =$vrstaPlacanja['iznos'];
//                }
//
//                if($vrstaPlacanja['procenat'] !== ''){
//                    $newPlacanje['procenat'] =$vrstaPlacanja['procenat'];
//                }
                $test = "test";
            }
        }
        return $sveVrstePlacanjaFiksna;
    }

    public function pripremiAkontacije($data)
    {
        return $data;
    }

    public function pripremiVarijabilnihPlacanja($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik)
    {
        $radnik = $data[0]->maticnadatotekaradnika;
        foreach ($data as $key => $vrstaPlacanja) {

            $newPlacanje = [];
            if ($vrstaPlacanja['sati'] !== '' && $vrstaPlacanja['sati'] > 0) {
                $newPlacanje['sati'] = $vrstaPlacanja['sati'];
                $newPlacanje['sifra_vrste_placanja'] = $vrstaPlacanja['sifra_vrste_placanja'];

                // RADNIK-MESEC
                $newPlacanje['maticni_broj'] = $radnik['MBRD_maticni_broj'];
                $newPlacanje['user_mdr_id'] = $radnik->id;
                $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];

                $newPlacanje['tip_unosa'] = 'fiksno_placanje';
                $newPlacanje['user_dpsm_id'] = $vrstaPlacanja['user_dpsm_id'];
                // MDR
                $newPlacanje['KOEF_osnovna_zarada'] = $radnik->KOEF_osnovna_zarada;
                $newPlacanje['RBRM_radno_mesto'] = $radnik->RBRM_radno_mesto;
                $newPlacanje['P_R_oblik_rada'] = $radnik->P_R_oblik_rada;
                $newPlacanje['RBIM_isplatno_mesto_id'] = $radnik->RBIM_isplatno_mesto_id;
                $newPlacanje['troskovno_mesto_id'] = $radnik->troskovno_mesto_id;
//                $newPlacanje['user_mdr_id'] = $vrstaPlacanja['user_mdr_id'];
                $newPlacanje['obracunski_koef_id'] = $vrstaPlacanja['obracunski_koef_id'];

                // DVPL


                $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['sifra_vrste_placanja']]['naziv_naziv_vrste_placanja'];
                $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['sifra_vrste_placanja']]['SLOV_grupe_vrsta_placanja'];
                $newPlacanje['POK2_obracun_minulog_rada'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['sifra_vrste_placanja']]['POK2_obracun_minulog_rada'];
                $newPlacanje['KESC_prihod_rashod_tip'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['sifra_vrste_placanja']]['KESC_prihod_rashod_tip'];

                // DPOR

                $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
                $sveVrstePlacanjaVariabilna[] = $newPlacanje;
//                }
//                if($vrstaPlacanja['iznos'] !== ''){
//                    $newPlacanje['iznos'] =$vrstaPlacanja['iznos'];
//                }
//
//                if($vrstaPlacanja['procenat'] !== ''){
//                    $newPlacanje['procenat'] =$vrstaPlacanja['procenat'];
//                }
                $test = "test";
            }
        }
        return $sveVrstePlacanjaVariabilna;
    }

    public function pripremiMinuliRad($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik)
    {

        // TODO add logiku da li firma koristi to
        $minuliRadData = [];

        foreach ($data as $radnik) {
            $vrstePlacanjaData = json_decode($radnik->vrste_placanja, true);

            $newPlacanje = [];

            // RADNIK-MESEC
            $newPlacanje['maticni_broj'] = $radnik['maticni_broj'];
            $newPlacanje['user_mdr_id'] = $radnik['user_mdr_id'];
            $newPlacanje['tip_unosa'] = 'kroz_kod';
            $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnik['id'];
            // MDR
            $newPlacanje['KOEF_osnovna_zarada'] = $radnik->maticnadatotekaradnika->KOEF_osnovna_zarada;
            $newPlacanje['RBRM_radno_mesto'] = $radnik->maticnadatotekaradnika->RBRM_radno_mesto;
            $newPlacanje['P_R_oblik_rada'] = $radnik->maticnadatotekaradnika->P_R_oblik_rada;
            $newPlacanje['RBIM_isplatno_mesto_id'] = $radnik->maticnadatotekaradnika->RBIM_isplatno_mesto_id;
            $newPlacanje['troskovno_mesto_id'] = $radnik->maticnadatotekaradnika->troskovno_mesto_id;
            // DVPL


            $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik['005']['naziv_naziv_vrste_placanja'];
            $newPlacanje['sifra_vrste_placanja'] = $vrstePlacanjaSifarnik['005']['rbvp_sifra_vrste_placanja'];


            $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik['005']['SLOV_grupe_vrsta_placanja'];
            $newPlacanje['POK2_obracun_minulog_rada'] = $vrstePlacanjaSifarnik['005']['POK2_obracun_minulog_rada'];
            $newPlacanje['KESC_prihod_rashod_tip'] = $vrstePlacanjaSifarnik['005']['KESC_prihod_rashod_tip'];
            $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
            $newPlacanje['procenat'] = ((int)$radnik->maticnadatotekaradnika->GGST_godine_staza) * 0.4;
            // TODO 0.4 KOR->MINULI, podaci o firmi

//            $newPlacanje['sifra_vrste_placanja'] = $vrstaPlacanja['key']; // sifra

            // DPOR

//            $newPlacanje['iznos'] = $vrstaPlacanja['sati']; pomnozi

            $minuliRadData[] = $newPlacanje;
//                }
//                if($vrstaPlacanja['iznos'] !== ''){
//                    $newPlacanje['iznos'] =$vrstaPlacanja['iznos'];
//                }
//
//                if($vrstaPlacanja['procenat'] !== ''){
//                    $newPlacanje['procenat'] =$vrstaPlacanja['procenat'];
//                }
            $test = "test";

        }
        return $minuliRadData;
    }

    public function pripremiKredita($data)
    {
        return $data;
    }

    public function pripremaZaraPodatkePoRadnikuBezMinulogRada($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik)
    {
        // KORAK 1
        // PRIPREMA G
        $zaraRadnikData1 = [];
        $groupRadnikData = $data->groupBy('user_mdr_id');

        foreach ($groupRadnikData as $radnik) {
            $gSumiranjeIznosSIZNE = 0;
            $gSumiranjeSatiSSZNE = 0;
            $gSumiranjePrekovremeni = 0;
            $oSumiranjeZaradeSati = 0;
            $oSumiranjeZaradeIznos = 0;
            $oSumiranjeBolovanjaSati = 0;
            $oSumiranjeBolovanjaIznos = 0;

            $sSumiranjeIznosaObustava = 0;
            $topliObrokSati = 0;
            $regresIznos = 0;
            $satiZarade = 0;
            $iznosZarade = 0;
            $prosecniSati = 0;
            $prosecniIznos = 0;
            $mdr = '';
            $efektivniSati = 0;
            $efektivniIznos = 0;
            // PETLJA LOGIKE ZA SUMIRANJE START

            foreach ($radnik as $vrstaPlacanjaSlog) {
//                array_map(function($subArray) {     return isset($subArray['SLOV_grupa_vrste_placanja']) ? $subArray['SLOV_grupa_vrste_placanja'] : null; }, $radnik->toArray());

                if ($vrstaPlacanjaSlog['POK2_obracun_minulog_rada'] == 'G') {
                    $iznos = $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);


                    if ($vrstaPlacanjaSlog['iznos'] !== null) {
                        $gSumiranjeIznosSIZNE += $iznos;
                    }

                    if ($vrstaPlacanjaSlog['sati'] !== null) {
                        $gSumiranjeSatiSSZNE += $vrstaPlacanjaSlog['sati'];
                    }
                }


                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'G') {

                    $gSumiranjePrekovremeni += $vrstaPlacanjaSlog['sati'];
                }


                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] < 'O') {

                    $oSumiranjeZaradeSati += $vrstaPlacanjaSlog['sati'];
                    $oSumiranjeZaradeIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);


                }

                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'O') {

                    $oSumiranjeBolovanjaSati += $vrstaPlacanjaSlog['sati'];
                    $oSumiranjeBolovanjaIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);


                }


                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] > 'S') {

                    $sSumiranjeIznosaObustava += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);
                }

//                if($vrstaPlacanjaSlog['OGRAN_ogranicenje_za_minimalac'] =='1'){
//                    TODO Kasnije logika za minimalac
//                }elseif ($vrstaPlacanjaSlog['OGRAN_ogranicenje_za_minimalac'] =='2'){
//
//                }elseif ($vrstaPlacanjaSlog['OGRAN_ogranicenje_za_minimalac'] =='3'){
//
//                }

                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'L' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'P') {

                    $topliObrokSati += $vrstaPlacanjaSlog['sati'];
                }

                if ($vrstaPlacanjaSlog['sifra_vrste_placanja'] == '058') {

                    $regresIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);

                }


                if ($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '1' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '3') {

                    // PROVERI POK1 Podatak
                    $satiZarade += $vrstaPlacanjaSlog['sati'];

                }

                if ($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '2' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '3' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] !== 'O') {
//                NAKNADNO U IZVESTAJIMA
                    // PROVERI POK1 Podatak
                    $iznosZarade += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);

                }


                if ($vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] == '1' || $vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] == '3') {

                    $prosecniSati += $vrstaPlacanjaSlog['sati'];
                }

                if ($vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] == '2' || $vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] == '3') {
                    $prosecniIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);

                }

//                if($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca']=='2' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca']=='3' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'O'){
////                NAKNADNO U IZVESTAJIMA
//                    // PROVERI POK1 Podatak
//                    $iznosNaknada += $vrstaPlacanjaSlog['iznos'];
//
//                }

                if ($mdr == '') {
                    if (isset($vrstaPlacanjaSlog->maticnadatotekaradnika)) {
                        $mdr = $vrstaPlacanjaSlog->maticnadatotekaradnika->toArray();
                    }
                }

                if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['EFSA_efektivni_sati']) {
                    $efektivniSati += $vrstaPlacanjaSlog['sati'];
                    $efektivniIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);
                }


            }

            // PETLJA LOGIKE ZA SUMIRANJE END

            // LOGIKA ZA PREPISIVANJE i UPISIVANJE SUM START
            $radnik['ZAR'] = [
                'SIZNE' => $gSumiranjeIznosSIZNE + $oSumiranjeZaradeIznos,
                'SSZNE' => $gSumiranjeSatiSSZNE + $oSumiranjeZaradeSati,
                'PREK' => $gSumiranjePrekovremeni,
//                'SSZNE' => $oSumiranjeZaradeSati,
//                'SIZNE' => $oSumiranjeZaradeIznos,
                'SSNNE' => $oSumiranjeBolovanjaSati,
                'SINNE' => $oSumiranjeBolovanjaIznos,
                'SIOB' => $sSumiranjeIznosaObustava,
                'TOPSATI' => $topliObrokSati,
                'REGR' => $regresIznos,
                'sati_zarade' => $satiZarade,
                'iznos_zarade' => $iznosZarade,
                'prosecni_sati' => $prosecniSati,
                'prosecni_iznos' => $prosecniIznos,
                'EFSATI' => $efektivniSati,
                'EFIZNO' => $efektivniIznos,
//                'OGRAN'=> $SumiranjeOgranicenja,
                // TODO dodaj 'PERC'=> MDR->GGST*KOR->MINULI
            ];

//
//            with SSZNE // Sati_za          // SSZNE
//            replace ZAR->SIZNE   with SIZNE //Izn_za   // SIZNE
//            replace ZAR->SIZN    with SIZN // Izn_za    // SIZNE
//            replace ZAR->SSNNE   with  SSNNE
//            replace ZAR->SINNE   with SINNE //Iznos_n  // SINNE
//            replace ZAR->IZNETO  with sizne+sinne
//            replace ZAR->SIOB    with SIOB
//            replace ZAR->REGRES  with REGR
//            replace ZAR->UKNETO  with ZAR->IZNETO     // ZAR->UKNETO SLUZI ZA OBRACUN MINULOG RADA
//            replace ZAR->PRIZ    with  Pr_izn
//            replace ZAR->PRCAS   with Pr_sat
//            replace ZAR->PERC    with MDR->GGST*KOR->MINULI  // MDR->GGST/2       //
//            replace ZAR->PREKOV  with PREK      // PREKOVREMENI RAD
//            replace ZAR->P_R     with MDR->P_R  // P_R_U


//            $radnik['POR'] = ;
            $radnik['MDR'] = $mdr ?? [];
//            $radnik['KOE'] = ;
            // LOGIKA ZA PREPISIVANJE END

        }


        // KORAK 2
        // PRIPREMA K
        // KORISTE SE PODACI OD G

        $groupRadnikDataKorak2 = $this->pripremaZaraPodatkePoRadnikuKorakDva($groupRadnikData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);

        $groupRadnikDataKorak3 = $this->pripremaZaraPodatkePoRadnikuKorakTri($groupRadnikDataKorak2, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);

//        $groupRadnikDataKorak4 = $this->pripremaZaraPodatkePoRadnikuKorakCetiri($groupRadnikDataKorak3, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);

        return $groupRadnikDataKorak3;

    }

    public function pripremaZaraPodatkePoRadnikuKorakDva($groupRadnikData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik)
    {

        $newRadnikData = [];
        foreach ($groupRadnikData as $radnik) {

            $zar = $radnik['ZAR'];

//            $kSumiranjeIznosSIZNNE = $zar['SIZNNE'];
//            $kSumiranjeSatiSSZNNE = $zar['SSZNNE'];
            $oSumiranjeZaradeSati = $zar['SSZNE'];
            $oSumiranjeZaradeIznos = $zar['SIZNE'];
            $gSumiranjePrekovremeni = $zar['PREK'];

            $oSumiranjeBolovanjaSati = $zar['SSNNE'];
            $oSumiranjeBolovanjaIznos = $zar['SINNE'];

            $sSumiranjeIznosaObustava = $zar['SIOB'];
            $topliObrokSati = $zar['TOPSATI'];
            $regresIznos = $zar['REGR'];
            $satiZarade = $zar['sati_zarade'];
            $iznosZarade = $zar['iznos_zarade'];
            $prosecniSati = $zar['sati_zarade'];
            $prosecniIznos = $zar['prosecni_iznos'];
            $mdr = '';
            $efektivniSati = $zar['EFSATI'];
            $efektivniIznos = $zar['EFIZNO'];


            foreach ($radnik as $key => $vrstaPlacanjaSlog) {

                if ($key == 'ZAR' || $key == 'MDR') {
                    continue;
                }


                if ($vrstaPlacanjaSlog['POK2_obracun_minulog_rada'] == 'K') {

                    $iznos = $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);

                    if ($vrstaPlacanjaSlog['iznos'] !== null) {
                        $oSumiranjeZaradeIznos += $iznos;
                    }

                    if ($vrstaPlacanjaSlog['sati'] !== null) {
                        $oSumiranjeZaradeSati += $vrstaPlacanjaSlog['sati'];
                    }
                }

                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'G') {

                    $gSumiranjePrekovremeni += $vrstaPlacanjaSlog['sati'];
                }


                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] < 'O') {

                    $oSumiranjeZaradeSati += $vrstaPlacanjaSlog['sati'];
                    $oSumiranjeZaradeIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);


                }

                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'O') {

                    $oSumiranjeBolovanjaSati += $vrstaPlacanjaSlog['sati'];
                    $oSumiranjeBolovanjaIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);

                }


                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] > 'S') {

                    $sSumiranjeIznosaObustava += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);
                }

//                if($vrstaPlacanjaSlog['OGRAN_ogranicenje_za_minimalac'] =='1'){
//                    TODO Kasnije logika za minimalac
//                }elseif ($vrstaPlacanjaSlog['OGRAN_ogranicenje_za_minimalac'] =='2'){
//
//                }elseif ($vrstaPlacanjaSlog['OGRAN_ogranicenje_za_minimalac'] =='3'){
//
//                }

                if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'L' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'P') {

                    $topliObrokSati += $vrstaPlacanjaSlog['sati'];
                }

                if ($vrstaPlacanjaSlog['sifra_vrste_placanja'] == '058') {

                    $regresIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);

                }


                if ($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '1' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '3') {

                    // PROVERI POK1 Podatak
                    $satiZarade += $vrstaPlacanjaSlog['sati'];

                }

                if ($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '2' || $vrstaPlacanjaSlog['a_grupisanje_sati_novca'] == '3' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] !== 'O') {
//                NAKNADNO U IZVESTAJIMA
                    // PROVERI POK1 Podatak
                    $iznosZarade += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);

                }


                if ($vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] == '1' || $vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] == '3') {

                    $prosecniSati += $vrstaPlacanjaSlog['sati'];
                }

                if ($vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] == '2' || $vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] == '3') {
                    $prosecniIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);

                }

//                if($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca']=='2' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca']=='3' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'O'){
////                NAKNADNO U IZVESTAJIMA
//                    // PROVERI POK1 Podatak
//                    $iznosNaknada += $vrstaPlacanjaSlog['iznos'];
//
//                }

                if ($mdr == '') {
                    if (isset($vrstaPlacanjaSlog->maticnadatotekaradnika)) {
                        $mdr = $vrstaPlacanjaSlog->maticnadatotekaradnika->toArray();
                    }
                }

                if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['EFSA_efektivni_sati']) {
                    $efektivniSati += $vrstaPlacanjaSlog['sati'];
                    $efektivniIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);
                }

            }


            $radnik['ZAR'] = [
//                'SIZNNE' => $kSumiranjeIznosSIZNNE,
//                'SSZNNE' => $kSumiranjeSatiSSZNNE,
                'SSZNE' => $oSumiranjeZaradeSati,
                'SIZNE' => $oSumiranjeZaradeIznos,
                'PREK' => $gSumiranjePrekovremeni,
                'SSNNE' => $oSumiranjeBolovanjaSati,
                'SINNE' => $oSumiranjeBolovanjaIznos,
                'SIOB' => $sSumiranjeIznosaObustava,
                'TOPSATI' => $topliObrokSati,
                'REGR' => $regresIznos,
                'sati_zarade' => $satiZarade,
                'iznos_zarade' => $iznosZarade,
                'prosecni_sati' => $prosecniSati,
                'prosecni_iznos' => $prosecniIznos,
                'EFSATI' => $efektivniSati,
                'EFIZNO' => $efektivniIznos,
//                'SINNE' => $iznosNaknada
//                'OGRAN'=> $SumiranjeOgranicenja,
            ];

            // TODO UPDATE DATABASE WITH ZARA
            $newRadnikData[] = $radnik;
        }

        return $newRadnikData;
    }

    public function pripremaZaraPodatkePoRadnikuKorakTri($groupRadnikData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik)
    {

        $newRadnikData = [];
        foreach ($groupRadnikData as $radnik) {
            $zar = $radnik['ZAR'];
//            $kSumiranjeIznosSIZNNE = $zar['SIZNNE'];
//            $kSumiranjeSatiSSZNNE = $zar['SSZNNE'];
            $gSumiranjePrekovremeni = $zar['PREK'];
            $oSumiranjeZaradeSati = $zar['SSZNE'];
            $oSumiranjeZaradeIznos = $zar['SIZNE'];

            $oSumiranjeBolovanjaSati = $zar['SSNNE'];
            $oSumiranjeBolovanjaIznos = $zar['SINNE'];

            $sSumiranjeIznosaObustava = $zar['SIOB'];
            $topliObrokSati = $zar['TOPSATI'];
            $topliObrokIznos = 0;
            $regresIznos = $zar['REGR'];
            $satiZarade = $zar['sati_zarade'];
            $iznosZarade = $zar['iznos_zarade'];
            $prosecniSati = $zar['sati_zarade'];
            $prosecniIznos = $zar['prosecni_iznos'];
            $mdr = '';
            $efektivniSati = $zar['EFSATI'];
            $efektivniIznos = $zar['EFIZNO'];
            $varijaIznos = 0;
            $s = 0;
            $ss = 0;


            foreach ($radnik as $key => $vrstaPlacanjaSlog) {

                if ($key == 'ZAR' || $key == 'MDR') {
                    continue;
                }

                // end radnik loop
                if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['OGRAN_ogranicenje_za_minimalac'] == '3') {
                    $s += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);
                    $ss += $vrstaPlacanjaSlog['sati'];
                }

                if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['OGRAN_ogranicenje_za_minimalac'] == '2') {
                    $s += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);
                }

                if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['OGRAN_ogranicenje_za_minimalac'] == '1') {
                    $ss += $vrstaPlacanjaSlog['sati'];
                }


                if ($vrstaPlacanjaSlog->SLOV_grupa_vrste_placanja == 'L' && $vrstaPlacanjaSlog->KESC_prihod_rashod_tip == 'P') {

                    $topliObrokSati += $vrstaPlacanjaSlog['sati'];
                    $topliObrokIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);
                }

                if ($vrstaPlacanjaSlog->sifra_vrste_placanja == '058') {

                    $regresIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);
                }

                if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['VARI_minuli_rad'] == '2') {
                    $varijaIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, []);
                }

            }


            $radnik['ZAR'] = [
//                'SIZNNE' => $kSumiranjeIznosSIZNNE,
//                'SSZNNE' => $kSumiranjeSatiSSZNNE,
                'SIZNE' => $oSumiranjeZaradeIznos,
                'SSZNE' => $oSumiranjeZaradeSati,
                'PREK' => $gSumiranjePrekovremeni,
                'SSNNE' => $oSumiranjeBolovanjaSati,
                'SINNE' => $oSumiranjeBolovanjaIznos,
                'SIOB' => $sSumiranjeIznosaObustava,
                'TOPSATI' => $topliObrokSati,
                'TOPLI' => $topliObrokIznos,
                'REGR' => $regresIznos,
                'sati_zarade' => $satiZarade,
                'iznos_zarade' => $iznosZarade,
                'prosecni_sati' => $prosecniSati,
                'prosecni_iznos' => $prosecniIznos,
                'EFSATI' => $efektivniSati,
                'EFIZNO' => $efektivniIznos,
                'VARIJA' => $varijaIznos,
                'MINIM' => $s / $ss,
                'S' => $s,
                'SS' => $ss
//                'SINNE' => $iznosNaknada
//                'OGRAN'=> $SumiranjeOgranicenja,
            ];

            // TODO UPDATE DATABASE WITH ZARA
//            \App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface
            $radnik['ZAR2'] = $this->prepareZaraData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData);
            $radnik['DKOPADD'] = $this->prepareDKopData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData, $poresDoprinosiSifarnik, $vrstePlacanjaSifarnik);
            $this->prepareBrutoData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData, $poresDoprinosiSifarnik, $vrstePlacanjaSifarnik);
            // TODO DODAJ DKOPADD
            $newRadnikData[] = $radnik;


        }
        $test = 'test';

//        $this->obradaZaraPoRadnikuInterface->createMany($newRadnikData);

        return $newRadnikData;
    }

    public function prepareBrutoData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData, $poresDoprinosiSifarnik, $vrstePlacanjaSifarnik)
    {
        $zar = $radnik['ZAR2'];
//        $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] = $zar['SIZNE_ukupni_iznos_zarade'] + $zar['SINNE_ukupni_iznos_naknade'] + $zar['solid'];
//
//        $zar['IZBRUTO'] = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];
//        $zar['SID'] = $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->ZDRO_zdravstveno_osiguranje_na_teret_radnika - $poresDoprinosiSifarnik->ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika ) + $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->PIO_pio_na_teret_radnika);
//        $zar['SIP'] = $zar['SIPPR'] + $zar['SIPBOL'];
//        $zar['SIP_D'] = $zar['SIPPR'] + $zar['SID'] + $zar['SIDBOL'] + $zar['SIPBOL'];
//
//        if($zar['UKSA']- $zar['PREKOV'] < $monthData->mesecni_fond_sati){
//            $zar['POROSL'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja/$monthData->mesecni_fond_sati *($zar['UKSA_ukupni_sati_za_isplatu']-$zar['PREK_prekovremeni']);
//        }
//
//        if($zar['UKSA']- $zar['PREKOV'] >= $monthData->mesecni_fond_sati){
//            $zar['POROSL'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
//        }
//
//        $zar['NETO'] = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] - $zar['SIP'] - $zar['SID'];
    }
    public function prepareZaraData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData)
    {

        // TODO INIT RADNIK ZAR Variable

        $nt2 = (float)$minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici;
        // ZAR->OLAKSICA =

        $olaksica = $nt2 / $monthData->mesecni_fond_sati;// NTO->NT2/KOE->BR_S

        $zar = $radnik['ZAR'];

//        foreach ($radnik as $key => $vrstaPlacanjaSlog) {
//
//            if ($key == 'ZAR' || $key == 'MDR') {
//                continue;
//            }
//
//            $test='TEST';
//
//        }

        if ($olaksica > $zar['MINIM']) {  // Olaksica ne sme da bude manja od minimalne propisane zarade

            $tabelaKoristnikMinuliRadEnabled = 1; // TODO pronadji kolonu
            if ($tabelaKoristnikMinuliRadEnabled == 1) {
//                $zar['SOLID'] =  0 ;//( ZAR->OLAKSICA -ZAR->MINIM)*SS

                $solid = ($olaksica - $zar['MINIM']) * $zar['SS'];
                $minsol = $solid * (int)$radnik['MDR']['GGST_godine_staza'] * 0.4 / 100; // TODO UBACITI VREDNOST INFORMACIJE O FIRMI

            } else if ($tabelaKoristnikMinuliRadEnabled == 0) {
//                replace ZAR->SOLID with (( ZAR->OLAKSICA -ZAR->MINIM)*SS)  //  NOVI OBracun za DRUMSKA i Solko i sve ostale
//                $solid  =  ($olaksica -  $zar['MINIM']) * $zar['SS'];
                $solid = ($olaksica - $zar['MINIM']) * $zar['SS'];

            }
        } elseif ($olaksica <= $zar['MINIM']) {
            $solid = 0;

        }


        $solid += $minsol ?? 0;


        // NAKON SUMIRANJA
//        if ZAR->IZNETO <= (NTO->NT1*NTO->STOPA6)
//        replace ZAR->UKUPNO with ZAR->IZNETO  // za sve firme
//           elseif ZAR->IZNETO > (NTO->NT1*NTO->STOPA6)
//             replace ZAR->UKUPNO with (NTO->NT1*NTO->STOPA6)
//           END


        $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] = $zar['SIZNE'] + $zar['iznos_zarade'] + $solid;
        if ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] <= $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
            $zar['UKUPNO'] = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];

        } elseif ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
            $zar['UKUPNO'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
        }


        $radnikData = [
            'SSZNE_suma_sati_zarade' => $zar['SSZNE'] + $zar['sati_zarade'],
            'SIZNE_ukupni_iznos_zarade' => $zar['SIZNE'] + $zar['iznos_zarade'],
            'PREK_prekovremeni' => $zar['PREK'],
            'SSNNE_suma_sati_naknade' => $zar['SSNNE'],
            'SINNE_ukupni_iznos_naknade' => $zar['SINNE'],
            'SIOB_ukupni_iznos_obustava' => $zar['SIOB'],
            'TOPLI_obrok_sati' => $zar['TOPSATI'],
            'TOPLI_obrok_iznos' => $zar['TOPLI'],
            'REGRES_iznos_regresa' => $zar['REGR'],
            'PRIZ_prosecni_sati_godina' => $zar['prosecni_sati'],
            'PRIZ_prosecni_iznos_godina' => $zar['prosecni_iznos'],
            'EFSATI_ukupni_iznos_efektivnih_sati' => $zar['EFSATI'],
            'EFIZNO_kumulativ_iznosa_za_efektivne_sate' => $zar['EFIZNO'],
            'IZNETO_zbir_ukupni_iznos_naknade_i_naknade' => $zar['SIZNE'] + $zar['iznos_zarade'] + $solid,
            'UKSA_ukupni_sati_za_isplatu' => $zar['SSZNE'] + $zar['sati_zarade'],
            'UKUPNO' => $zar['UKUPNO'],
            'solid' => $solid,
            'user_dpsm_id' => $radnik[0]->user_dpsm_id,
            'obracunski_koef_id' => $monthData->id,
            'user_mdr_id' => $radnik[0]->user_mdr_id
        ];


        // TODO DRUGI KRUG KORISTI RADNIK DATA UMESTO ZAR ZBOG kolekcija
//        {
//          "id": 121,  asd
////    ca  "M_G_mesec_dodinaa": "0123",
//          "NT1_prosecna_mesecna_zarada_u_republici": "360913.00",
//          "STOPA2_minimalna_neto_zarada_po_satu": "230.00",// Za radnike koji nisu ceo mesec
//          "STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos": "15.00",
//          "P1_stopa_poreza": "0.10",
//          "STOPA1_koeficijent_za_obracun_neto_na_bruto": 1426533523,
//          "NT2_minimalna_bruto_zarada": "5464879.00",
//          "created_at": null,
//          "updated_at": null
//      }

//        if ZAR->UKSA <= KOE->BR_S
//        IZBR2 = (NTO->STOPA3/KOE->BR_S*ZAR->UKSA)
//                     IZBR6 = 0
//                     IZBR50 = NTO->STOPA3


        // if{ pocetak    case ZAR->IZNETO < NTO->STOPA3 .and. ZAR->IZNETO > 0 .and. (NTO->STOPA3/KOE->BR_S > ZAR->IZNETO/ZAR->UKSA)

        if ($radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] < $minimalneBrutoOsnoviceSifarnik->STOPA2_minimalna_neto_zarada_po_satu && $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > 0 && ($minimalneBrutoOsnoviceSifarnik->STOPA2_minimalna_neto_zarada_po_satu / $monthData->mesecni_fond_sati > $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] / $radnikData['UKSA_ukupni_sati_za_isplatu'])) { // TODO DODAJ OVAJ USLOV
            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] <= $monthData->mesecni_fond_sati) {
                $izbr2 = $minimalneBrutoOsnoviceSifarnik->STOPA2_minimalna_neto_zarada_po_satu / $monthData->mesecni_fond_sati * $radnikData['UKSA_ukupni_sati_za_isplatu'];
                $izbr6 = 0;
                $izbr50 = $minimalneBrutoOsnoviceSifarnik->STOPA2_minimalna_neto_zarada_po_satu;
            }


//
//        if ZAR->UKSA > KOE->BR_S
//        IZBR2 = (NTO->STOPA3/KOE->BR_S*KOE->BR_S)
//                      IZBR6 = 0
//                     IZBR50 = NTO->STOPA3
//                  endif

            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] > $monthData->mesecni_fond_sati) {

                $izbr2 = $minimalneBrutoOsnoviceSifarnik->STOPA2_minimalna_neto_zarada_po_satu / $monthData->mesecni_fond_sati * $monthData->mesecni_fond_sati;
                $izbr6 = 0;
                $izbr50 = $minimalneBrutoOsnoviceSifarnik->STOPA2_minimalna_neto_zarada_po_satu;

            }
        }


        //OBRACUN DOPRINOSA i UPOREDJIVANJE SA MINIMALNOM BRUTO ZARADOM


//        DO CASE
//               case ZAR->IZNETO <= NTO->NT1   // NT1_prosecna_mesecna_zarada_u_republici
//                  IZBR1 = ZAR->IZNETO
//               case ZAR->IZNETO > NTO->NT1
//                  IZBR1 = ZAR->IZNETO
//            endcase
//

        if ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] <= $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici) {
            $izbr1 = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];
        } elseif ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici) {
            $izbr1 = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];
        }

        // PIO POCETAK

        if ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] < $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada && $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > 0 && ($minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati > $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] / $radnikData['UKSA_ukupni_sati_za_isplatu'])) {
//            if ZAR->UKSA <= KOE->BR_S
//            IZBR2 = (NTO->NT2/KOE->BR_S*ZAR->UKSA)
//                  IZBR6 = 0
//                  IZBR50 = NTO->NT2
//               endif

            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] <= $monthData->mesecni_fond_sati) {

                // TODO add  $izbr2 = (NTO->NT2/KOE->BR_S*ZAR->UKSA)
                $izbr2 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati * $radnikData['UKSA_ukupni_sati_za_isplatu'];
                $izbr6 = 0;
                $izbr50 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada;
            }
            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] > $monthData->mesecni_fond_sati) {
//            if ZAR->UKSA > KOE->BR_S
//            IZBR2 = (NTO->NT2/KOE->BR_S*KOE->BR_S)
//                  IZBR6 = 0
//                  IZBR50 = NTO->NT2
//               endif


                $izbr2 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati * $monthData->mesecni_fond_sati;
                $izbr6 = 0;
                $izbr50 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada;
            }


        } elseif ($radnikData['UKSA_ukupni_sati_za_isplatu'] >= $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada || ($minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati < $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] / $radnikData['UKSA_ukupni_sati_za_isplatu'])) {

            $izbr6 = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];
            $izbr2 = 0;
            $izbr50 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada;
//        case ZAR->IZNETO >= NTO->NT2 .or. (NTO->NT2/KOE->BR_S < ZAR->IZNETO/ZAR->UKSA)
//               IZBR6 = ZAR->IZNETO
//               IZBR2 = 0
//               IZBR50 = NTO->NT2
//         endcase
        }

        // PIO KRAJ
        // ZDRAVSTVENO  i NEZAPOSLENOST POCETAK
        if ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] < $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada && $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > 0 && ($minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati > $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] / $radnikData['UKSA_ukupni_sati_za_isplatu'])) {
//            if ZAR->UKSA <= KOE->BR_S
//            IZBR2 = (NTO->NT2/KOE->BR_S*ZAR->UKSA)
//                  IZBR6 = 0
//                  IZBR50 = NTO->NT2
//               endif

            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] <= $monthData->mesecni_fond_sati) {

                $izbr51 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati * $radnikData['UKSA_ukupni_sati_za_isplatu'];
                $izbr52 = 0;
                $izbr53 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada;
            }
            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] > $monthData->mesecni_fond_sati) {
//            if ZAR->UKSA > KOE->BR_S
//            $izbr51 = (NTO->NT2/KOE->BR_S*KOE->BR_S)
//                  $izbr52 = 0
//                  $izbr53 = NTO->NT2
//               endif

                $izbr51 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati * $monthData->mesecni_fond_sati;
                $izbr52 = 0;
                $izbr53 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada;
            }


        } elseif ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] >= $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada || ($minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati < $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] / $radnikData['UKSA_ukupni_sati_za_isplatu'])) {

            $izbr51 = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];
            $izbr52 = 0;
            $izbr53 = $minimalneBrutoOsnoviceSifarnik->nt2_minimalna_bruto_zarada;
//        case ZAR->IZNETO >= NTO->NT2 .or. (NTO->NT2/KOE->BR_S < ZAR->IZNETO/ZAR->UKSA)
//               IZBR6 = ZAR->IZNETO
//               IZBR2 = 0
//               IZBR50 = NTO->NT2
//         endcase
        }

        // ZDRAVSTVENO  i NEZAPOSLENOST KRAJ

        // SOLID JE OBRACUNATI IZNOS MINIMALNE BRUTO ZARADE ZA RADNIKA POJEDINACNO

        if ($radnikData['solid'] > 0) {
            $radnikData['IZBRBO1'] = ($radnikData['solid'] + $radnikData['SINNE_ukupni_iznos_naknade']) + ($radnikData['SINNE_ukupni_iznos_naknade'] * 0.4 / 100);
        }

        $radnikData['OSNOV'] = ($izbr50 / $monthData->mesecni_fond_sati) * $radnikData['SSZNE_suma_sati_zarade'];


        if ($radnikData['solid'] > 0) {
            $radnikData['IZBRBO2'] = ($radnikData['SIZNE_ukupni_iznos_zarade'] + $radnikData['SINNE_ukupni_iznos_naknade'] + $radnikData['solid']);
        }
        // TODO uslov za osnov
        $radnikData['OSNOV'] = ($izbr53 / $monthData->mesecni_fond_sati) * ($radnikData['SSZNE_suma_sati_zarade']);


        if ($radnikData['IZBRBO1'] < $radnikData['IZBRBO2']) {
            $radnikData['IZBRBO1'] = $radnikData['IZBRBO2'];
        }

        $radnikData['KONTROLA'] = $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];


        if ($radnikData['KONTROLA'] > $radnikData['IZBRBO1']) {
            $radnikData['IZBRBOL'] = $radnikData['KONTROLA'];
        } else {
            $radnikData['IZBRBOL'] = 0;
        }


        if ($radnikData['IZBRBOL'] <= $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {

            if ($radnikData['IZBRBOL'] > 0) {
                $radnikData['UKUPNO'] = $radnikData['IZBRBOL'];
            } elseif ($radnikData['IZBRBO1'] > 0) {
                $radnikData['UKUPNO'] = $radnikData['IZBRBO1'];
            }

            if ($radnikData['IZBRBOL'] + $radnikData['IZBRBO1'] > $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
                $radnikData['UKUPNO'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
            }

//            if (ZAR->IZBRBOL+ZAR->IZBRBO1)<= (NTO->NT1*NTO->STOPA6)
//            replace ZAR->UKUPNO1   with ZAR->IZBRBO2
//
//         elseif (ZAR->IZBRBOL+ZAR->IZBRBO1) > (NTO->NT1*NTO->STOPA6) // OGRANICENJE NA PET NAJVISIH ZARADA
//            replace ZAR->UKUPNO1   with (NTO->NT1*NTO->STOPA6) // BRUTO PROSECNA ZARADA x 5
//         end


            if (($radnikData['IZBRBOL'] + $radnikData['IZBRBO1']) <= ($minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos)) {
                $radnikData['UKUPNO1'] = $radnikData['IZBRBO2'];
            } elseif (($radnikData['IZBRBOL'] + $radnikData['IZBRBO1']) > ($minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos)) {
                $radnikData['UKUPNO1'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
            }
//
//
//          if ZAR->IZNETO <= (NTO->NT1*NTO->STOPA6)
//          replace ZAR->UKUPNO with ZAR->IZNETO  // za sve firme
//           elseif ZAR->IZNETO > (NTO->NT1*NTO->STOPA6)
//             replace ZAR->UKUPNO with (NTO->NT1*NTO->STOPA6)
//           END

            if ($radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] <= $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
                $radnikData['UKUPNO'] = $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];

            } elseif ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
                $radnikData['UKUPNO'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
            }


        }


        return $radnikData;
    }

    public function prepareDkopData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData, $poresDoprinosiSifarnik, $vrstePlacanjaSifarnik)
    {
        $test = 'TEST';
        $sveVrstePlacanja = [];

        $zar = $radnik['ZAR2'];
        $mdr = $radnik['MDR'];
        $radnikData = $radnik[0];
        if ($zar['UKUPNO'] * $poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika > 0) {
            //PENZIJSKO I INVALIDSKO OSIGURANJE
            $newPlacanje['maticni_broj'] = $mdr['MBRD_maticni_broj'];
            $newPlacanje['sifra_vrste_placanja'] = '053';
            $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik['053']['SLOV_grupe_vrsta_placanja'];
            $newPlacanje['POK2_obracun_minulog_rada'] = $vrstePlacanjaSifarnik['053']['POK2_obracun_minulog_rada'];
            $newPlacanje['iznos'] = $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->ZDRO_zdravstveno_osiguranje_na_teret_radnika - $poresDoprinosiSifarnik->ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika);

            $newPlacanje['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
            $newPlacanje['KESC_prihod_rashod_tip'] = 'R';
            $newPlacanje['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
            $newPlacanje['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
            $newPlacanje['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
            $newPlacanje['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];

            // TODO HKMB ?? koje bese polje
            $newPlacanje['user_mdr_id'] = $radnikData['user_mdr_id'];
            $newPlacanje['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnikData['user_dpsm_id'];


            $sveVrstePlacanja[] = $newPlacanje;
        }

        if ($zar['UKUPNO'] * $poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika > 0) {
            //ZDRAVSTVENO
            $newPlacanje['maticni_broj'] = $mdr['MBRD_maticni_broj'];
            $newPlacanje['sifra_vrste_placanja'] = '054';
            $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik['053']['SLOV_grupe_vrsta_placanja'];
            $newPlacanje['POK2_obracun_minulog_rada'] = 'K';
            $newPlacanje['iznos'] = $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->PIO_pio_na_teret_radnika - $poresDoprinosiSifarnik->ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika);

            $newPlacanje['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
            $newPlacanje['KESC_prihod_rashod_tip'] = 'R';
            $newPlacanje['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
            $newPlacanje['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
            $newPlacanje['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
            $newPlacanje['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];

            // TODO HKMB ?? koje bese polje
            $newPlacanje['user_mdr_id'] = $radnikData['user_mdr_id'];
            $newPlacanje['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnikData['user_dpsm_id'];


            $sveVrstePlacanja[] = $newPlacanje;
        }

        if ($zar['UKUPNO'] * $poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika > 0) {
            //NEZAPOSLENOST
            $newPlacanje['maticni_broj'] = $mdr['MBRD_maticni_broj'];
            $newPlacanje['sifra_vrste_placanja'] = '055';
            $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik['053']['SLOV_grupe_vrsta_placanja'];
            $newPlacanje['POK2_obracun_minulog_rada'] = 'K';
            $newPlacanje['iznos'] = $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->PIO_pio_na_teret_radnika - $poresDoprinosiSifarnik->ZDRO_zdravstveno_osiguranje_na_teret_radnika);

            $newPlacanje['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
            $newPlacanje['KESC_prihod_rashod_tip'] = 'R';
            $newPlacanje['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
            $newPlacanje['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
            $newPlacanje['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
            $newPlacanje['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];


            // TODO HKMB ?? koje bese polje
            $newPlacanje['user_mdr_id'] = $radnikData['user_mdr_id'];
            $newPlacanje['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnikData['user_dpsm_id'];


            $sveVrstePlacanja[] = $newPlacanje;
        }


        $nIzn = 0;
        $zar['PLACENO'] = 0; // TODO PROVERITI
        if ($zar['UKUPNO'] == 0) {  // TODO PROVERITI


            if ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni'] < $monthData->mesecni_fond_sati) {

                $nIzn =($zar['SIZNE_ukupni_iznos_zarade'] + $zar['SINNE_ukupni_iznos_naknade'] + $zar['solid']-($poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja/$monthData->mesecni_fond_sati*($zar['UKSA_ukupni_sati_za_isplatu']-$zar['PREK_prekovremeni']->PREKOV)))*$minimalneBrutoOsnoviceSifarnik->P1_stopa_poreza;
            }

            if(($zar['UKSA_ukupni_sati_za_isplatu']  - $zar['PREK_prekovremeni']) < $monthData->mesecni_fond_sati){

                $nIzn = ($zar['SIZNE_ukupni_iznos_zarade'] +  $zar['SINNE_ukupni_iznos_naknade']  + $zar['solid']+ $zar['PLACENO']-$poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja)*$minimalneBrutoOsnoviceSifarnik->P1_stopa_poreza;
            }
        }

        if($nIzn > 0){
            $newPlacanje['maticni_broj'] = $mdr['MBRD_maticni_broj'];
            $newPlacanje['sifra_vrste_placanja'] = '050';
            $newPlacanje['SLOV_grupa_vrste_placanja'] = 'U';
            $newPlacanje['POK2_obracun_minulog_rada'] = 'K';
            $newPlacanje['iznos'] =$nIzn;
//            replace KOP->IZNO   with nIzn , ZAR->SIPPR with nIzn, ZAR->SIOB with SIOB

            $zar['SIPPR'] = $nIzn;
            $newPlacanje['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
            $newPlacanje['KESC_prihod_rashod_tip'] = 'R';
            $newPlacanje['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
            $newPlacanje['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
            $newPlacanje['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
            $newPlacanje['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];


            // TODO HKMB ?? koje bese polje
            $newPlacanje['user_mdr_id'] = $radnikData['user_mdr_id'];
            $newPlacanje['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnikData['user_dpsm_id'];

            if($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni'] <$monthData->mesecni_fond_sati){

                $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja/$monthData->mesecni_fond_sati * ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni']);
            }

            if($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni'] >= $monthData->mesecni_fond_sati){
                $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;

            }

            $sveVrstePlacanja[] = $newPlacanje;

        } else{
            $zar['SIPPR']=0;
        }

        $bruto = 0;
        $bruto = $zar['SIPPR'];

        if($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > $zar['IZBRBO1']){
            $zar['SID'] = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] *$poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika;
        } elseif ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] < $zar['IZBRBO1']){
            $zar['SID'] = $zar['UKUPNO'] *$poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika;

        }
//            $newPlacanje['sati'] = $vrstaPlacanja['sati'];
//            $newPlacanje['sifra_vrste_placanja'] = $vrstaPlacanja['sifra_vrste_placanja'];
//
//            // RADNIK-MESEC
//            $newPlacanje['maticni_broj'] = $radnik['MBRD_maticni_broj'];
//            $newPlacanje['user_mdr_id'] = $radnik->id;
//            $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];

//            $newPlacanje['tip_unosa'] = 'fiksno_placanje';
//            $newPlacanje['user_dpsm_id'] = $vrstaPlacanja['user_dpsm_id'];
//            // MDR
//            $newPlacanje['KOEF_osnovna_zarada'] = $radnik->KOEF_osnovna_zarada;
//            $newPlacanje['RBRM_radno_mesto'] = $radnik->RBRM_radno_mesto;
//            $newPlacanje['P_R_oblik_rada'] = $radnik->P_R_oblik_rada;
//            $newPlacanje['RBIM_isplatno_mesto_id'] = $radnik->RBIM_isplatno_mesto_id;
//            $newPlacanje['troskovno_mesto_id'] = $radnik->troskovno_mesto_id;
////                $newPlacanje['user_mdr_id'] = $vrstaPlacanja['user_mdr_id'];
//            $newPlacanje['obracunski_koef_id'] = $vrstaPlacanja['obracunski_koef_id'];

        // DVPL

//
//            $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['sifra_vrste_placanja']]['naziv_naziv_vrste_placanja'];
//            $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['sifra_vrste_placanja']]['SLOV_grupe_vrsta_placanja'];
//            $newPlacanje['POK2_obracun_minulog_rada'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['sifra_vrste_placanja']]['POK2_obracun_minulog_rada'];
//
//            // DPOR
//
//            $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
//            $sveVrstePlacanjaVariabilna[] = $newPlacanje;
//
//
        return $sveVrstePlacanja;
    }

    public function pripremaZaraPodatkePoRadnikuKorakCetiri($groupRadnikData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik)
    {
        $newRadnikData = [];
        foreach ($groupRadnikData as $radnik) {
            foreach ($radnik as $key => $vrstaPlacanjaSlog) {


                if ($key == 'ZAR' || $key == 'MDR') {
                    continue;
                }


            }

        }
    }


}
