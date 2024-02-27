<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\DpsmFiksnaPlacanja;
use App\Repository\BaseRepository;

class DpsmFiksnaPlacanjaRepository extends BaseRepository implements DpsmFiksnaPlacanjaRepositoryInterface
{
    /**
     *
     * @param DpsmFiksnaPlacanja $model
     */
    public function __construct(DpsmFiksnaPlacanja $model)
    {
        parent::__construct($model);
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

}
