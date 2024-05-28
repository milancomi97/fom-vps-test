<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Isplatnamesta;
use App\Models\Oblikrada;
use App\Repository\BaseRepository;

class OblikradaRepository extends BaseRepository implements OblikradaRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Oblikrada $model
     */
    public function __construct(Oblikrada $model)
    {
        parent::__construct($model);
    }

    public function getSelectOptionData(): array
    {
        $data= $this->getAll();
        $resultCollection = $data->sortBy('sifra_oblika_rada')->map(function ($item) {
            $newValue = $item['sifra_oblika_rada'] . ' ' . $item['naziv_oblika_rada'];

            return $item['sifra_oblika_rada'] = $newValue;
        });
        return $resultCollection->toArray();
    }

}
