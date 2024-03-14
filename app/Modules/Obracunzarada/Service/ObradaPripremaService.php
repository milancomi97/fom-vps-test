<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;

class ObradaPripremaService
{

    public function __construct(
        private readonly VrsteplacanjaRepository $vrsteplacanjaInterface,

    )
    {
    }

    public function pripremiUnosPoentera($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik)
    {

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
                    $sveVrstePlacanjaPoenteri[] = $newPlacanje;
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
        }
        return $sveVrstePlacanjaPoenteri;

    }

    public function pripremiFiksnaPlacanja($data, $vrstePlacanjaSifarnik, $poresDoprinosiSifarnik)
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

                $iznosFormule = $this->kalkulacijaFormule($newPlacanje, $vrstaPlacanjaData);
                $newPlacanje['POROSL_poresko_oslobodjenje'] = $poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
                $this->checkParsingAllFormulas();
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


    public function pripremiKredita($data)
    {
        return $data;
    }

    public function kalkulacijaFormule($newPlacanje, $vrstaPlacanjaData)
    {
        $tableAliases = [
            'KOP->SATI' => 'test',
            'MDR->KOEF' => 'test',
            'MDR->PREB' => 'test',
            'KOE->C_R' => 'test',
            'MDR->KFAK' => 'test',
            'MDR->KOEF1' => 'test',
            'MDR->PRPB' => 'test',
            'MDR->PRIZ' => 'test',
            'MDR->PRCAS' => 'test',
            'ZAR->UKNETO' => 'test',
            'ZAR->IPLAC' => 'test',
            'KOP->PERC' => 'test',
            'ZAR->EFSATI' => 'test',
            'NTO->STOPA1' => 'test',
            'KOE->BR_S' => 'test',
            'ZAR->IZNETO' => 'test',
            'ZAR->TOPLI' => 'test',
            'NTO->NT2' => 'test',
            'POR->IZN1' => 'test',
            'ZAR->SSZNE' => 'test',
            'ZAR->SSNNE' => 'test',
            'ZAR->PREKOV' => 'test',
            'POR->P1' => 'test'
        ];


// Sample formula
        $formula = "{ || (ZAR->IZNETO-ZAR->TOPLI)*KOP->PERC/100*MDR->KFAK }";

        $data = [
            'mdrData' => $newPlacanje,
            'dvplData' => $vrstaPlacanjaData
        ];

        try {
            $formulaValues = $this->replaceVariables($formula, $tableAliases, $data);
            $formulaValues = str_replace(["{", "}", "||", "->"], "", $formulaValues);

            $result = $this->evaluateFormula($formulaValues);


// Evaluate the formula
        } catch (\Exception) {
            throw new \Exception('Logika za formulu nije ispravna' . $formula);
        }
        return $result;
    }

    function replaceVariables($formula, $tableAliases, $data)
    {
        $formulaValues = $formula;
        foreach ($tableAliases as $variable => $fieldDefinition) {

            $exist = preg_match('/' . $variable . '/', $formulaValues);

            $value = $this->getFieldValue($fieldDefinition, $data);
            if ($exist) {
                $formulaValues = str_replace($variable, $value, $formulaValues);
            }
        }
        return $formulaValues;
    }

// Function to evaluate the formula
    function evaluateFormula($formula)
    {
        // Replace '->' with '*' to make it a valid arithmetic expression
//        $formula = str_replace('->', '*', $formula);

        // Evaluate the expression
        $result = null;
        eval("\$result = $formula;");
        return $result;
    }

    public function getFieldValue($fieldDefinition, $data)
    {

        return rand(10, 50);
    }

    public function checkParsingAllFormulas()
    {
        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();

        $checkData = [];
        foreach ($vrstePlacanjaSifarnik as $formulaPatern) {

            $tableAliases = [
                'KOE->BR_S' => "test",
                'KOE->C_R' => "test",
                'KOP->IZNO' => "test",
                'KOP->PERC' => "test",
                'KOP->SATI' => "test",
                'MDR->KFAK' => "test",
                'MDR->KOEF' => "test",
                'MDR->KOEF1' => "test",
                'MDR->PR20' => "test",
                'MDR->PRCAS' => "test",
                'MDR->PREB' => "test",
                'MDR->PRIZ' => "test",
                'MDR->PRPB' => "test",
                'NTO->NT2' => "test",
                'NTO->STOPA1' => "test",
                'POM->DOTA' => "test",
                'POM->IZNO' => "test",
                'POM->RAZL' => "test",
                'POR->IZN1' => "test",
                'POR->P1' => "test",
                'ZAR->EFSATI' => "test",
                'ZAR->IPLAC' => "test",
                'ZAR->IZNETO' => "test",
                'ZAR->PREKOV' => "test",
                'ZAR->SSNNE' => "test",
                'ZAR->SSZNE' => "test",
                'ZAR->TOPLI' => "test",
                'ZAR->UKNETO' => "test",
                'koe->br_s' => "test",
                'por->izn1' => "test",
                'por->p1' => "test",
                'zar->prekov' => "test",
                'zar->ssnne' => "test",
                'zar->sszne' => "test"

            ];

            // mdr->kfak
            // zar->sszne
            // zar->ssnne
            // zar->prekov
            // por->p1
            // por->izn1
            // koe->br_s


            $formulaValues = $formulaPatern['formula_formula_za_obracun'];
            foreach ($tableAliases as $variable => $fieldDefinition) {

                $exist = preg_match('/' . $variable . '/', $formulaValues);

                $value = 'Test';
                if ($exist) {
                    $formulaValues = str_replace($variable, $value, $formulaValues);
                }
            }
            $checkData[] = $formulaPatern['rbvp_sifra_vrste_placanja'] . ' : ' . $formulaValues;


        }

        $test = 'test';
    }
}
