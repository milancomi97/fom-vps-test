<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Vrsteplacanja;
use App\Repository\BaseRepository;

class VrsteplacanjaRepository extends BaseRepository implements VrsteplacanjaRepositoryInterface
{
    /**
     *
     * @param Vrsteplacanja $model
     */
    public function __construct(Vrsteplacanja $model)
    {
        parent::__construct($model);
    }

    public function getVrstePlacanjaOpis(){
        $data = $this->model->all()->sortBy('redosled_poentaza_opis');

        // TREBA DA BUDE 31;
        $filteredData =$data->map(function ($item) {
            return $item['id'] =[
                'key'=> $item['rbvp_sifra_vrste_placanja'],
                'name' => $item['naziv_naziv_vrste_placanja']
            ];
        });


        return $this->createList($filteredData->take(31));
    }

    public function getVrstePlacanjaOpisPdf(){
        $data = $this->model->all()->sortBy('redosled_poentaza_opis');

        // TREBA DA BUDE 31;
        $filteredData =$data->map(function ($item) {
            return $item['id'] =[
                'key'=> $item['rbvp_sifra_vrste_placanja'],
                'name' => $item['naziv_naziv_vrste_placanja']
            ];
        });

        $html = '<table class="footer-potpis-table mt-5"><tr class="no-border">';
            $counter = 0;

            foreach ($filteredData->take(31) as $item) {
                if ($counter > 0 && $counter % 5 == 0) {
                    $html .= '</tr><tr>';
                }
                $html .= '<td class="footer-opis-code no-border">' . $item['key'] . ' - ' . $item['name'] . '</td>';
                $counter++;
            }

            $html .= '</tr></table>';
            return $html;
    }


    public function createList($items) {
        $html = '<div class="row">';
        $count = 0;

        foreach ($items as $item) {
            $html .= '<div class="col-2">';
            $html .= '<p class="vrste_placanja_description">' . $item['key'] . ' - ' . $item['name'] . '</p>';
            $html .= '</div>';

            $count++;
            if ($count % 5 === 0) {
                $html .= '<div class="col-2"></div>';
            }
        }

        $html .= '</div>';

        return $html;
    }

    public function getAllKeySifra(){
        $data = $this->model->all()->toArray();

        $keySifraArray=[];
        foreach ($data as $vrstaPlacanja){
            $keySifraArray[$vrstaPlacanja['rbvp_sifra_vrste_placanja']] = $vrstaPlacanja;
        }
        return $keySifraArray;
    }
}
