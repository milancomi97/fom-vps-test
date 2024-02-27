<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Repository\BaseRepositoryInterface;

interface DpsmFiksnaPlacanjaRepositoryInterface extends BaseRepositoryInterface
{
    public function createMany($array);

}
