<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Isplatnamesta;
use App\Repository\BaseRepository;

class IsplatnamestaRepository extends BaseRepository implements IsplatnamestaRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Isplatnamesta $model
     */
    public function __construct(Isplatnamesta $model)
    {
        parent::__construct($model);
    }

    public function getSelectOptionData(): array
    {
        $data= $this->getAll();
        $resultCollection = $data->sortBy('rbim_sifra_isplatnog_mesta')->map(function ($item) {
            $newValue = $item['rbim_sifra_isplatnog_mesta'] . ' ' . $item['naim_naziv_isplatnog_mesta'];

            return $item['rbim_sifra_isplatnog_mesta'] =['key'=> $item['rbim_sifra_isplatnog_mesta'],'value'=>$newValue];
        });

        return $resultCollection->toArray();
    }
}
