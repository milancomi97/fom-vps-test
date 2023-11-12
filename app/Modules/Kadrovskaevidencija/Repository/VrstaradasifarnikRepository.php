<?php declare(strict_types=1);

namespace App\Modules\Kadrovskaevidencija\Repository;

use App\Models\Vrstaradasifarnik;
use App\Repository\BaseRepository;

class VrstaradasifarnikRepository extends BaseRepository implements VrstaradasifarnikRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Vrstaradasifarnik $model
     */
    public function __construct(Vrstaradasifarnik $model)
    {
        parent::__construct($model);
    }
}
