<?php declare(strict_types=1);

namespace App\Modules\Osnovnipodaci\Repository;

use App\Models\Drzave;
use App\Repository\BaseRepository;

class DrzaveRepository extends BaseRepository implements DrzaveRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Drzave $model
     */
    public function __construct(Drzave $model)
    {
        parent::__construct($model);
    }
}
