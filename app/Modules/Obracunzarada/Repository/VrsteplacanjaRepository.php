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

    public function getVrstePlacanjaData(){
        $data = $this->model->take(19)->get()->sortBy('redosled_poentaza_zaglavlje');
        // Prvo sortiraj pa onda kada dodjes do 19, prestani
        // Treba da bude 19

        $filteredData =$data->map(function ($item) {
            $newValue = strtolower(str_replace(' ', '_',  $item['naziv_naziv_vrste_placanja']));


            return $item['id'] =[
                'key'=> $item['rbvp_sifra_vrste_placanja'],
                'name' => $newValue,'value'=>'',
                'id'=>$item['id']
            ];
        });
       return $filteredData;
    }


    public function getVrstePlacanjaOpis(){
        $data = $this->model->take(31)->get()->sortBy('redosled_poentaza_opis');

        // TREBA DA BUDE 31;
        $filteredData =$data->map(function ($item) {
            return $item['id'] =[
                'key'=> $item['rbvp_sifra_vrste_placanja'],
                'name' => $item['naziv_naziv_vrste_placanja']
            ];
        });


        return $this->createList($filteredData);
    }

    public function createList($items){
    $itemCount = count($items);

    $html = '<div class="row">';

    for ($i = 0; $i < $itemCount; $i++) {
        $html .= '<div class="col-2">';
            $html .= '<p class="vrste_placanja_description" >' . $items[$i]['key'] .' - '. $items[$i]['name'] . '</p>';
        $html .= '</div>';
        if($i ==4 || $i==9 || $i==14 || $i==19 || $i==24 || $i==29){
            $html .= '<div class="col-2"></div>';
        }
    }
    $html .= '</div>';

    return $html;
}
}
