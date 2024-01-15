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
                    'vrste_placanja' => json_encode($vrstePlacanjaUpdated),
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
        foreach ($vrstePlacanja as &$placanje) {
            $test = "testt";
            if ($placanje['key'] == '001' || $placanje['key'] == '019') {
                $placanje['value'] = $datotekaobracunskihkoeficijenata->mesecni_fond_sati;

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
            'value' => $datotekaobracunskihkoeficijenata->vrednost_akontacije,
            'id' => $akontacijaVrstaPlacanja->id,
            'name'=> strtolower(str_replace(' ', '_', $akontacijaVrstaPlacanja->naziv_naziv_vrste_placanja))
        ];

        return $vrstePlacanjaUpdated;

    }
}
