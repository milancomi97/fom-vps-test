<?php declare(strict_types=1);

namespace App\Modules\Osnovnipodaci\Repository;

use App\Models\Opstine;
use App\Repository\BaseRepository;

class OpstineRepository extends BaseRepository implements OpstineRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Opstine $model
     */
    public function __construct(Opstine $model)
    {
        parent::__construct($model);
    }

    public function getSelectOptionData(){
        $data= $this->getAll();
        $resultCollection = $data->map(function ($item) {
            $newValue = $item['sifra_drzave'] . ' ' . $item['naziv_opstine'];

            return $item['id'] = $newValue;
        });
        return $resultCollection->toArray();
    }
}