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
        $data= $this->getAll()->sortBy('sifra_oblika_rada');

        $keySifraArray=[];
        foreach ($data as $item){
            $keySifraArray[$item['sifra_oblika_rada']] = $item;
        }
        return $keySifraArray;
    }

}
