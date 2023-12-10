<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Repository\BaseRepositoryInterface;

interface MesecnatabelapoentazaRepositoryInterface extends BaseRepositoryInterface
{
    public function createMany($array);
    public function groupForTable($column, $value);
    public function getTableHeaders($array);

}

