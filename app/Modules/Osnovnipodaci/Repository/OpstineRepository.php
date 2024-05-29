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

    /**
     * @return array
     */
    public function getSelectOptionData(): array
    {
        $data= $this->getAll();
        $resultCollection = $data->sortBy('sifra_opstine')->map(function ($item) {
            $newValue = $item['sifra_opstine'] . ' ' . $item['naziv_opstine'];

            return $item['id'] =['key'=> $item['sifra_opstine'],'value' => $newValue];
        });

        return $resultCollection->toArray();
    }
}
// sifra_opstine
