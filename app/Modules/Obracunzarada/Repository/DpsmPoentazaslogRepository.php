<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\DpsmPoentazaslog;
use App\Repository\BaseRepository;

class DpsmPoentazaslogRepository extends BaseRepository implements DpsmPoentazaslogRepositoryInterface
{
    /**
     *
     * @param DpsmPoentazaslog $model
     */
    public function __construct(DpsmPoentazaslog $model)
    {
        parent::__construct($model);
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

}
