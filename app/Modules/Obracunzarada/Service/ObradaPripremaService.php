<?php

namespace App\Modules\Obracunzarada\Service;

class ObradaPripremaService
{


    public function pripremiUnosPoentera($data,$vrstePlacanjaSifarnik,$poresDoprinosiSifarnik)
    {

        $sveVrstePlacanjaPoenteri = [];
        foreach ($data as $radnik) {
            $vrstePlacanjaData = json_decode($radnik->vrste_placanja, true);
            foreach ($vrstePlacanjaData as $key => $vrstaPlacanja) {

                $newPlacanje = [];
                if ($vrstaPlacanja['sati'] !== '' && $vrstaPlacanja['sati']  > 0) {
                    $newPlacanje['sati'] = $vrstaPlacanja['sati'];
                    $newPlacanje['sifra_vrste_placanja'] = $vrstaPlacanja['key'];

                    // RADNIK-MESEC
                    $newPlacanje['maticni_broj'] = $radnik['maticni_broj'];
                    $newPlacanje['user_mdr_id'] = $radnik['user_mdr_id'];
                    $newPlacanje['tip_unosa'] ='poenter_varijabilno';
                    $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];
                    $newPlacanje['user_dpsm_id'] = $radnik['id'];
                    // MDR
                    $newPlacanje['KOEF_osnovna_zarada']= $radnik->maticnadatotekaradnika->KOEF_osnovna_zarada;
                    $newPlacanje['RBRM_radno_mesto']= $radnik->maticnadatotekaradnika->RBRM_radno_mesto;
                    $newPlacanje['P_R_oblik_rada']= $radnik->maticnadatotekaradnika->P_R_oblik_rada;
                    $newPlacanje['RBIM_isplatno_mesto_id']= $radnik->maticnadatotekaradnika->RBIM_isplatno_mesto_id;
                    $newPlacanje['troskovno_mesto_id']= $radnik->maticnadatotekaradnika->troskovno_mesto_id;
                    // DVPL


                    $newPlacanje['naziv_vrste_placanja']= $vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['naziv_naziv_vrste_placanja'];
                    $newPlacanje['SLOV_grupa_vrste_placanja']=$vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['SLOV_grupe_vrsta_placanja'];
                    $newPlacanje['POK2_obracun_minulog_rada']=$vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['POK2_obracun_minulog_rada'];
                    $newPlacanje['KESC_prihod_rashod_tip']=$vrstePlacanjaSifarnik[$vrstaPlacanja['key']]['KESC_prihod_rashod_tip'];

                    // DPOR

                    $newPlacanje['POROSL_poresko_oslobodjenje']=$poresDoprinosiSifarnik->IZN1_iznos_poreskog_oslobodjenja;
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

    public function pripremiFiksnaPlacanja($data)
    {
        return $data;
    }

    public function pripremiAkontacije($data)
    {
        return $data;
    }

    public function pripremiVarijabilnihPlacanja($data)
    {
        return $data;
    }



    public function pripremiKredita($data)
    {
        return $data;
    }
}
