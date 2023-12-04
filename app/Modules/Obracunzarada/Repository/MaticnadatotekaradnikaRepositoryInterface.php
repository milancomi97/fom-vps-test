<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Repository\BaseRepositoryInterface;

interface MaticnadatotekaradnikaRepositoryInterface extends BaseRepositoryInterface
{
    public function createMaticnadatotekaradnika($array);

}

