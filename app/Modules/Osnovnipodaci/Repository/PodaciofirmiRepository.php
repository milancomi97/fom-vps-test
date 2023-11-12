<?php declare(strict_types=1);

namespace App\Modules\Osnovnipodaci\Repository;

use App\Models\Podaciofirmi;
use App\Repository\BaseRepository;

class PodaciofirmiRepository extends BaseRepository implements PodaciofirmiRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Podaciofirmi $model
     */
    public function __construct(Podaciofirmi $model)
    {
        parent::__construct($model);
    }
}
