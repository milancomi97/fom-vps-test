<?php declare(strict_types=1);

namespace App\Modules\Kadrovskaevidencija\Repository;

use App\Models\Radnamesta;
use App\Repository\BaseRepository;

class RadnamestaRepository extends BaseRepository implements RadnamestaRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Radnamesta $model
     */
    public function __construct(Radnamesta $model)
    {
        parent::__construct($model);
    }

    public function getSelectOptionData(): array
    {
        $data= $this->getAll();
        $resultCollection = $data->sortBy('rbrm_sifra_radnog_mesta')->map(function ($item) {
            $newValue = $item['rbrm_sifra_radnog_mesta'] . ' ' . $item['narm_naziv_radnog_mesta'];

            return $item['id'] = $newValue;
        });

        return $resultCollection->toArray();
    }
}
