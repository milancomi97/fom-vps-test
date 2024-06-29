<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\ArhivaSumeZaraPoRadniku;
use App\Repository\BaseRepository;

class ArhivaSumeZaraPoRadnikuRepository extends BaseRepository implements ArhivaSumeZaraPoRadnikuRepositoryInterface
{
    /**
     *
     * @param ArhivaSumeZaraPoRadniku $model
     */
    public function __construct(ArhivaSumeZaraPoRadniku $model)
    {
        parent::__construct($model);
    }


    public function whereIn($column,$dataList){

        return $this->model->whereIn($column,$dataList);
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

}
