<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Kreditori;
use App\Repository\BaseRepository;

class KreditoriRepository extends BaseRepository implements KreditoriRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Kreditori $model
     */
    public function __construct(Kreditori $model)
    {
        parent::__construct($model);
    }
}
