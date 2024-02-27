<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\DpsmKrediti;
use App\Repository\BaseRepository;

class DpsmKreditiRepository extends BaseRepository implements DpsmKreditiRepositoryInterface
{
    /**
     *
     * @param DpsmKrediti $model
     */
    public function __construct(DpsmKrediti $model)
    {
        parent::__construct($model);
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

}
