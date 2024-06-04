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
        $data= $this->getAll()->sortBy('sifra_kvalifikacije');

        $keySifraArray=[];
        foreach ($data as $item){
            $keySifraArray[$item['sifra_kvalifikacije']] = $item;
        }
        return $keySifraArray;
    }

    public function getAllKeySifra(){
        $data = $this->model->all()->toArray();

        $keySifraArray=[];
        foreach ($data as $vrstaPlacanja){
            $keySifraArray[$vrstaPlacanja['sifra_kvalifikacije']] = $vrstaPlacanja;
        }
        return $keySifraArray;
    }
}
