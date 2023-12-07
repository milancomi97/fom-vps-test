<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Mesecnatabelapoentaza;
use App\Repository\BaseRepository;

class MesecnatabelapoentazaRepository extends BaseRepository implements MesecnatabelapoentazaRepositoryInterface
{
    /**
     *
     * @param Mesecnatabelapoentaza $model
     */
    public function __construct(Mesecnatabelapoentaza $model)
    {
        parent::__construct($model);
    }

    public function createMany($array){
        return $this->model->insert($array);
    }
}
