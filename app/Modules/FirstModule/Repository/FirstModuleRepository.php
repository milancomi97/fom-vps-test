<?php declare(strict_types=1);

namespace App\Modules\FirstModule\Repository;

use App\Models\FirstModule;
use App\Repository\BaseRepository;

class FirstModuleRepository extends BaseRepository implements FirstModuleRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param FirstModule $model
     */
    public function __construct(FirstModule $model)
    {
        parent::__construct($model);
    }
}
