<?php declare(strict_types=1);

namespace App\Modules\Osnovnipodaci\Repository;

use App\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface RadniciRepositoryInterface extends BaseRepositoryInterface
{
    public function createUser(array $attributes): Model ;
    public function getAllActive();
}
