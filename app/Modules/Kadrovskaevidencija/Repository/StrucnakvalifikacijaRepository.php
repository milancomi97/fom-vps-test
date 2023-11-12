<?php declare(strict_types=1);

namespace App\Modules\Kadrovskaevidencija\Repository;

use App\Models\Strucnakvalifikacija;
use App\Repository\BaseRepository;

class StrucnakvalifikacijaRepository extends BaseRepository implements StrucnakvalifikacijaRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Strucnakvalifikacija $model
     */
    public function __construct(Strucnakvalifikacija $model)
    {
        parent::__construct($model);
    }
}
