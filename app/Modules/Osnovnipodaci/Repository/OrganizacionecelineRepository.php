<?php declare(strict_types=1);

namespace App\Modules\Osnovnipodaci\Repository;

use App\Models\Organizacioneceline;
use App\Repository\BaseRepository;

class OrganizacionecelineRepository extends BaseRepository implements OrganizacionecelineRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Organizacioneceline $model
     */
    public function __construct(Organizacioneceline $model)
    {
        parent::__construct($model);
    }
}
