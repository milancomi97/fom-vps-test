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
    public function obradiFormule($sveVrstePlacanjaData){
        $sveVrstePlacanjaDataFiltered =[];

        foreach ($sveVrstePlacanjaData as $vrstePlacanjaDatum){
//            $iznos = $this->kalkulacijaFormule($vrstePlacanjaDatum,$vrstePlacanjaDatum);
            // TODO PROVERI REDOSLED
        }
        return $sveVrstePlacanjaDataFiltered;
}
    public function kalkulacijaFormule($newPlacanje, $vrstaPlacanjaData)
    {
// Sample formula
        $formula = "{ || (ZAR->IZNETO-ZAR->TOPLI)*KOP->PERC/100*MDR->KFAK }";

        $data = [
            'mdrData' => $newPlacanje,
            'dvplData' => $vrstaPlacanjaData
        ];

            $formulaValues = $this->replaceVariables($formula, $data);
            $formulaValues = str_replace(["{", "}", "||", "->"], "", $formulaValues);

            $result = $this->evaluateFormula($formulaValues);



        return $result;
    }

    function replaceVariables($formula,$data)
    {
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


        $formulaValues = $formula;
        foreach ($tableAliases as $variable => $fieldDefinition) {

            $exist = preg_match('/' . $variable . '/', $formulaValues);

            if ($exist) {
                $value = $this->getFieldValue($fieldDefinition, $data);
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

                $value = rand(10,100);
                if ($exist) {
                    $formulaValues = str_replace($variable, $value, $formulaValues);
                }
            }
            $checkData[] = $formulaPatern['rbvp_sifra_vrste_placanja'] . ' : ' . $formulaValues;


        }

    }

    public function getFieldValue($fieldDefinition, $data)
    {
        //
//        if('KOP->SATI'){
//            $data
//        }

        return rand(10, 50);
    }


}
