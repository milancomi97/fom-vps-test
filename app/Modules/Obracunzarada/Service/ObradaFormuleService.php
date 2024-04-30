<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;

use Exception;
class ObradaFormuleService
{

    protected $cacheCounter;
    public function __construct(
        private readonly VrsteplacanjaRepository $vrsteplacanjaInterface,

    )
    {
    }

    public function kalkulacijaFormule($vrstaPlacanjaSlog, $vrstaPlacanjaSifData, $radnik, $poresDoprinosiSifarnik, $monthData, $minimalneBrutoOsnoviceSifarnik, $praviloSkip)
    {

        $skipFormule = ['050','051','052','053','054','055'];



        try {
            $formula = $vrstaPlacanjaSifData[$vrstaPlacanjaSlog['sifra_vrste_placanja']]['formula_formula_za_obracun'];

        } catch (\Exception $exception) {
            $test = "test";
        }

        $DATA = $vrstaPlacanjaSlog['sifra_vrste_placanja'];
        $DATANAME = $vrstaPlacanjaSlog['naziv_vrste_placanja'];

        $radnik['ZAR'] = $radnik['ZAR'] ?? [];
        $data = [
            'KOE' => $monthData,
            'KOP' => $vrstaPlacanjaSlog,
            'MDR' => $vrstaPlacanjaSlog->maticnadatotekaradnika->toArray(),
            'NTO' => $minimalneBrutoOsnoviceSifarnik, // MINIMALNE BRUTO OSNOVICE // IZVUCI PRE
            'POM' => $vrstaPlacanjaSlog,
            'POR' => $poresDoprinosiSifarnik,
            'ZAR' => $praviloSkip == 'K' ? $radnik['ZAR2'] : $radnik['ZAR'],
        ];

        $formulaValues = $this->replaceVariables($formula, $data);
        $formulaValues = str_replace(["{", "}", "||", "->"], "", $formulaValues);

        if(in_array($vrstaPlacanjaSlog['sifra_vrste_placanja'],$skipFormule)){
            return 0;
        }

        try {
//            001 - tekuci rad
//010- placeno odsustvo
//009- godisnji odmor
//012 - bolovanje 65
//013 - bolovanje 100
//458 - Renta
//087 - Porodiljsko
//065 - sudsko resenje
//098 - Nezavisni sindikat
//002-  prekovremeni rad
//019 - topli obrok
//090 - sindikat metalaca
//017 - opravdani izostanci
//007 - visinski 3-10 m
//070 - razlika plate
//008 - visinski 11-20m
//004 - nocni rad 26%
//            504 - alimentacija fiksna
//503 - alimentacija %
//018 - neopravdani izostan


//            $DATA !=='001' && $DATA!=='010' && $DATA!=='009' && $DATA!=='012' && $DATA!=='013' && $DATA!=='458'  && $DATA!=='087' && $DATA!=='065'  && $DATA!=='098' && $DATA!=='002'  && $DATA!=='019'   && $DATA!=='090'   && $DATA!=='017'  && $DATA!=='007'  && $DATA!=='070'  && $DATA!=='008' && $DATA!=='004'  && $DATA!=='504'  && $DATA!=='503'   && $DATA!=='018'
//            $this->cacheCounter++;
            $result = $this->evaluateFormula($this->replaceZero($formulaValues));
            $test = '';
            $test=2;
        } catch (\Throwable $exception) {
//            report("Proveri Formulu:".$vrstaPlacanjaSlog['sifra_vrste_placanja']);
            report($exception);

            $newMessage = "Proverite formulu : " . $vrstaPlacanjaSlog['sifra_vrste_placanja'];
            $updatedException = new \Exception($newMessage, $exception->getCode(), $exception);
            throw $updatedException;
        }


        return $result;
    }

    function replaceVariables($formula, $data)
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
            'NTO->NT2' => "NT2_minimalna_bruto_zarada", // MINIMALNE BRUTO OSNOVICE
            'NTO->STOPA1' => "STOPA1_koeficijent_za_obracun_neto_na_bruto",
            'POM->DOTA' => "test", // Pomocna
            'POM->IZNO' => "test",
            'POM->RAZL' => "test",
            'POR->IZN1' => "IZN1_iznos_poreskog_oslobodjenja",
            'POR->P1' => "P1_porez_na_licna_primanja",
            'ZAR->EFSATI' => "EFSATI",
            'ZAR->IPLAC' => "IPLAC",
            'ZAR->IZNETO' => "IZNETO",
            'ZAR->PREKOV' => "PREK",
            'ZAR->SSNNE' => "SSNNE",
            'ZAR->SSZNE' => "SSZNE",
            'ZAR->TOPLI' => "TOPSATI",
            'ZAR->UKNETO' => "UKNETO",
            'koe->br_s' => "mesecni_fond_sati",
            'por->izn1' => "IZN1_iznos_poreskog_oslobodjenja",
            'por->p1' => "P1_porez_na_licna_primanja",
            'zar->prekov' => "PREK",
            'zar->ssnne' => "SSNNE",
            'zar->sszne' => "SSZNE",
            'mdr->kfak' => 'KFAK_korektivni_faktor'
        ];


        $formulaValues = $formula;
        foreach ($tableAliases as $variable => $fieldDefinition) {

            $exist = preg_match('/' . $variable . '/', $formulaValues);

            if ($exist) {
                $value = $this->getFieldValue($variable, $fieldDefinition, $data);
                $formulaValues = str_replace($variable, $value, $formulaValues);
            }
        }
        return $formulaValues;
    }

    function evaluateFormula($formula)
    {
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

                $value = rand(10, 100);
                if ($exist) {
                    $formulaValues = str_replace($variable, $value, $formulaValues);
                }
            }
            $checkData[] = $formulaPatern['rbvp_sifra_vrste_placanja'] . ' : ' . $formulaValues;


        }

    }

    public function getFieldValue($variable, $fieldDefinition, $data)
    {
        if ($fieldDefinition == 'cena_rada_tekuci') {
            return 1; // SAMO PRVI PUT
        }

//        if(){
//
//        }


        $table = strstr($variable, '->', true);

//        if (strtoupper($table) == 'ZAR' && (empty($data['ZAR']) || $variable == 'ZAR->IPLAC' || $variable == 'ZAR->UKNETO')) {
        if (strtoupper($table) == 'ZAR' && (empty($data['ZAR']))) {

            // ZAR->IPLAC prva iteracija
            return 0;
        }

        if ($variable == 'MDR->PRPB') {
            return 1;
        }

        if ($fieldDefinition == 'test') {
            $test = 'test';
        }
        return (float)$data[strtoupper($table)][$fieldDefinition];
        //
//        if('KOP->SATI'){
//            $data
//        }

    }

    function replaceZero($inputString)
    {
        // Check if the input string contains '/0'
        if (strpos($inputString, '/0') !== false) {
            // If it does, replace '/0' with '/1'
            $inputString = str_replace('/0', '/1', $inputString);
        }

        // Check if the input string contains '*0'
        if (strpos($inputString, '*0') !== false) {
            // If it does, replace '*0' with '*1'
            $inputString = str_replace('*0', '*1', $inputString);
        }

        return $inputString;
    }

}
