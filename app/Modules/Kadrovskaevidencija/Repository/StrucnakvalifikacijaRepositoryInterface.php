<?php declare(strict_types=1);

namespace App\Modules\Kadrovskaevidencija\Repository;

use App\Repository\BaseRepositoryInterface;

interface StrucnakvalifikacijaRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllKeySifra();
}
