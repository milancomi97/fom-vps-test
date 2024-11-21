<?php declare(strict_types=1);

namespace App\Modules\Kadrovskaevidencija\Repository;

use App\Models\Vrstaradasifarnik;
use App\Repository\BaseRepository;

class VrstaradasifarnikRepository extends BaseRepository implements VrstaradasifarnikRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Vrstaradasifarnik $model
     */
    public function __construct(Vrstaradasifarnik $model)
    {
        parent::__construct($model);
    }

    public function getSelectOptionData()
    {
        $data= $this->getAll()->sortBy('sifra_statusa');
        $newArray=[];
        foreach ($data as $item){
            $newArray[$item['sifra_statusa']]=$item['naziv_statusa'];
        }

        return $newArray;
    }
}
