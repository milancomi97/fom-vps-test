<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Repository\BaseRepositoryInterface;

interface ArhivaSumeZaraPoRadnikuRepositoryInterface extends BaseRepositoryInterface
{
    public function whereIn($column,$dataList);
}

