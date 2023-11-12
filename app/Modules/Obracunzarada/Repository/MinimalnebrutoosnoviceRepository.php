<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Minimalnebrutoosnovice;
use App\Repository\BaseRepository;

class MinimalnebrutoosnoviceRepository extends BaseRepository implements MinimalnebrutoosnoviceRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Minimalnebrutoosnovice $model
     */
    public function __construct(Minimalnebrutoosnovice $model)
    {
        parent::__construct($model);
    }
}
