<?php declare(strict_types=1);

namespace App\Modules\Kadrovskaevidencija\Repository;

use App\Models\Zanimanjasifarnik;
use App\Repository\BaseRepository;

class ZanimanjasifarnikRepository extends BaseRepository implements ZanimanjasifarnikRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Zanimanjasifarnik $model
     */
    public function __construct(Zanimanjasifarnik $model)
    {
        parent::__construct($model);
    }
}
