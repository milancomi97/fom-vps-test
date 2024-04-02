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
    public function kalkulacijaFormule($vrstaPlacanjaSlog,$vrstaPlacanjaSifData,$radnik,$poresDoprinosiSifarnik,$monthData,$minimalneBrutoOsnoviceSifarnik,$pravilo)
    {
// Sample formula
        try {
            $formula = $vrstaPlacanjaSifData[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['formula_formula_za_obracun'];

        } catch (\Exception $exception){
            $test="test";
        }

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
            'KOE->BR_S' => "mesecni_fond_sati",
            'KOE->C_R' => "cena_rada_tekuci",
            'KOP->IZNO' => "iznos", // Imam trenutno
            'KOP->PERC' => "procenat",
            'KOP->SATI' => "sati",
            'MDR->KFAK' => "KFAK_korektivni_faktor",
            'MDR->KOEF' => "KOEF_osnovna_zarada",
            'MDR->KOEF1' => "KOEF1_prethodna_osnovna_zarada",
            'MDR->PR20' => "test",
            'MDR->PRCAS' => "PRCAS_ukupni_sati_za_ukupan_bruto_iznost", // prcas nadji
            'MDR->PREB' => "PREB_prebacaj",
            'MDR->PRIZ' => "PRIZ_ukupan_bruto_iznos",
            'MDR->PRPB' => "test",
            'NTO->NT2' => "test", // MINIMALNE BRUTO OSNOVICE
            'NTO->STOPA1' => "test",
            'POM->DOTA' => "test", // Pomocna
            'POM->IZNO' => "test",
            'POM->RAZL' => "test",
            'POR->IZN1' => "test",
            'POR->P1' => "test",
            'ZAR->EFSATI' => "EFSATI", //
            'ZAR->IPLAC' => "test", // vrati nulu, posle
            'ZAR->IZNETO' => "test", // Sve sto je G
            'ZAR->PREKOV' => "PREK",
            'ZAR->SSNNE' => "SSNNE",
            'ZAR->SSZNE' => "SSZNE",
            'ZAR->TOPLI' => "TOPSATI",
            'ZAR->UKNETO' => "test",  // Sve sto je G
//            'koe->br_s' => "test",
//            'por->izn1' => "test",
//            'por->p1' => "test",
            'zar->prekov' => "PREK",
            'zar->ssnne' => "SSNNE",
            'zar->sszne' => "SSZNE",
            'mdr->kfak'=>'KFAK_korektivni_faktor'
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
        if($fieldDefinition =='cena_rada_tekuci'){
            return 1; // SAMO PRVI PUT
        }

//        if(){
//
//        }



        $table=strstr($variable, '->', true);

        if(strtoupper($table) =='ZAR' && (empty($data['ZAR']) || $variable=='ZAR->IPLAC'|| $variable=='ZAR->UKNETO')){
            // ZAR->IPLAC prva iteracija
         return 0;
        }

        if($variable=='MDR->PRPB'){
            return 1;
        }

        if($fieldDefinition=='test'){
          $test='test';
        }
       return (float) $data[strtoupper($table)][$fieldDefinition];
        //
//        if('KOP->SATI'){
//            $data
//        }

    }


}
