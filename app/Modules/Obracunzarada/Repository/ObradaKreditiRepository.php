<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\ObradaKrediti;
use App\Repository\BaseRepository;

class ObradaKreditiRepository extends BaseRepository implements ObradaKreditiRepositoryInterface
{
    /**
     *
     * @param ObradaKrediti $model
     */
    public function __construct(ObradaKrediti $model)
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
