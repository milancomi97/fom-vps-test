<?php declare(strict_types=1);

namespace App\Modules\Kadrovskaevidencija\Repository;

use App\Models\Strucnakvalifikacija;
use App\Repository\BaseRepository;

class StrucnakvalifikacijaRepository extends BaseRepository implements StrucnakvalifikacijaRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Strucnakvalifikacija $model
     */
    public function __construct(Strucnakvalifikacija $model)
    {
        parent::__construct($model);
    }


    public function getSelectOptionData(){
        $data= $this->getAll();
        $resultCollection = $data->sortBy('sifra_kvalifikacije')->map(function ($item) {
            $newValue = $item['sifra_kvalifikacije'] . ' ' . $item['naziv_kvalifikacije'];

            return $item['id'] = $newValue;
        });

        return $resultCollection->toArray();
    }
}
