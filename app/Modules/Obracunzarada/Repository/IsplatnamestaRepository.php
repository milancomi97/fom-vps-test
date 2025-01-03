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
        $data= $this->getAll()->sortBy('rbim_sifra_isplatnog_mesta');


        $keySifraArray=[];
        foreach ($data as $item){
            $keySifraArray[$item->rbim_sifra_isplatnog_mesta] = $item->toArray();
        }
        return $keySifraArray;

    }

}
