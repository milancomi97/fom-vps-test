<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Repository\BaseRepositoryInterface;

interface DatotekaobracunskihkoeficijenataRepositoryInterface extends BaseRepositoryInterface
{
    public function createMesecnatabelapoentaza($array);

}
