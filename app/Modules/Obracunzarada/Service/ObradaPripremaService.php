<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;

class ObradaPripremaService
{
    public function __construct(
        private readonly ObradaFormuleService $obradaFormuleService
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

                    // RADNIK-MESEC
                    $newPlacanje['maticni_broj'] = $radnik['maticni_broj'];
                    $newPlacanje['user_mdr_id'] = $radnik['user_mdr_id'];
                    $newPlacanje['tip_unosa'] = 'poenter_varijabilno';
                    $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];
                    $newPlacanje['user_dpsm_id'] = $radnik['id'];
                    // MDR
                    $newPlacanje['KOEF_osnovna_zarada'] = $radnik->maticnadatotekaradnika->KOEF_osnovna_zarada;
                    $newPlacanje['RBRM_radno_mesto'] = $radnik->maticnadatotekaradnika->RBRM_radno_mesto;
                    $newPlacanje['P_R_oblik_rada'] = $radnik->maticnadatotekaradnika->P_R_oblik_rada;
                    $newPlacanje['RBIM_isplatno_mesto_id'] = $radnik->maticnadatotekaradnika->RBIM_isplatno_mesto_id;
                    $newPlacanje['troskovno_mesto_id'] = $radnik->maticnadatotekaradnika->troskovno_mesto_id;
                    // DVPL


                    $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['naziv_naziv_vrste_placanja'];
                    $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['SLOV_grupe_vrsta_placanja'];
                    $newPlacanje['POK2_obracun_minulog_rada'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['POK2_obracun_minulog_rada'];
                    $newPlacanje['KESC_prihod_rashod_tip'] = $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['KESC_prihod_rashod_tip'];

                    // DPOR

                    $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
                    $newPlacanje['iznos'] =$vrstaPlacanja['sati']  * $cenaRada;

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
                $newPlacanje['user_mdr_id'] = $radnik['user_mdr_id'];
                $newPlacanje['tip_unosa'] = 'fiksno_placanje';
                $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];
                $newPlacanje['user_dpsm_id'] = $radnik['id'];
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
                $newPlacanje['user_mdr_id'] = $radnik['user_mdr_id'];
                $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];

                $newPlacanje['tip_unosa'] = 'fiksno_placanje';
                $newPlacanje['user_dpsm_id'] = $radnik['id'];
                // MDR
                $newPlacanje['KOEF_osnovna_zarada'] = $radnik->KOEF_osnovna_zarada;
                $newPlacanje['RBRM_radno_mesto'] = $radnik->RBRM_radno_mesto;
                $newPlacanje['P_R_oblik_rada'] = $radnik->P_R_oblik_rada;
                $newPlacanje['RBIM_isplatno_mesto_id'] = $radnik->RBIM_isplatno_mesto_id;
                $newPlacanje['troskovno_mesto_id'] = $radnik->troskovno_mesto_id;
                $newPlacanje['user_mdr_id'] = $vrstaPlacanja['user_mdr_id'];
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

    public function pripremaZaraPodatkePoRadniku($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik,$monthData,$minimalneBrutoOsnoviceSifarnik)
    {
        // KORAK 1
        // PRIPREMA G
        $zaraRadnikData1 = [];
        $groupRadnikData = $data->groupBy('user_mdr_id');

        foreach ($groupRadnikData as $radnik) {
            $gSumiranjeIznosSIZNNE = 0;
            $gSumiranjeSatiSSZNNE = 0;
            $gSumiranjePrekovremeni = 0;
            $oSumiranjeZaradeSati =0;
            $oSumiranjeZaradeIznos =0;
            $oSumiranjeBolovanjaSati=0;
            $oSumiranjeBolovanjaIznos= 0;

            $sSumiranjeIznosaObustava = 0;
            $toplihObrokSati = 0;
            $regresIznos = 0;
            $satiZarade = 0;
            $iznosZarade = 0;
            $prosecniSati = 0;
            $prosecniIznos = 0;
            $mdr = '';
            $efektivniSati=0;
            $efektivniIznos=0;
            // PETLJA LOGIKE ZA SUMIRANJE START

            foreach ($radnik as $vrstaPlacanjaSlog) {
                array_map(function($subArray) {     return isset($subArray['SLOV_grupa_vrste_placanja']) ? $subArray['SLOV_grupa_vrste_placanja'] : null; }, $radnik->toArray());

                if ($vrstaPlacanjaSlog['POK2_obracun_minulog_rada'] == 'G') {
                    $iznos = $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog,$vrstePlacanjaSifarnik,$radnik,$poresDoprinosiSifarnik,$monthData,$minimalneBrutoOsnoviceSifarnik);



                    if ($vrstaPlacanjaSlog['iznos'] !== null) {
                        $gSumiranjeIznosSIZNNE += $iznos;
                    }

                    if ($vrstaPlacanjaSlog['sati'] !== null) {
                        $gSumiranjeSatiSSZNNE +=$vrstaPlacanjaSlog['sati'];
                    }
                }


                if($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] =='G'){

                    $gSumiranjePrekovremeni += $vrstaPlacanjaSlog['sati'];
                }


                if($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] < 'O'){

                    $oSumiranjeZaradeSati += $vrstaPlacanjaSlog['sati'];
                    $oSumiranjeZaradeIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog,$vrstePlacanjaSifarnik,$radnik,$poresDoprinosiSifarnik,$monthData,$minimalneBrutoOsnoviceSifarnik);


                }

                if($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'O'){

                    $oSumiranjeBolovanjaSati += $vrstaPlacanjaSlog['sati'];
                    $oSumiranjeBolovanjaIznos += $vrstaPlacanjaSlog['iznos'];

                }


                if($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] > 'S'){

                    $sSumiranjeIznosaObustava += $vrstaPlacanjaSlog['iznos'];
                }

//                if($vrstaPlacanjaSlog['OGRAN_ogranicenje_za_minimalac'] =='1'){
//                    TODO Kasnije logika za minimalac
//                }elseif ($vrstaPlacanjaSlog['OGRAN_ogranicenje_za_minimalac'] =='2'){
//
//                }elseif ($vrstaPlacanjaSlog['OGRAN_ogranicenje_za_minimalac'] =='3'){
//
//                }

                if($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'L' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'P'){

                    $toplihObrokSati += $vrstaPlacanjaSlog['sati'];
                }

                if($vrstaPlacanjaSlog['sifra_vrste_placanja']=='058'){

                    $regresIznos += $vrstaPlacanjaSlog['iznos'];

                }


                if($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca']=='1' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca']=='3'){

                    // PROVERI POK1 Podatak
                    $satiZarade += $vrstaPlacanjaSlog['sati'];

                }

                if($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca']=='2' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca']=='3' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] !== 'O'){
//                NAKNADNO U IZVESTAJIMA
                    // PROVERI POK1 Podatak
                    $iznosZarade += $vrstaPlacanjaSlog['iznos'];

                }


                if($vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] =='1' || $vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] =='3'){

                    $prosecniSati += $vrstaPlacanjaSlog['sati'];
                }

                if($vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] =='2' || $vrstaPlacanjaSlog['PROSEK_prosecni_obracun'] =='3'){
                    $prosecniIznos += $vrstaPlacanjaSlog['iznos'];

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

                if($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['EFSA_efektivni_sati']){
                    $efektivniSati+=$vrstaPlacanjaSlog['sati'];
                    $efektivniIznos+= $vrstaPlacanjaSlog['iznos'];
                }



            }

            // PETLJA LOGIKE ZA SUMIRANJE END

            // LOGIKA ZA PREPISIVANJE i UPISIVANJE SUM START
            $radnik['ZAR'] = [
                'SIZNNE' => $gSumiranjeIznosSIZNNE,
                'SSZNNE' => $gSumiranjeSatiSSZNNE,
                'PREK'=>$gSumiranjePrekovremeni,
                'SSZNE'=>$oSumiranjeZaradeSati,
                'SIZNE'=>$oSumiranjeZaradeIznos,
                'SSNNE'=> $oSumiranjeBolovanjaSati,
                'SINNE'=>$oSumiranjeBolovanjaIznos,
                'SIOB'=>$sSumiranjeIznosaObustava,
                'TOPSATI'=>$toplihObrokSati,
                'REGR' => $regresIznos,
                'EFSATI'=>$efektivniSati,
                'EFIZNO'=>$efektivniIznos,
                'sati_zarade'=>$satiZarade,
                'iznos_zarade' => $iznosZarade,
                'prosecni_iznos'=>$prosecniIznos,
                'prosecni_sati'=>$prosecniSati
//                'SINNE' => $iznosNaknada
//                'OGRAN'=> $SumiranjeOgranicenja,
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

        foreach ($groupRadnikData as $radnik) {

            foreach ($radnik as $vrstaPlacanjaSlog) {

                $kSumiranjeIznos = 0;
                $kSumiranjeSati = 0;
                if ($vrstaPlacanjaSlog['POK2_obracun_minulog_rada'] == 'K') {

//                    $vrstaPlacanjaSifData = $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']];
                    $test = $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik,$radnik,$poresDoprinosiSifarnik,$monthData,$minimalneBrutoOsnoviceSifarnik);
                    // razlicita logika

                    $test2='test2';
                }
            }
            //
        }



        return $groupRadnikData;
    }


}
