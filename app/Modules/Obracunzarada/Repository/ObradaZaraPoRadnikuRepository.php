<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\ObradaZaraPoRadniku;
use App\Repository\BaseRepository;

class ObradaZaraPoRadnikuRepository extends BaseRepository implements ObradaZaraPoRadnikuRepositoryInterface
{
    /**
     *
     * @param ObradaZaraPoRadniku $model
     */
    public function __construct(ObradaZaraPoRadniku $model)
    {
        parent::__construct($model);
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

}
