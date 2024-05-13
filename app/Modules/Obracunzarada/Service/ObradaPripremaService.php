<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;

class ObradaPripremaService
{
    public function __construct(
        private readonly ObradaFormuleService                          $obradaFormuleService,
        private readonly ObradaZaraPoRadnikuRepositoryInterface        $obradaZaraPoRadnikuInterface,
        private readonly DpsmKreditiRepositoryInterface                $dpsmKreditiInterface,
        private readonly ObradaDkopSveVrstePlacanjaRepositoryInterface $dkopSveVrstePlacanjaInterface,
        private readonly \App\Modules\Obracunzarada\Repository\ObradaKreditiRepositoryInterface $obradaKreditiInterface
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
                    $newPlacanje['sati'] = $vrstaPlacanja['sati'];

                    $sveVrstePlacanjaPoenteri[] = $newPlacanje;
//                }


                }
            }
        }
        return $sveVrstePlacanjaPoenteri;

    }

    public function pripremiFiksnaPlacanja($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik)
    {
        $sveVrstePlacanjaFiksna = [];
        foreach ($data as $key => $vrstaPlacanja) {
            $radnik = $vrstaPlacanja->maticnadatotekaradnika;

            $newPlacanje = [];
            if ($vrstaPlacanja['sati'] !== '' || $vrstaPlacanja['iznos'] > 0) {
                $newPlacanje['sati'] = $vrstaPlacanja['sati'];
                $newPlacanje['sifra_vrste_placanja'] = $vrstaPlacanja['sifra_vrste_placanja'];

                // RADNIK-MESEC
                $newPlacanje['maticni_broj'] = $radnik['MBRD_maticni_broj'];
                $newPlacanje['user_mdr_id'] = $radnik['id'];
                $newPlacanje['tip_unosa'] = 'fiksno_placanje';
                $newPlacanje['obracunski_koef_id'] = $vrstaPlacanja['obracunski_koef_id'];
                $newPlacanje['user_dpsm_id'] = $vrstaPlacanja['user_dpsm_id'];
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
                if ($vrstaPlacanja['iznos'] > 0) {
                    $newPlacanje['iznos'] = (float)$vrstaPlacanja['iznos'];
                } else {
                    $newPlacanje['iznos'] = 0;
                }

                if ($vrstaPlacanja['procenat'] > 0) {
                    $newPlacanje['procenat'] = (float)$vrstaPlacanja['procenat'];
                } else {
                    $newPlacanje['procenat'] = 0;
                }


                $sveVrstePlacanjaFiksna[] = $newPlacanje;
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
        $sveVrstePlacanjaVariabilna = [];
        foreach ($data as $key => $vrstaPlacanja) {
            $radnik = $vrstaPlacanja->maticnadatotekaradnika;

            $newPlacanje = [];
            if ($vrstaPlacanja['sati'] !== '' || $vrstaPlacanja['iznos'] > 0) {
                $newPlacanje['sati'] = $vrstaPlacanja['sati'];
                $newPlacanje['sifra_vrste_placanja'] = $vrstaPlacanja['sifra_vrste_placanja'];

                // RADNIK-MESEC
                $newPlacanje['maticni_broj'] = $radnik['MBRD_maticni_broj'];
                $newPlacanje['user_mdr_id'] = $radnik->id;

                $newPlacanje['tip_unosa'] = 'varijabilno_placanje';
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
                if ($vrstaPlacanja['iznos'] > 0) {
                    $newPlacanje['iznos'] = (float)$vrstaPlacanja['iznos'];
                } else {
                    $newPlacanje['iznos'] = 0;

                }

                if ($vrstaPlacanja['procenat'] > 0) {
                    $newPlacanje['procenat'] = $vrstaPlacanja['procenat'] > 1 ? (float)($vrstaPlacanja['procenat'] / 100) : (float)$vrstaPlacanja['procenat'];
                } else {
                    $newPlacanje['procenat'] = 0;
                }


                $sveVrstePlacanjaVariabilna[] = $newPlacanje;
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

    public function pripremaKredita($krediti, $id, $vrstePlacanjaSifarnik)
    {

        $allData = [];

        foreach ($krediti as $kredit) {


            $data = [
                'maticni_broj' => $kredit->maticni_broj,
                'sifra_vrste_placanja' => '093',
                'naziv_vrste_placanja' => 'Krediti',
                'SIFK_sifra_kreditora' => $kredit->SIFK_sifra_kreditora,
                'PART_partija_kredita' => $kredit->PART_partija_poziv_na_broj,
                'KESC_prihod_rashod_tip' => $vrstePlacanjaSifarnik['093']['KESC_prihod_rashod_tip'],
                'GLAVN_glavnica' => $kredit->GLAVN_glavnica,
                'SALD_saldo' => $kredit->SALD_saldo,
                'RATA_rata' => $kredit->RATA_rata,
                'POCE_pocetak_zaduzenja' => $kredit->POCE_pocetak_zaduzenja,
                'RATP_prethodna' => $kredit->RATP_prethodna,
                'STSALD_Prethodni_saldo' => null,
                'DATUM_zaduzenja' => $kredit->DATUM_zaduzenja,
                'obracunski_koef_id' => $id,
                'user_mdr_id' => $kredit->user_mdr_id,
                'RBZA'=>$kredit->RBZA,
                'RATB'=>$kredit->RATB
            ];

            $allData[] = $data;
        }

        return $allData;
    }

    public function pripremiMinuliRad($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik)
    {


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

            $minuliRadData[] = $newPlacanje;


        }
        return $minuliRadData;
    }


    public function pripremaZaraPodatkePoRadnikuBezMinulogRada($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik)
    {
        // KORAK 1
        // PRIPREMA G
        $zaraRadnikData1 = [];
//        $groupRadnikData = $data->sortByDesc('KESC_prihod_rashod_tip')->groupBy('user_mdr_id');

        $groupRadnikData = $data->sortByDesc(function ($row, $key) {
            if($row['KESC_prihod_rashod_tip'] == 'P'){
                return 1;
            }else{
                return 0;
            }
        })->groupBy('user_mdr_id');

        $test='test';
        foreach ($groupRadnikData as $radnik) {
            $gSumiranjePrekovremeniPREK = 0;
            $oSumiranjeZaradeSatiSSZNE = 0;
            $oSumiranjeZaradeIznosSIZNE = 0;
            $oSumiranjeBolovanjaSatiSSNNE = 0;
            $oSumiranjeBolovanjaIznosSINNE = 0;

            $sumiranjeIznosaObustavaSIOB = 0;
            $topliObrokSati = 0;
            $topliObrokIznos = 0;
            $regresIznos = 0;
            $satiZarade = 0;
            $iznosZarade = 0;
            $prosecniSati = 0;
            $prosecniIznos = 0;
            $iznosNaknade = 0;
            $mdr = '';
            $efektivniSati = 0;
            $efektivniIznos = 0;
            $s = 0;
            $ss = 0;
            $varijaIznos = 0;
//            $sizn = 0;
            // PETLJA LOGIKE ZA SUMIRANJE START
            $zaraUpdated=[];

            foreach ($radnik as $vrstaPlacanjaSlog) {
//                array_map(function($subArray) {     return isset($subArray['SLOV_grupa_vrste_placanja']) ? $subArray['SLOV_grupa_vrste_placanja'] : null; }, $radnik->toArray());

                $pok1 = $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['POK1_grupisanje_sati_novca'];
                $pok3 = $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['POK3_prikaz_kroz_unos'];
                $plac = $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PLAC'];
                if ($vrstaPlacanjaSlog['POK2_obracun_minulog_rada'] == 'G') {

                    $newIznos = $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    $vrstaPlacanjaSlog['iznos'] = $newIznos;

                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'G') {
                        // PREKOVREMENI RAD
                        $gSumiranjePrekovremeniPREK += $vrstaPlacanjaSlog['sati'];
                    }

//                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] < 'N') {
//
//                        $sizn += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
//
//                    }


                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] < 'O' && $plac == 1 || $plac == 3 || $plac == 4 || $plac == 5) {

                        $oSumiranjeZaradeSatiSSZNE += $vrstaPlacanjaSlog['sati'];

//                        $praviloSkip = false;
//                        if ($vrstaPlacanjaSlog['sifra_vrste_placanja'] == '005') {
//                            $praviloSkip = true;
//                        }

                    }

                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] < 'O') {
                        $newIznos = $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                        $oSumiranjeZaradeIznosSIZNE += $newIznos;
                        $vrstaPlacanjaSlog['iznos'] = $newIznos;
                        // GORNJI DEO LISTE


                    } elseif ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'O') {

                        // BOLOVANJE
                        $oSumiranjeBolovanjaSatiSSNNE += $vrstaPlacanjaSlog['sati'];
                        $oSumiranjeBolovanjaIznosSINNE += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);

                    } elseif ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] > 'S') {
                        // OBUSTAVE
                        $sumiranjeIznosaObustavaSIOB += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }


                    //
                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['OGRAN_ogranicenje_za_minimalac'] == '3') {
                        $s += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                        $ss += $vrstaPlacanjaSlog['sati'];
                    }

                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['OGRAN_ogranicenje_za_minimalac'] == '2') {
                        $s += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }

                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['OGRAN_ogranicenje_za_minimalac'] == '1') {
                        $ss += $vrstaPlacanjaSlog['sati'];
                    }


                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'L' && $vrstaPlacanjaSlog['KESC_prihod_rashod_tip'] == 'P') {

                        $topliObrokSati += $vrstaPlacanjaSlog['sati'];
                        $topliObrokIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                        $vrstaPlacanjaSlog['iznos'] = $topliObrokIznos + $vrstaPlacanjaSlog['iznos'];
                    }

                    if ($vrstaPlacanjaSlog['sifra_vrste_placanja'] == '058') {

                        $regresIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);

                    }

                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['VARI_minuli_rad'] == '2') {
                        $varijaIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }


                    if ($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '1' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '3') {

                        $satiZarade += $vrstaPlacanjaSlog['sati'];

                    }

                    if ($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '2' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '3' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] !== 'O') {

                        $iznosZarade += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);

                    }

                    if ($vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '2' || $vrstaPlacanjaSlog['POK1_grupisanje_sati_novca'] == '3' && $vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'O') {

                        $iznosNaknade += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }

                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['EFSA_efektivni_sati'] && $pok1 == '3' || $pok1 == '1') {
                        $efektivniSati += $vrstaPlacanjaSlog['sati'];
                        $efektivniIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }

                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['EFSA_efektivni_sati'] && $pok1 == '2') {
                        $efektivniIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }


                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PROSEK_prosecni_obracun'] == '1' || $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PROSEK_prosecni_obracun'] == '3') {

                        $prosecniSati += $vrstaPlacanjaSlog['sati'];
                    }

                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PROSEK_prosecni_obracun'] == '2' || $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PROSEK_prosecni_obracun'] == '3') {
                        $prosecniIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }

                }

            }

            if ($mdr == '') {
                if (isset($vrstaPlacanjaSlog->maticnadatotekaradnika)) {
                    $mdr = $vrstaPlacanjaSlog->maticnadatotekaradnika->toArray();
                }
            }
            //            $radnik['POR'] = ;
            $radnik['MDR'] = $mdr ?? [];
//            $radnik['KOE'] = ;
            // LOGIKA ZA PREPISIVANJE END
            // PETLJA LOGIKE ZA SUMIRANJE END

            $radnik['ZAR2'] = [
                'SSZNE' => $oSumiranjeZaradeSatiSSZNE,
                'SIZNE' => $oSumiranjeZaradeIznosSIZNE,
                'SSNNE' => $oSumiranjeBolovanjaSatiSSNNE,
                'SINNE' => $oSumiranjeBolovanjaIznosSINNE,
                'IZNETO' => $oSumiranjeZaradeIznosSIZNE + $oSumiranjeBolovanjaIznosSINNE,
                'SIOB' => $sumiranjeIznosaObustavaSIOB,
                'EFSATI' => $efektivniSati,
                'EFIZNO' => $efektivniIznos,
                'TOPSATI' => $topliObrokSati,
                'TOPLI' => $topliObrokIznos,
                'REGR' => $regresIznos,
                'UKNETO' => $oSumiranjeZaradeIznosSIZNE + $oSumiranjeBolovanjaIznosSINNE,
                'REC' => 1,
                'IPLAC' => 0,
                'PRIZ' => $prosecniIznos,
                'PRCAS' => $prosecniSati,
                'PERC' => ((int)$mdr['GGST_godine_staza']) * 0.4,
                'VARIJAB' => $varijaIznos,
                'PREK' => $gSumiranjePrekovremeniPREK,
                'P_R' => $mdr['P_R_oblik_rada'],
//                    'MINIM' => $s / $ss,
                'RBPS' => $mdr['RBPS_priznata_strucna_sprema'],
                'RBRM' => $mdr['RBRM_radno_mesto'],
                'sati_zarade' => $satiZarade,
                'iznos_zarade' => $iznosZarade,
//                'SIZN'=>$sizn,
                'S' => $s,
                'SS' => $ss

//                'OGRAN'=> $SumiranjeOgranicenja,
            ];

            $testCheckZar = 'teest';
        }


        $groupRadnikDataKorak2 = $this->pripremaZaraPodatkePoRadnikuKorakDva($groupRadnikData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);

        $groupRadnikDataKorak3 = $this->pripremaZaraPodatkePoRadnikuKorakTri($groupRadnikDataKorak2, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);

//        $groupRadnikDataKorak4 = $this->pripremaZaraPodatkePoRadnikuKorakCetiri($groupRadnikDataKorak3, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik);

        return $groupRadnikDataKorak3;

    }

    public function pripremaZaraPodatkePoRadnikuKorakDva($groupRadnikData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik)
    {

        $newRadnikData = [];
        foreach ($groupRadnikData as $radnik) {

            $radnik['ZAR'] = $radnik['ZAR2'];
            $zaraUpdated=$radnik['ZAR2'];

            $zar = $radnik['ZAR2'];

//            $kSumiranjeIznosSIZNNE = $zar['SIZNNE'];
//            $kSumiranjeSatiSSZNNE = $zar['SSZNNE'];
            $oSumiranjeZaradeSatiSSZNE = $zar['SSZNE'];
            $oSumiranjeZaradeIznosSIZNE = $zar['SIZNE'];
            $oSumiranjeBolovanjaSatiSSNNE = $zar['SSNNE'];
            $oSumiranjeBolovanjaIznosSINNE = $zar['SINNE'];

            $izNeto = $zar['IZNETO'];
            $sumiranjeIznosaObustavaSIOB = $zar['SIOB'];
            $efektivniSati = $zar['EFSATI'];
            $efektivniIznos = $zar['EFIZNO'];
            $topliObrokSati = $zar['TOPSATI'];
            $topliObrokIznos = $zar['TOPLI'];
            $regresIznos = $zar['REGR'];
            $ukNeto = $zar['UKNETO'];
            $prosecniIznos = $zar['PRIZ'];
            $prosecniSati = $zar['PRCAS'];
//            $sizn = $zar['SIZN'];
            $satiZarade = $zar['sati_zarade'];
            $iznosZarade = $zar['iznos_zarade'];
            $mdr = '';
            $varijaIznos = $zar['VARIJAB'];
            $gSumiranjePrekovremeniPREK = $zar['PREK'];
            $s = $zar['S'];
            $ss = $zar['SS'];

$test='TEST';
//            uasort($radnik->toArray(), 'customSort');

            foreach ($radnik as $key => $vrstaPlacanjaSlog) {

                if ($key == 'ZAR' || $key == 'ZAR2' || $key == 'MDR') {
                    continue;
                }

                if ($mdr == '') {
                    if (isset($vrstaPlacanjaSlog->maticnadatotekaradnika)) {
                        $mdr = $vrstaPlacanjaSlog->maticnadatotekaradnika->toArray();
                    }
                }

                $pok1 = $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['POK1_grupisanje_sati_novca'];
                $pok3 = $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['POK3_prikaz_kroz_unos'];
                $plac = $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PLAC'];

                if ($vrstaPlacanjaSlog['POK2_obracun_minulog_rada'] == 'K') {

                    // FIKSNA P
                    $newIznos = $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik,'K',$zaraUpdated);
                    $vrstaPlacanjaSlog['iznos'] = $newIznos;


                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'G') {

                        $gSumiranjePrekovremeniPREK += $vrstaPlacanjaSlog['sati'];
                    }

//                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] < 'N') {
//
//                        $sizn += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
//
//                    }


                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] < 'O' && $pok1 !== 2) {

                        $oSumiranjeZaradeSatiSSZNE += $vrstaPlacanjaSlog['sati'];

                    } elseif ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'O') {

                        $oSumiranjeBolovanjaSatiSSNNE += $vrstaPlacanjaSlog['sati'];
                        $oSumiranjeBolovanjaIznosSINNE += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik,'K',$zaraUpdated);
                    }


                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] == 'L' && $vrstaPlacanjaSlog['KESC_prihod_rashod_tip'] == 'P') {

                        $topliObrokSati += $vrstaPlacanjaSlog['sati'];
                        $topliObrokIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik,'K',$zaraUpdated);
                        $vrstaPlacanjaSlog['iznos'] = $topliObrokIznos;

                    }

                    if ($vrstaPlacanjaSlog['sifra_vrste_placanja'] == '058') {

                        $regresIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik,'K',$zaraUpdated);

                    }


                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['OGRAN_ogranicenje_za_minimalac'] == '3') {
                        $s += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik,'K',$zaraUpdated);
                        $ss += $vrstaPlacanjaSlog['sati'];
                    }

                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['OGRAN_ogranicenje_za_minimalac'] == '2') {
                        $s += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik,'K',$zaraUpdated);
                    }

                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog->sifra_vrste_placanja]['OGRAN_ogranicenje_za_minimalac'] == '1') {
                        $ss += $vrstaPlacanjaSlog['sati'];
                    }


                    if ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] < 'O') {

                        $oSumiranjeZaradeIznosSIZNE += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik,'K',$zaraUpdated);

//                        $praviloSkip = false;
//                        if ($vrstaPlacanjaSlog['sifra_vrste_placanja'] == '005') {
//                            $praviloSkip = true;
//                        }

                    } elseif ($vrstaPlacanjaSlog['SLOV_grupa_vrste_placanja'] > 'S') {
                        $sumiranjeIznosaObustavaSIOB += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik,'K',$zaraUpdated);
                    }


//                    if DVP->PLAC = '1' .or. DVP->PLAC = '3' .or. DVP->PLAC = '4' .or. DVP->PLAC = '5'
//                     Sati_za = Sati_za + KOP->SATI  //ssnne
//                  endif
//                  if DVP->POK1 = '2' .or. DVP->POK1 = '3'    // 1 - sati, 3 - sati i pare, 2 - pare
//                     Izn_za = Izn_za + nIzn  // SINNE     //  UKUPNI PRIHOD, NETO - SIZNE, SSZNE
//                  endif
//


                    if ($plac == '1' || $plac == '3' || $plac == '4' || $plac == '5') {

                        // PROVERI POK1 Podatak
                        $satiZarade += $vrstaPlacanjaSlog['sati'];

                    }

                    if ($pok1 == '2' || $pok1 == '3') {
                        $iznosZarade += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }


                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PROSEK_prosecni_obracun'] == '1' || $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PROSEK_prosecni_obracun'] == '3') {

                        $prosecniSati += $vrstaPlacanjaSlog['sati'];
                    }


                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PROSEK_prosecni_obracun'] == '2' || $vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['PROSEK_prosecni_obracun'] == '3') {
                        $prosecniIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }

                    if ($vrstePlacanjaSifarnik[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['EFSA_efektivni_sati']) {
                        $efektivniSati += $vrstaPlacanjaSlog['sati'];
                        $efektivniIznos += $this->obradaFormuleService->kalkulacijaFormule($vrstaPlacanjaSlog, $vrstePlacanjaSifarnik, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, [],$zaraUpdated);
                    }
                    $zaraUpdated['SSZNE'] = $oSumiranjeZaradeSatiSSZNE;
                    $zaraUpdated['SIZNE'] = $oSumiranjeZaradeIznosSIZNE;
                    $zaraUpdated['SSNNE'] = $oSumiranjeBolovanjaSatiSSNNE;
                    $zaraUpdated['SINNE'] = $oSumiranjeBolovanjaIznosSINNE;
                    $zaraUpdated['IZNETO'] = $oSumiranjeZaradeIznosSIZNE + $oSumiranjeBolovanjaIznosSINNE+$topliObrokIznos;
                    $zaraUpdated['UKNETO'] = $radnik['ZAR']['UKNETO'];
                    $zaraUpdated['PERC'] = $radnik['ZAR']['PERC'];
                    $zaraUpdated['P_R'] = $radnik['ZAR']['P_R'];
                    $zaraUpdated['SIOB'] = $sumiranjeIznosaObustavaSIOB;
                    $zaraUpdated['EFSATI'] = $efektivniSati;
                    $zaraUpdated['EFIZNO'] = $efektivniIznos;
                    $zaraUpdated['REGR'] = $regresIznos;
                    $zaraUpdated['TOPSATI'] = $topliObrokSati;
                    $zaraUpdated['TOPLI'] = $topliObrokIznos;
                    $zaraUpdated['RBPS'] = $mdr['RBPS_priznata_strucna_sprema'];
                    $zaraUpdated['MINIM'] = $ss > 0 ? $s / $ss : 0;
                    $zaraUpdated['PREK'] = $gSumiranjePrekovremeniPREK;
                    $zaraUpdated['PRIZ'] = $prosecniIznos;
                    $zaraUpdated['PRCAS'] = $prosecniSati;
                    $zaraUpdated['sati_zarade'] = $satiZarade;
                    $zaraUpdated['iznos_zarade'] = $iznosZarade;
                    $zaraUpdated['S'] = $s;
                    $zaraUpdated['SS'] = $ss;
                    $zaraUpdated['VARIJAB'] = $varijaIznos;



                }





            }


            $radnik['ZAR3'] = [
                'SSZNE' => $oSumiranjeZaradeSatiSSZNE,
                'SIZNE' => $oSumiranjeZaradeIznosSIZNE,
                'SSNNE' => $oSumiranjeBolovanjaSatiSSNNE,
                'SINNE' => $oSumiranjeBolovanjaIznosSINNE,
//                'SIZN'=>$sizn,
                'IZNETO' => $oSumiranjeZaradeIznosSIZNE + $oSumiranjeBolovanjaIznosSINNE+$topliObrokIznos,
                'UKNETO' => $radnik['ZAR']['UKNETO'], //  ZAR->UKNETO SLUZI ZA OBRACUN MINULOG RADA
                'PERC' => $radnik['ZAR']['PERC'],
                'P_R' => $radnik['ZAR']['P_R'],
                'SIOB' => $sumiranjeIznosaObustavaSIOB,
                'EFSATI' => $efektivniSati,
                'EFIZNO' => $efektivniIznos,
                'REGR' => $regresIznos,
                'TOPSATI' => $topliObrokSati,
                'TOPLI' => $topliObrokIznos,
                'RBPS' => $mdr['RBPS_priznata_strucna_sprema'],
                'MINIM' => $ss > 0 ? $s / $ss : 0,
                'PREK' => $gSumiranjePrekovremeniPREK,
                'PRIZ' => $prosecniIznos,
                'PRCAS' => $prosecniSati,
                'sati_zarade' => $satiZarade,
                'iznos_zarade' => $iznosZarade,
                'S' => $s,
                'SS' => $ss,
                'VARIJAB' => $varijaIznos,
//                'SINNE' => $iznosNaknada
            ];

            $newRadnikData[] = $radnik;

        }
        return $newRadnikData;
    }

    public function pripremaZaraPodatkePoRadnikuKorakTri($groupRadnikData, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik)
    {

        $newRadnikData = [];
        foreach ($groupRadnikData as $radnik) {

            $radnik['ZAR2'] = $this->prepareZaraData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData);
            $radnik['DKOPADD'] = $this->prepareDKopData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData, $poresDoprinosiSifarnik, $vrstePlacanjaSifarnik);
            $radnik['ZAR3'] = $radnik['DKOPADD']['ZAR3'];
            $radnik['ZAR4'] = $this->prepareBrutoData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData, $poresDoprinosiSifarnik, $vrstePlacanjaSifarnik);
            $radnik['KREDADD'] = $this->prepareKrediti($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData, $poresDoprinosiSifarnik, $vrstePlacanjaSifarnik);

            $radnik['ZAR5'] = $radnik['KREDADD']['KREDADD']['ZAR5'];

            $this->createDkopData($radnik['KREDADD'], $radnik['DKOPADD']);
            $this->updateDkopData($radnik);

            $this->updateZara($radnik['ZAR5'], $radnik['MDR'], $poresDoprinosiSifarnik);
            $newRadnikData[] = $radnik;


        }
        $test = 'test';

//        $this->obradaZaraPoRadnikuInterface->createMany($newRadnikData);

        return $newRadnikData;
    }


    public function prepareZaraData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData)
    {

        $solid = 0;
        $nt2 = (float)$minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada;
        // ZAR->OLAKSICA = minimalac po radniku

        $olaksica = $nt2 / $monthData->mesecni_fond_sati;// NTO->NT2/KOE->BR_S

        $zar = $radnik['ZAR3'];

//        foreach ($radnik as $key => $vrstaPlacanjaSlog) {
//
//            if ($key == 'ZAR' || $key == 'MDR') {
//                continue;
//            }
//
//            $test='TEST';
//
//        }

        // 1092 linija MINIMALAC
        if ($olaksica > $zar['MINIM']) {  // Olaksica ne sme da bude manja od minimalne propisane zarade

            $tabelaKoristnikMinuliRadEnabled = 1;
            if ($tabelaKoristnikMinuliRadEnabled == 1) {
//                $zar['SOLID'] =  0 ;//( ZAR->OLAKSICA -ZAR->MINIM)*SS

                $solid = ($olaksica - $zar['MINIM']) * $zar['SS'];
                $minsol = $solid * (int)$radnik['MDR']['GGST_godine_staza'] * 0.4 / 100; // TODO UBACITI VREDNOST INFORMACIJE O FIRMI
                $minsol = 0; // TODO TRENUTNA SITUACIJA ZAVISI OD PRAVILNIKA
            } else if ($tabelaKoristnikMinuliRadEnabled == 0) {
//                replace ZAR->SOLID with (( ZAR->OLAKSICA -ZAR->MINIM)*SS)  //  NOVI OBracun za DRUMSKA i Solko i sve ostale
//                $solid  =  ($olaksica -  $zar['MINIM']) * $zar['SS'];
                $solid = ($olaksica - $zar['MINIM']) * $zar['SS'];

            }
        } elseif ($olaksica <= $zar['MINIM']) {
            $solid = 0;

        }

        // 1114

        $solid += $minsol ?? 0;

        $zar['SOLID'] = $solid; //

        // NAKON SUMIRANJA
//        if ZAR->IZNETO <= (NTO->NT1*NTO->STOPA6)
//        replace ZAR->UKUPNO with ZAR->IZNETO  // za sve firme
//           elseif ZAR->IZNETO > (NTO->NT1*NTO->STOPA6)
//             replace ZAR->UKUPNO with (NTO->NT1*NTO->STOPA6)
//           END


        // 1184 za sve firme
        $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] = $zar['SIZNE'] + $zar['SINNE'] + $solid;

        if ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] <= $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
            $zar['UKUPNO'] = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];

        } elseif ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
            $zar['UKUPNO'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
        }

        // 1191

        $radnikData = [
            'SSZNE_suma_sati_zarade' => $zar['SSZNE'],
            'SIZNE_ukupni_iznos_zarade' => $zar['SIZNE'],
            'PREK_prekovremeni' => $zar['PREK'],
            'SSNNE_suma_sati_naknade' => $zar['SSNNE'],
            'SINNE_ukupni_iznos_naknade' => $zar['SINNE'],
            'SIOB_ukupni_iznos_obustava' => $zar['SIOB'],
            'TOPLI_obrok_sati' => $zar['TOPSATI'],
            'TOPLI_obrok_iznos' => $zar['TOPLI'],
            'REGRES_iznos_regresa' => $zar['REGR'],
            'PRCAS_prosecni_sati_godina' => $zar['PRCAS'],
            'PRIZ_prosecni_iznos_godina' => $zar['PRIZ'],
            'PRCAS' => $zar['PRCAS'],
            'PRIZ' => $zar['PRIZ'],
            'EFSATI_ukupni_iznos_efektivnih_sati' => $zar['EFSATI'],
            'EFIZNO_kumulativ_iznosa_za_efektivne_sate' => $zar['EFIZNO'],
            'IZNETO_zbir_ukupni_iznos_naknade_i_naknade' => $zar['SIZNE'] + $zar['SINNE'] + $solid,
            'UKSA_ukupni_sati_za_isplatu' => $zar['SSZNE'] + $zar['SSNNE'],
            'UKUPNO' => $zar['UKUPNO'],
            'IZBRPR' => $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'],
            'solid' => $solid,
            'user_dpsm_id' => $radnik[0]->user_dpsm_id,
            'obracunski_koef_id' => $monthData->id,
            'user_mdr_id' => $radnik[0]->user_mdr_id,
            'PERC' => $zar['PERC'],
            'PLACENO' => 0,
        ];

        $izbr1 = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];
        $izbr2 = 0;
        $izbr3 = $zar['IZNETO'] > 0 ? $zar['SIZNE'] / $zar['IZNETO'] : 0; // PER1
        $radnikData['PER1'] = $izbr3;
        $izbr6 = 0;
        $izbr5 = $zar['IZNETO'] > 0 ? $zar['SINNE'] / $zar['IZNETO'] : 0; // PER2
        $radnikData['PER2'] = $izbr5;
        $izbr7 = 0;
        $izbr8 = 0;
        $izbr50 = 0;
        $izbr51 = 0;
        $izbr52 = 0;
        $izbr53 = 0;


        // 1202
        if ($radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] < $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada && $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > 0 && ($minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati > $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] / $radnikData['UKSA_ukupni_sati_za_isplatu'])) {
            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] <= $monthData->mesecni_fond_sati) {
                $izbr2 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati * $radnikData['UKSA_ukupni_sati_za_isplatu'];
                $izbr6 = 0;
                $izbr50 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada;
            }

            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] > $monthData->mesecni_fond_sati) {

                $izbr2 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati * $monthData->mesecni_fond_sati;
                $izbr6 = 0;
                $izbr50 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada;

            }
        }
//        if ($radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] >= $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada || ($minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati < $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] / $radnikData['UKSA_ukupni_sati_za_isplatu'])) {
//
//            $izbr6 = $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];
//            $izbr2 = 0;
//            $izbr50 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada;
//
//        }

//$izbr6 -
//$izbr2 -
//$izbr50 -


        // ZDRAVSTVENO I NEZAPOSLENOST POCETAK
        // TODO

        if ($radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] < $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada && $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > 0 && ($minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati > $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] / $radnikData['UKSA_ukupni_sati_za_isplatu'])) {

            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] <= $monthData->mesecni_fond_sati) {
                $izbr51 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati * $radnikData['UKSA_ukupni_sati_za_isplatu'];
                $izbr52 = 0;
                $izbr53 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada;
            }
            if ($radnikData['UKSA_ukupni_sati_za_isplatu'] > $monthData->mesecni_fond_sati) {
                $izbr51 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati * $monthData->mesecni_fond_sati;
                $izbr52 = 0;
                $izbr53 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada;
            }


        }

//        if ($radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] >= $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada || ($minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada / $monthData->mesecni_fond_sati < $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] / $radnikData['UKSA_ukupni_sati_za_isplatu'])) {
//
//            $izbr51 = $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];
//            $izbr52 = 0;
//            $izbr53 = $minimalneBrutoOsnoviceSifarnik->NT2_minimalna_bruto_zarada;
//        }


//        DO CASE
//               case ZAR->IZNETO <= NTO->NT1   // NT1_prosecna_mesecna_zarada_u_republici
//                  IZBR1 = ZAR->IZNETO
//               case ZAR->IZNETO > NTO->NT1
//                  IZBR1 = ZAR->IZNETO
//            endcase


        // 1733
        if ($radnikData['solid'] > 0) {
            $radnikData['IZBRBO1'] = ($radnikData['solid'] + $radnikData['SINNE_ukupni_iznos_naknade']) + ($radnikData['SINNE_ukupni_iznos_naknade'] * $radnikData['PERC'] / 100); // 0.4 = PERC
        } else {
            $radnikData['IZBRBO1'] = 0;
        }

        $radnikData['OSNOV'] = ($izbr50 / $monthData->mesecni_fond_sati) * $radnikData['SSZNE_suma_sati_zarade'];


        if ($radnikData['solid'] > 0) {
            $radnikData['IZBRBO2'] = ($radnikData['SIZNE_ukupni_iznos_zarade'] + $radnikData['SINNE_ukupni_iznos_naknade'] + $radnikData['solid'] + $radnikData['PLACENO']);
        } else {
            $radnikData['IZBRBO2'] = 0;
        }

        $radnikData['OSNOVZ'] = ($izbr53 / $monthData->mesecni_fond_sati) * ($radnikData['SSZNE_suma_sati_zarade']);


        if ($radnikData['IZBRBO1'] < $radnikData['IZBRBO2']) {
            $radnikData['IZBRBO1'] = $radnikData['IZBRBO2'];
        }


        if ($radnikData['SSNNE_suma_sati_naknade'] < $monthData->mesecni_fond_sati) {

            $radnikData['POSPOR'] = $izbr5;
        } else {
            $radnikData['POSPOR'] = 0;
        }

        if ($radnikData['SSNNE_suma_sati_naknade'] == $monthData->mesecni_fond_sati) {

            $radnikData['SIN'] = $izbr8;
        } else {
            $radnikData['SIN'] = 0;
        }
        $radnikData['SIPBOL'] = $izbr7;


        $radnikData['KONTROLA'] = $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];


        if ($radnikData['KONTROLA'] > $radnikData['IZBRBO1']) {
            $radnikData['IZBRBOL'] = $radnikData['KONTROLA'];
        } else {
            $radnikData['IZBRBOL'] = 0;
        }


        if ($radnikData['IZBRBOL'] + $radnikData['IZBRBO1'] + $radnikData['POSPOR'] + $radnikData['SIN'] + $radnikData['SIPBOL'] <= $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {

            if ($radnikData['IZBRBOL'] > 0) {
                $radnikData['UKUPNO'] = $radnikData['IZBRBOL'] + $radnikData['POSPOR'] + $radnikData['SIN'] + $radnikData['SIPBOL'];
            }

            if ($radnikData['IZBRBO1'] > 0) {
                $radnikData['UKUPNO'] = $radnikData['IZBRBO1'] + $radnikData['POSPOR'] + $radnikData['SIN'] + $radnikData['SIPBOL'];
            }
        }


        if ($radnikData['IZBRBOL'] + $radnikData['IZBRBO1'] + $radnikData['POSPOR'] + $radnikData['SIN'] + $radnikData['SIPBOL'] > $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {

            $radnikData['UKUPNO'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
        }
        if ($radnikData['IZBRBOL'] + $radnikData['IZBRBO1'] + $radnikData['POSPOR'] + $radnikData['SIN'] + $radnikData['SIPBOL'] <= $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {

            $radnikData['UKUPNO1'] = $radnikData['IZBRBO2'];

        } elseif ($radnikData['IZBRBOL'] + $radnikData['IZBRBO1'] + $radnikData['POSPOR'] + $radnikData['SIN'] + $radnikData['SIPBOL'] > $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {

            $radnikData['UKUPNO1'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
        }


//        if ($radnikData['IZBRBOL'] + $radnikData['IZBRBO1'] > $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
//            $radnikData['UKUPNO'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
//        }
//
//            if (($radnikData['IZBRBOL'] + $radnikData['IZBRBO1']) <= ($minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos)) {
//                $radnikData['UKUPNO1'] = $radnikData['IZBRBO2'];
//            } elseif (($radnikData['IZBRBOL'] + $radnikData['IZBRBO1']) > ($minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos)) {
//                $radnikData['UKUPNO1'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
//            }
//
//
//
//
        if ($radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] <= $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
            $radnikData['UKUPNO'] = $radnikData['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];

        } elseif ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos) {
            $radnikData['UKUPNO'] = $minimalneBrutoOsnoviceSifarnik->NT1_prosecna_mesecna_zarada_u_republici * $minimalneBrutoOsnoviceSifarnik->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos;
        }
//
//            $izbr7 = 0;
//            $radnikData['SIPBOL'] = $izbr7;
//            $radnikData['SIDBOL'] = $izbr7;


        // TODO
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
            $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik['053']['naziv_naziv_vrste_placanja'];

            $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik['053']['SLOV_grupe_vrsta_placanja'];
            $newPlacanje['POK2_obracun_minulog_rada'] = $vrstePlacanjaSifarnik['053']['POK2_obracun_minulog_rada'];
            $newPlacanje['iznos'] = $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->ZDRO_zdravstveno_osiguranje_na_teret_radnika - $poresDoprinosiSifarnik->ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika);

            $newPlacanje['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
            $newPlacanje['KESC_prihod_rashod_tip'] = 'R';
            $newPlacanje['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
            $newPlacanje['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
            $newPlacanje['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
            $newPlacanje['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];


            $newPlacanje['user_mdr_id'] = $radnikData['user_mdr_id'];
            $newPlacanje['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnikData['user_dpsm_id'];


            $sveVrstePlacanja[] = $newPlacanje;
        }

        if($zar['solid'] > 0 ){
            $newPlacanje['maticni_broj'] = $mdr['MBRD_maticni_broj'];
            $newPlacanje['sifra_vrste_placanja'] = '410';
            $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik['410']['naziv_naziv_vrste_placanja'];

            $newPlacanje['SLOV_grupa_vrste_placanja'] = 'A';
            $newPlacanje['POK2_obracun_minulog_rada'] = 'K';
            $newPlacanje['iznos'] =$zar['solid'];

            $newPlacanje['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
            $newPlacanje['KESC_prihod_rashod_tip'] = 'P';
            $newPlacanje['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
            $newPlacanje['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
            $newPlacanje['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
            $newPlacanje['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];


            $newPlacanje['user_mdr_id'] = $radnikData['user_mdr_id'];
            $newPlacanje['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnikData['user_dpsm_id'];

            $sveVrstePlacanja[] = $newPlacanje;
        }

        if ($zar['UKUPNO'] * $poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika > 0) {
            //ZDRAVSTVENO
            $newPlacanje['maticni_broj'] = $mdr['MBRD_maticni_broj'];
            $newPlacanje['sifra_vrste_placanja'] = '054';
            $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik['054']['naziv_naziv_vrste_placanja'];

            $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik['054']['SLOV_grupe_vrsta_placanja'];
            $newPlacanje['POK2_obracun_minulog_rada'] = 'K';
            $newPlacanje['iznos'] = $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->PIO_pio_na_teret_radnika - $poresDoprinosiSifarnik->ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika);

            $newPlacanje['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
            $newPlacanje['KESC_prihod_rashod_tip'] = 'R';
            $newPlacanje['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
            $newPlacanje['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
            $newPlacanje['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
            $newPlacanje['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];


            $newPlacanje['user_mdr_id'] = $radnikData['user_mdr_id'];
            $newPlacanje['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnikData['user_dpsm_id'];


            $sveVrstePlacanja[] = $newPlacanje;
        }

        if ($zar['UKUPNO'] * $poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika > 0) {
            //NEZAPOSLENOST
            $newPlacanje['maticni_broj'] = $mdr['MBRD_maticni_broj'];
            $newPlacanje['sifra_vrste_placanja'] = '055';
            $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik['055']['naziv_naziv_vrste_placanja'];
            $newPlacanje['SLOV_grupa_vrste_placanja'] = $vrstePlacanjaSifarnik['055']['SLOV_grupe_vrsta_placanja'];
            $newPlacanje['POK2_obracun_minulog_rada'] = 'K';
            $newPlacanje['iznos'] = $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->PIO_pio_na_teret_radnika - $poresDoprinosiSifarnik->ZDRO_zdravstveno_osiguranje_na_teret_radnika);

            $newPlacanje['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
            $newPlacanje['KESC_prihod_rashod_tip'] = 'R';
            $newPlacanje['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
            $newPlacanje['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
            $newPlacanje['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
            $newPlacanje['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];


            $newPlacanje['user_mdr_id'] = $radnikData['user_mdr_id'];
            $newPlacanje['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnikData['user_dpsm_id'];


            $sveVrstePlacanja[] = $newPlacanje;
        }


        $nIzn = 0;
        $zar['PLACENO'] = 0;
        if ($zar['IZBRPR'] == 0) {
            $nIzn = 0;
        }

        if ($zar['IZBRPR'] > 0) {
            if ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni'] < $monthData->mesecni_fond_sati) {

                $nIzn = ($zar['SIZNE_ukupni_iznos_zarade'] + $zar['SINNE_ukupni_iznos_naknade'] + $zar['solid'] - ($poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja / $monthData->mesecni_fond_sati * ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni']))) * $minimalneBrutoOsnoviceSifarnik->P1_stopa_poreza;
            }

            if (($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni']) >= $monthData->mesecni_fond_sati) {

                $nIzn = ($zar['SIZNE_ukupni_iznos_zarade'] + $zar['SINNE_ukupni_iznos_naknade'] + $zar['solid'] + $zar['PLACENO'] - $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja) * $minimalneBrutoOsnoviceSifarnik->P1_stopa_poreza;
            }
        }


        if ($nIzn > 0) {

            $newPlacanje['maticni_broj'] = $mdr['MBRD_maticni_broj'];
            $newPlacanje['sifra_vrste_placanja'] = '050';
            $newPlacanje['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik['050']['naziv_naziv_vrste_placanja'];;
            $newPlacanje['SLOV_grupa_vrste_placanja'] = 'U';
            $newPlacanje['POK2_obracun_minulog_rada'] = 'K';
            $newPlacanje['iznos'] = $nIzn;
//            replace KOP->IZNO   with nIzn , ZAR->SIPPR with nIzn, ZAR->SIOB with SIOB

            $zar['SIPPR'] = $nIzn;
            $newPlacanje['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
            $newPlacanje['KESC_prihod_rashod_tip'] = 'R';
            $newPlacanje['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
            $newPlacanje['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
            $newPlacanje['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
            $newPlacanje['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];


            $newPlacanje['user_mdr_id'] = $radnikData['user_mdr_id'];
            $newPlacanje['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
            $newPlacanje['user_dpsm_id'] = $radnikData['user_dpsm_id'];

            if ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni'] < $monthData->mesecni_fond_sati) {

                $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja / $monthData->mesecni_fond_sati * ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni']);
            }

            if ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni'] >= $monthData->mesecni_fond_sati) {
                $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;

            }

            $sveVrstePlacanja[] = $newPlacanje;

        } else {
            $zar['SIPPR'] = 0;
        }

        $bruto = 0;
        $bruto = $zar['SIPPR'];

        if ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] > $zar['IZBRBO1']) {
            $zar['SID'] = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] * $poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika;
        } elseif ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] < $zar['IZBRBO1']) {
            $zar['SID'] = $zar['UKUPNO'] * $poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika;

        }

        $sveVrstePlacanja['ZAR3'] = $zar;
        return $sveVrstePlacanja;
    }

    public function prepareBrutoData($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData, $poresDoprinosiSifarnik, $vrstePlacanjaSifarnik)
    {
        $zar = $radnik['ZAR3'];
        $zar['SIPBOL'] = 0;
        $zar['SIDBOL'] = 0;


        $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] = $zar['SIZNE_ukupni_iznos_zarade'] + $zar['SINNE_ukupni_iznos_naknade'] + $zar['solid'];

        $zar['IZBRUTO'] = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'];
        $zar['SID'] = $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->ZDRO_zdravstveno_osiguranje_na_teret_radnika - $poresDoprinosiSifarnik->ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika) + $zar['UKUPNO'] * ($poresDoprinosiSifarnik->UKDOPR_ukupni_doprinosi_na_teret_radnika - $poresDoprinosiSifarnik->PIO_pio_na_teret_radnika);
        $zar['SIP'] = $zar['SIPPR'] + $zar['SIPBOL'];
        $zar['SIP_D'] = $zar['SIPPR'] + $zar['SID'] + $zar['SIDBOL'] + $zar['SIPBOL'];

        if ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni'] < $monthData->mesecni_fond_sati) {
            $zar['POROSL'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja / $monthData->mesecni_fond_sati * ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni']);
        }

        if ($zar['UKSA_ukupni_sati_za_isplatu'] - $zar['PREK_prekovremeni'] >= $monthData->mesecni_fond_sati) {
            $zar['POROSL'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
        }

        $zar['NETO'] = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] - $zar['SIP'] - $zar['SID']; // TODO ODUZMI KREDITE

        return $zar;
    }

    public function prepareKrediti($radnik, $minimalneBrutoOsnoviceSifarnik, $monthData, $poresDoprinosiSifarnik, $vrstePlacanjaSifarnik)
    {
        $kreditLimit = 0.3;

        $maticniBroj = $radnik['MDR']['MBRD_maticni_broj'];

        $radnikData = $radnik[0];
        $kreditiData = [];

        $krediti = $this->dpsmKreditiInterface->where('maticni_broj', $maticniBroj)->get();

//        $kreditiObrada = $this->obradaKreditiInterface->where('maticni_broj', $maticniBroj)->get();
        $zar = $radnik['ZAR4'];
        $mdr = $radnik['MDR'];
//        if ($krediti->count()) {
        if (false) {
            $siobkr = 0;
            $neto2 = ($zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] - $zar['SIP'] - $zar['SID'] - $zar['SIOB_ukupni_iznos_obustava']) * $kreditLimit; //ZAR->AKONT - ZAR->IPLAC - SNRAKON - SVAKON
            $kreditUpdate = [];

            foreach ($krediti as $kredit) {

//                $kreditUpdate = $kredit->RATA_rata;
                if (($neto2 - $siobkr - $kredit->RATA_rata -$kredit->RATB) > 0 && $kredit->SALD_saldo-$kredit->RATB > 0) {

                    $kredit->iznos = $kredit->RATA_rata - $kredit->RATB;
                    $kredit->SALD_saldo =  $kredit->SALD_saldo - ($kredit->RATA_rata - $kredit->RATB);

                    $data = [
                        'maticni_broj' => $kredit->maticni_broj,
                        'sifra_vrste_placanja' => '093',
                        'naziv_vrste_placanja' => 'Krediti',
                        'SIFK_sifra_kreditora' => $kredit->SIFK_sifra_kreditora,
                        'PART_partija_kredita' => $kredit->PART_partija_poziv_na_broj,
                        'KESC_prihod_rashod_tip' => $vrstePlacanjaSifarnik['093']['KESC_prihod_rashod_tip'],
                        'GLAVN_glavnica' => $kredit->GLAVN_glavnica,
                        'SALD_saldo' => $kredit->SALD_saldo - ($kredit->RATA_rata - $kredit->RATB),
                        'RATA_rata' => $kredit->RATA_rata,
                        'POCE_pocetak_zaduzenja' => $kredit->POCE_pocetak_zaduzenja,
                        'RATP_prethodna' => $kredit->RATP_prethodna,
                        'STSALD_Prethodni_saldo' => $kredit->SALD_saldo,
                        'DATUM_zaduzenja' => $kredit->DATUM_zaduzenja,
                        'obracunski_koef_id' => $monthData->id,
                        'iznos'=> $kredit->RATA_rata,
                        'user_mdr_id' => $kredit->user_mdr_id,
                        'RBZA'=>$kredit->RBZA,
                        'RATB'=>$kredit->RATB
                    ];




//                    $kreditUpdate['maticni_broj'] = $mdr['MBRD_maticni_broj'];
//                    $kreditUpdate['sifra_vrste_placanja'] = '093';
//                    $kreditUpdate['naziv_vrste_placanja'] = $vrstePlacanjaSifarnik['093']['naziv_naziv_vrste_placanja'];
//                    $kreditUpdate['SLOV_grupa_vrste_placanja'] = 'V';
//                    $kreditUpdate['POK2_obracun_minulog_rada'] = 'G';
//                    $kreditUpdate['iznos'] = $kredit->RATA_rata;
////            replace KOP->IZNO   with nIzn , ZAR->SIPPR with nIzn, ZAR->SIOB with SIOB
//
//                    $kreditUpdate['RBRM_radno_mesto'] = $mdr['RBRM_radno_mesto'];
//                    $kreditUpdate['KESC_prihod_rashod_tip'] = 'R';
//                    $kreditUpdate['P_R_oblik_rada'] = $mdr['P_R_oblik_rada'];
//                    $kreditUpdate['troskovno_mesto_id'] = $mdr['troskovno_mesto_id']; // RBTC
//                    $kreditUpdate['KOEF_osnovna_zarada'] = $mdr['KOEF_osnovna_zarada'];
//                    $kreditUpdate['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];
//
//                    $kreditUpdate['STSALD_Prethodni_saldo'] = $kredit->SALD_saldo;
//                    $kreditUpdate['user_mdr_id'] = $mdr['id'];
//                    $kreditUpdate['obracunski_koef_id'] = $radnikData['obracunski_koef_id'];
//                    $kreditUpdate['user_dpsm_id'] = $radnikData['user_dpsm_id'];
//
//                    $kreditUpdate['RBPS_strucna_sprema'] = $mdr['RBPS_priznata_strucna_sprema'];
//
//                    $kreditUpdate['SALD_saldo'] = $kredit->SALD_saldo;
//                    $kreditUpdate['PART_partija_kredita'] = $kredit->PART_partija_poziv_na_broj;
//
//                    $kreditUpdate['SIFRA_KREDITORA'] = $kredit->SIFK_sifra_kreditora;
//                    $kreditUpdate['POCE_'] = $kredit->POCE_pocetak_zaduzenja;
//                    $kreditUpdate['DATUM_KRED'] = $kredit->DATUM_zaduzenja;


//                    RATB
//                    RATP
//                    $kreditUpdate['BR']
//                    POCE_pocetak_zaduzenja
//                    $kreditUpdate['HKMB'] = $kredit->SALD_saldo;


                    $siobkr += $kredit->RATA_rata;
                } else if ($neto2 > 0 && $kredit->SALD_saldo > 0) {

                    $siobkr += $kredit->RATA_rata;

                } else if ($neto2 - $siobkr <= 0 && $kredit->SALD_saldo > 0) {

                }

                if(!empty($data)){
                    $kreditiData[] = $data;
                }
            }

            if(count($kreditiData)){
                $this->obradaKreditiInterface->createMany($kreditiData);
                $kreditiData['KREDADD'] = $kreditiData;

            }

            $zar['ZARKR_ukupni_zbir_kredita'] = $siobkr;
            $zar['RBIM_isplatno_mesto_id'] = $mdr['RBIM_isplatno_mesto_id'];


            $zar['ZARKR_ukupni_zbir_kredita'] = 0;

            $zar['ISPLATA'] = $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'] - ($zar['SIP'] + $zar['SID'] + $zar['SIOB_ukupni_iznos_obustava'] + $zar['ZARKR_ukupni_zbir_kredita']);



        }
        $kreditiData['KREDADD']['ZAR5'] = $zar;


        return $kreditiData;
    }

    public function createDkopData($dkop, $dkop2)
    {

        $data = [];
        foreach ($dkop as $key => $vrstaPlacanja) {
            if ($key == 'KREDADD') {
                continue;
            }
            try {
                $vrstaPlacanja['maticni_broj'];
            } catch (\Exception $exception) {
                $test = 'Test';
            }
            $data1 = [
                'maticni_broj' => $vrstaPlacanja['maticni_broj'],
                'sifra_vrste_placanja' => $vrstaPlacanja['sifra_vrste_placanja'],
                'naziv_vrste_placanja' => $vrstaPlacanja['naziv_vrste_placanja'],
                'SLOV_grupa_vrste_placanja' => $vrstaPlacanja['SLOV_grupa_vrste_placanja'],
                'POK2_obracun_minulog_rada' => $vrstaPlacanja['POK2_obracun_minulog_rada'],
                'iznos' => $vrstaPlacanja['iznos'],
                'RBRM_radno_mesto' => $vrstaPlacanja['RBRM_radno_mesto'],
                'KESC_prihod_rashod_tip' => $vrstaPlacanja['KESC_prihod_rashod_tip'],
                'P_R_oblik_rada' => $vrstaPlacanja['P_R_oblik_rada'],
                'troskovno_mesto_id' => $vrstaPlacanja['troskovno_mesto_id'],
                'KOEF_osnovna_zarada' => $vrstaPlacanja['KOEF_osnovna_zarada'],
                'RBIM_isplatno_mesto_id' => $vrstaPlacanja['RBIM_isplatno_mesto_id'],
                'user_mdr_id' => $vrstaPlacanja['user_mdr_id'],
                'obracunski_koef_id' => $vrstaPlacanja['obracunski_koef_id'],
                'user_dpsm_id' => $vrstaPlacanja['user_dpsm_id'],
                'tip_unosa' => 'kroz_kod'
            ];
            $data[] = $data1;
        }
        foreach ($dkop2 as $key => $vrstaPlacanja) {

            if ($key == 'ZAR3') {
                continue;
            }
//            if(){
//
//            }

            try {
                $testtt = $vrstaPlacanja['naziv_vrste_placanja'];
            } catch (\Exception $exception) {
                $testtt = 2;
            }
            $data2 = [
                'maticni_broj' => $vrstaPlacanja['maticni_broj'],
                'sifra_vrste_placanja' => $vrstaPlacanja['sifra_vrste_placanja'],
                'naziv_vrste_placanja' => $vrstaPlacanja['naziv_vrste_placanja'],
                'SLOV_grupa_vrste_placanja' => $vrstaPlacanja['SLOV_grupa_vrste_placanja'],
                'POK2_obracun_minulog_rada' => $vrstaPlacanja['POK2_obracun_minulog_rada'],
                'iznos' => $vrstaPlacanja['iznos'],
                'RBRM_radno_mesto' => $vrstaPlacanja['RBRM_radno_mesto'],
                'KESC_prihod_rashod_tip' => $vrstaPlacanja['KESC_prihod_rashod_tip'],
                'P_R_oblik_rada' => $vrstaPlacanja['P_R_oblik_rada'],
                'troskovno_mesto_id' => $vrstaPlacanja['troskovno_mesto_id'],
                'KOEF_osnovna_zarada' => $vrstaPlacanja['KOEF_osnovna_zarada'],
                'RBIM_isplatno_mesto_id' => $vrstaPlacanja['RBIM_isplatno_mesto_id'],
                'user_mdr_id' => $vrstaPlacanja['user_mdr_id'],
                'obracunski_koef_id' => $vrstaPlacanja['obracunski_koef_id'],
                'user_dpsm_id' => $vrstaPlacanja['user_dpsm_id'],
                'tip_unosa' => 'kroz_kod'
            ];
            $data[] = $data2;
        }

        $this->dkopSveVrstePlacanjaInterface->createMany($data);
    }

    public function updateDkopData($radnik)
    {
        foreach ($radnik as $key => $vrstaPlacnja) {
            if ($key == 'MDR' || $key == 'ZAR2' || $key == 'ZAR' || $key == 'ZAR3' || $key == 'DKOPADD' || $key == 'ZAR4' || $key == 'KREDADD' || $key == 'ZAR5') {
                continue;
            }
//            $test2='test2';

//            try {
//              $testt =$vrstaPlacnja['iznos'];
//            }catch (\Exception $exception){
//                $testt='w';
//            }
            if ($vrstaPlacnja['iznos'] !== null) {
                $this->dkopSveVrstePlacanjaInterface->where('id', $vrstaPlacnja['id'])->update(['iznos' => $vrstaPlacnja['iznos']]);
            }
        }

    }

    public function updateZara($zar, $mdr, $poresDoprinosiSifarnik)
    {

        $data = [
            'SSZNE_suma_sati_zarade' => $zar['SSZNE_suma_sati_zarade'],
            'SIZNE_ukupni_iznos_zarade' => $zar['SIZNE_ukupni_iznos_zarade'],
            'PREK_prekovremeni' => $zar['PREK_prekovremeni'],
            'SSNNE_suma_sati_naknade' => $zar['SSNNE_suma_sati_naknade'],
            'SINNE_ukupni_iznos_naknade' => $zar['SINNE_ukupni_iznos_naknade'],
            'SIOB_ukupni_iznos_obustava' => $zar['SIOB_ukupni_iznos_obustava'],
            'TOPLI_obrok_sati' => $zar['TOPLI_obrok_sati'],
            'TOPLI_obrok_iznos' => $zar['TOPLI_obrok_iznos'],
            'REGRES_iznos_regresa' => $zar['REGRES_iznos_regresa'],
            'PRCAS_prosecni_sati_godina' => $zar['PRCAS'],
            'PRIZ_prosecni_iznos_godina' => $zar['PRIZ'],
            'EFSATI_ukupni_iznos_efektivnih_sati' => $zar['EFSATI_ukupni_iznos_efektivnih_sati'],
            'EFIZNO_kumulativ_iznosa_za_efektivne_sate' => $zar['EFIZNO_kumulativ_iznosa_za_efektivne_sate'],
            'IZNETO_zbir_ukupni_iznos_naknade_i_naknade' => $zar['IZNETO_zbir_ukupni_iznos_naknade_i_naknade'],
            'UKSA_ukupni_sati_za_isplatu' => $zar['UKSA_ukupni_sati_za_isplatu'],
            'solid' => $zar['solid'],
            'user_dpsm_id' => $zar['user_dpsm_id'],
            'obracunski_koef_id' => $zar['obracunski_koef_id'],
            'user_mdr_id' => $zar['user_mdr_id'],
            'SID_ukupni_iznos_doprinosa' => $zar['SID'],
            'SIP_ukupni_iznos_poreza' => $zar['SIP'],
            'POROSL_poresko_oslobodjenje' => $zar['POROSL'],
            'NETO_neto_zarada' => $zar['NETO'],
            'maticni_broj' => $mdr['MBRD_maticni_broj'],
            'rbim_sifra_isplatnog_mesta' => $mdr['RBIM_isplatno_mesto_id'],
            'sifra_troskovnog_mesta' => $mdr['troskovno_mesto_id'],
            'RBPS_strucna_sprema' => $mdr['RBPS_priznata_strucna_sprema'],
            'ime' => $mdr['IME_ime'],
            'prezime' => $mdr['PREZIME_prezime'],
            'ZRAC_tekuci_racun' => $mdr['ZRAC_tekuci_racun'],
            'LBG_jmbg' => $mdr['LBG_jmbg'],
            'GGST_godine_staza' => $mdr['GGST_godine_staza'],
            'MMST_meseci_staza' => $mdr['MMST_meseci_staza'],
            'RBRM_redni_broj_radnog_mesta' => $mdr['RBRM_radno_mesto'],
            'SID_ukupni_iznos_poreza_i_doprinosa' => $zar['SIP_D'],
            'PIOR_penzijsko_osiguranje_na_teret_radnika' => $zar['UKUPNO'] * $poresDoprinosiSifarnik->PIO_pio_na_teret_radnika,
            'ZDRR_zdravstveno_osiguranje_na_teret_radnika' => $zar['UKUPNO'] * $poresDoprinosiSifarnik->ZDRO_zdravstveno_osiguranje_na_teret_radnika,
            'ONEZR_osiguranje_od_nezaposlenosti_teret_radnika' => $zar['UKUPNO'] * $poresDoprinosiSifarnik->ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika,
            'PIOP_penzijsko_osiguranje_na_teret_poslodavca' => $zar['UKUPNO'] * $poresDoprinosiSifarnik->DOPRB_pio_na_teret_poslodavca,
            'ZDRP_zdravstveno_osiguranje_na_teret_poslodavca' => $zar['UKUPNO'] * $poresDoprinosiSifarnik->DOPRA_zdravstveno_osiguranje_na_teret_poslodavca,
           // 'ONEZP_osiguranje_od_nezaposlenosti_teret_poslodavca' => $zar['UKUPNO'] * $poresDoprinosiSifarnik->DOPRC, // TODO vidi sa Snezom
            'BROSN_osnovica_za_doprinose' => $zar['UKUPNO']
//            '' =>$zar['SIPPR'] +

            //            'DBDATA' => $zar['UKUPNO'],
//            'DBDATA' => $zar['IZBRBO1'],
//            'DBDATA' => $zar['OSNOV'],
//            'DBDATA' => $zar['IZBRBO2'],
//            'DBDATA' => $zar['KONTROLA'],
//            'DBDATA' => $zar['IZBRBOL'],
//            'DBDATA' => $zar['UKUPNO1'],
//            'DBDATA' => $zar['SIPBOL'],
//            'DBDATA' => $zar['SIDBOL'],
//            'DBDATA' => $zar['PLACENO'],

//            'DBDATA' => $zar['SIPPR'],

//            'DBDATA' => $zar['IZBRUTO'],
        ];
        $this->obradaZaraPoRadnikuInterface->create($data);

    }

    function customSort($a, $b) {
        // Define priority for sorting
        $priority = [
            "P" => 0,
            "R" => 1,
            // Add more keys here if needed
        ];

        // Get the priority of each element
        $priorityA = array_key_exists($a['KESC_prihod_rashod_tip'], $priority) ? $priority[$a['KESC_prihod_rashod_tip']] : PHP_INT_MAX;
        $priorityB = array_key_exists($b['KESC_prihod_rashod_tip'], $priority) ? $priority[$b['KESC_prihod_rashod_tip']] : PHP_INT_MAX;

        // Compare priorities
        if ($priorityA == $priorityB) {
            return 0;
        }
        return ($priorityA < $priorityB) ? -1 : 1;
    }
}
