<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\ArhivaMaticnadatotekaradnika;
use App\Repository\BaseRepository;

class ArhivaMaticnadatotekaradnikaRepository extends BaseRepository implements ArhivaMaticnadatotekaradnikaRepositoryInterface
{
    /**
     *
     * @param ArhivaMaticnadatotekaradnika $model
     */
    public function __construct(ArhivaMaticnadatotekaradnika $model)
    {
        parent::__construct($model);
    }

    public function whereBetween($dateStart,$dateEnd){
       return $this->model->whereBetween('M_G_date', [$dateStart, $dateEnd]);
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

}
