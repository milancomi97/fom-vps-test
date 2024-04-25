<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\ObradaDkopSveVrstePlacanja;
use App\Repository\BaseRepository;

class ObradaDkopSveVrstePlacanjaRepository extends BaseRepository implements ObradaDkopSveVrstePlacanjaRepositoryInterface
{
    /**
     *
     * @param ObradaDkopSveVrstePlacanja $model
     */
    public function __construct(ObradaDkopSveVrstePlacanja $model)
    {
        parent::__construct($model);
    }

    public function createMany($array)
    {
//        foreach ($array as $data){
//
//            try {
//                $this->model->create($data);
//
//            } catch (\Exception $exception) {
//                $test='test';
//}
//        }
        return $this->model->insert($array);
    }

}
