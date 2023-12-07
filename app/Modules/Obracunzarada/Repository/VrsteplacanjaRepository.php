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

    public function getKoeficientAll(){
        $data = $this->model->take(20)->get();

        $filteredData =$data->map(function ($item) {
            $newValue = strtolower(str_replace(' ', '_',  $item['naziv_naziv_vrste_placanja']));


            return $item['id'] =['key'=> $item['rbvp_sifra_vrste_placanja'],'name' => $newValue,'value'=>''];
        });
       return $filteredData;
    }
}
