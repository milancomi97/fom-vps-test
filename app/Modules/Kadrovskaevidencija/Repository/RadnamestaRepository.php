<?php declare(strict_types=1);

namespace App\Modules\Kadrovskaevidencija\Repository;

use App\Models\Radnamesta;
use App\Repository\BaseRepository;

class RadnamestaRepository extends BaseRepository implements RadnamestaRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Radnamesta $model
     */
    public function __construct(Radnamesta $model)
    {
        parent::__construct($model);
    }
}
