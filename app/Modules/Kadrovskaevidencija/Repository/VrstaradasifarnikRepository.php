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

    public function getSelectOptionData(): array
    {
        $data= $this->getAll();
        $resultCollection = $data->sortBy('sifra_statusa')->map(function ($item) {
            $newValue = $item['sifra_statusa'] . ' ' . $item['naziv_statusa'];

            return $item['id'] = $newValue;
        });
        return $resultCollection->toArray();
    }
}
