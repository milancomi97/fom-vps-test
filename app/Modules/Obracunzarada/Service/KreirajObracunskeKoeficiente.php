<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;

class KreirajObracunskeKoeficiente
{
    public function __construct(
        private readonly MesecnatabelapoentazaRepositoryInterface $mesecnatabelapoentazaInterface,
        private readonly RadniciRepository                        $radniciInterface,
        private readonly VrsteplacanjaRepositoryInterface         $vrsteplacanjaInterface,
        private readonly OrganizacionecelineRepositoryInterface   $organizacionecelineInterface
    )
    {
    }

    public function execute($datotekaobracunskihkoeficijenata)
    {

        $radnici = $this->radniciInterface->getAllActive();
        $vrstePlacanja = $this->vrsteplacanjaInterface->getVrstePlacanjaData();

        $vrstePlacanjaUpdated = $this->updateVrstePlacanja($vrstePlacanja, $datotekaobracunskihkoeficijenata);
        $placanja = [];

        foreach ($radnici as $key => $radnik) {
            if (isset($radnik->maticnadatotekaradnika->id)) {

                $data[] = [
                    'organizaciona_celina_id' => $radnik->sifra_mesta_troska_id,
//                    'vrste_placanja' => json_encode($vrstePlacanjaUpdated),
                    'vrste_placanja'=> $this->updateRadnaJedinicaBrigada($vrstePlacanjaUpdated,$radnik),
                    'user_id' => $radnik->id,
                    'datum' => $datotekaobracunskihkoeficijenata->datum->format('Y-m-d'),
                    'maticni_broj' => $radnik->maticni_broj,
                    'ime' => $radnik->ime,
                    'prezime' => $radnik->prezime,
                    'srednje_ime' => $radnik->srednje_ime,
                    'obracunski_koef_id' => $datotekaobracunskihkoeficijenata->id,
                    'status_poentaze' => 1,
                    'user_mdr_id' => $radnik->maticnadatotekaradnika->id
                ];
            }
        }

        return $data;
    }

    private function updateVrstePlacanja($vrstePlacanja, $datotekaobracunskihkoeficijenata)
    {
        $vrstePlacanjaUpdated = [];
        foreach ($vrstePlacanja as $placanje) {

            if ($placanje['key'] == '001' || $placanje['key'] == '019') {
                $placanje['sati'] = (int) $datotekaobracunskihkoeficijenata->mesecni_fond_sati;
                $placanje['iznos'] ='';
                $placanje['procenat'] ='';
                $placanje['RJ_radna_jedinica'] ='';
                $placanje['BRIG_brigada'] ='';
            }

            $vrstePlacanjaUpdated[] = $placanje;
        }

        $vrstePlacanjaUpdated = $this->addAkontacijaInitial($vrstePlacanjaUpdated, $datotekaobracunskihkoeficijenata);
        return $vrstePlacanjaUpdated;

    }

    private function addAkontacijaInitial($vrstePlacanjaUpdated, $datotekaobracunskihkoeficijenata)
    {

        $akontacijaVrstaPlacanja = $this->vrsteplacanjaInterface->where('rbvp_sifra_vrste_placanja', '061')->first();
        $vrstePlacanjaUpdated[] = [
            'key' => '061',
            'sati' => 0,
            'id' => $akontacijaVrstaPlacanja->id,
            'name'=> strtolower(str_replace(' ', '_', $akontacijaVrstaPlacanja->naziv_naziv_vrste_placanja)),
            'iznos'=>(int) $datotekaobracunskihkoeficijenata->vrednost_akontacije,
            'procenat'=>'',
            'RJ_radna_jedinica'=>'',
            'BRIG_brigada'=>''
        ];

        return $vrstePlacanjaUpdated;

    }

    private function updateRadnaJedinicaBrigada($vrstePlacanja,$radnik)
    {
        $vrstePlacanjaUpdated = [];
        foreach ($vrstePlacanja as $placanje) {
            $placanje['RJ_radna_jedinica'] = $radnik->maticnadatotekaradnika->RJ_radna_jedinica;
            $placanje['BRIG_brigada'] = $radnik->maticnadatotekaradnika->BRIG_brigada;
            $vrstePlacanjaUpdated[] = $placanje;
        }

        return json_encode($vrstePlacanjaUpdated);
    }
}
