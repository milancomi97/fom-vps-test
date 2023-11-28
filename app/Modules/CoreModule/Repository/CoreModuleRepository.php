<?php declare(strict_types=1);

namespace App\Modules\CoreModule\Repository;

use App\Models\CoreModule;
use App\Repository\BaseRepository;

class CoreModuleRepository extends BaseRepository implements CoreModuleRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param CoreModule $model
     */
    public function __construct(CoreModule $model)
    {
        parent::__construct($model);
    }
}
