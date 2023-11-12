<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Porezdoprinosi;
use App\Repository\BaseRepository;

class PorezdoprinosiRepository extends BaseRepository implements PorezdoprinosiRepositoryInterface
{
    /**
     *
     * @param Porezdoprinosi $model
     */
    public function __construct(Porezdoprinosi $model)
    {
        parent::__construct($model);
    }
}
