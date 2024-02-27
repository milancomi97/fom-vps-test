<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\DpsmAkontacije;
use App\Repository\BaseRepository;

class DpsmAkontacijeRepository extends BaseRepository implements DpsmAkontacijeRepositoryInterface
{
    /**
     *
     * @param DpsmAkontacije $model
     */
    public function __construct(DpsmAkontacije $model)
    {
        parent::__construct($model);
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

}
