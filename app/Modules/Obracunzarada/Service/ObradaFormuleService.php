<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;

class ObradaFormuleService
{

    public function __construct(
        private readonly VrsteplacanjaRepository $vrsteplacanjaInterface,

    )
    {
    }
//    public function obradiFormule($sveVrstePlacanjaData){
//        $sveVrstePlacanjaDataFiltered =[];
//
//        foreach ($sveVrstePlacanjaData as $vrstePlacanjaDatum){
////            $iznos = $this->kalkulacijaFormule($vrstePlacanjaDatum,$vrstePlacanjaDatum);
//            // TODO PROVERI REDOSLED
//        }
//        return $sveVrstePlacanjaDataFiltered;
//}
    public function kalkulacijaFormule($vrstaPlacanjaSlog,$vrstaPlacanjaSifData,$radnik,$poresDoprinosiSifarnik,$monthData,$minimalneBrutoOsnoviceSifarnik)
    {
// Sample formula
        $formula = $vrstaPlacanjaSifData[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['formula_formula_za_obracun'];

        $DATA='TEST';
        $data = [
            'KOE'=>$monthData,
            'KOP'=>$vrstaPlacanjaSlog,
            'MDR'=>$vrstaPlacanjaSlog->maticnadatotekaradnika->toArray(),
            'NTO'=>$minimalneBrutoOsnoviceSifarnik, // MINIMALNE BRUTO OSNOVICE // IZVUCI PRE
            'POM'=>$vrstaPlacanjaSlog,
            'POR'=>$poresDoprinosiSifarnik,
            'ZAR'=> $radnik['ZAR'] ?? [],
        ];

            $formulaValues = $this->replaceVariables($formula, $data);
            $formulaValues = str_replace(["{", "}", "||", "->"], "", $formulaValues);

            $result = $this->evaluateFormula($formulaValues);



        return $result;
    }

    function replaceVariables($formula,$data)
    {
        $tableAliases = [
            'KOE->BR_S' => "mesecni_fond_sati", // da se povuce vidi sa snezom
            'KOE->C_R' => "cena_rada_tekuci",
            'KOP->IZNO' => "iznos", // Imam trenutno
            'KOP->PERC' => "test",
            'KOP->SATI' => "sati",
            'MDR->KFAK' => "KFAK_korektivni_faktor", // Imam relaciju
            'MDR->KOEF' => "KOEF_osnovna_zarada",
            'MDR->KOEF1' => "KOEF1_prethodna_osnovna_zarada",
            'MDR->PR20' => "test",
            'MDR->PRCAS' => "test",
            'MDR->PREB' => "PREB_prebacaj",
            'MDR->PRIZ' => "test",
            'MDR->PRPB' => "test",
            'NTO->NT2' => "test", // MINIMALNE BRUTO OSNOVICE
            'NTO->STOPA1' => "test",
            'POM->DOTA' => "test", // Pomocna
            'POM->IZNO' => "test",
            'POM->RAZL' => "test",
            'POR->IZN1' => "test",
            'POR->P1' => "test",
            'ZAR->EFSATI' => "test", //
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


        $formulaValues = $formula;
        foreach ($tableAliases as $variable => $fieldDefinition) {

            $exist = preg_match('/' . $variable . '/', $formulaValues);

            if ($exist) {
                $value = $this->getFieldValue($variable,$fieldDefinition, $data);
                $formulaValues = str_replace($variable, $value, $formulaValues);
            }
        }
        return $formulaValues;
    }

    function evaluateFormula($formula)
    {
        // Replace '->' with '*' to make it a valid arithmetic expression
//        $formula = str_replace('->', '*', $formula);

        // Evaluate the expression
        $result = null;
        eval("\$result = $formula;");
        return $result;
    }



    public function checkParsingAllFormulas()
    {
        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();

        $checkData = [];
        foreach ($vrstePlacanjaSifarnik as $formulaPatern) {

            $tableAliases = [
                'KOE->BR_S' => "test", // Cena rada
                'KOE->C_R' => "test", //  sati u mesecu
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

                $value = rand(10,100);
                if ($exist) {
                    $formulaValues = str_replace($variable, $value, $formulaValues);
                }
            }
            $checkData[] = $formulaPatern['rbvp_sifra_vrste_placanja'] . ' : ' . $formulaValues;


        }

    }

    public function getFieldValue($variable,$fieldDefinition,$data)
    {
        $table=strstr($variable, '->', true);
       return (float) $data[$table][$fieldDefinition];
        //
//        if('KOP->SATI'){
//            $data
//        }

    }


}
