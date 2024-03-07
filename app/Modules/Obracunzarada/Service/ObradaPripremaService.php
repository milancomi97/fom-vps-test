<?php

namespace App\Modules\Obracunzarada\Service;

class ObradaPripremaService
{


    public function pripremiUnosPoentera($data)
    {

        $sveVrstePlacanjaPoenteri = [];
        foreach ($data as $radnik) {
            $vrstePlacanjaData = json_decode($radnik->vrste_placanja, true);
            foreach ($vrstePlacanjaData as $key => $vrstaPlacanja) {

                $newPlacanje = [];
                if ($vrstaPlacanja['sati'] !== '' && $vrstaPlacanja['sati']  > 0) {
                    $newPlacanje['sati'] = $vrstaPlacanja['sati'];
                    $newPlacanje['sifra'] = $vrstaPlacanja['key'];
                    $newPlacanje['maticni_broj'] = $radnik['maticni_broj'];
                    $newPlacanje['obracunski_koef_id'] = $radnik['obracunski_koef_id'];
                    $newPlacanje['user_id'] = $radnik['user_id'];
                    $newPlacanje['tip_unosa'] ='poenter_varijabilno';
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
