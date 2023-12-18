<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Mesecnatabelapoentaza;
use App\Repository\BaseRepository;

class MesecnatabelapoentazaRepository extends BaseRepository implements MesecnatabelapoentazaRepositoryInterface
{
    /**
     *
     * @param Mesecnatabelapoentaza $model
     */
    public function __construct(Mesecnatabelapoentaza $model)
    {
        parent::__construct($model);
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

    public function groupForTable($column, $value)
    {

//        $result = $this->model->orderBy('maticni_broj','asc')->where($column, $value)->get()->groupBy('organizaciona_celina_id');
        $result = $this->model->with('organizacionecelina')->orderBy('organizaciona_celina_id')->orderBy('maticni_broj','asc')->where($column, $value)->get();

        $unserializedVrstePlacanja= $result->map(function ($mesecnaTabelaPoentaza) {
            // Transform each item (user) by returning the desired value
            $mesecnaTabelaPoentaza['vrste_placanja'] =  json_decode($mesecnaTabelaPoentaza['vrste_placanja'],true);
            $mesecnaTabelaPoentaza['ime'] =  $mesecnaTabelaPoentaza['prezime'] .' ' . $mesecnaTabelaPoentaza['srednje_ime']  .' ' . $mesecnaTabelaPoentaza['ime'];
            return $mesecnaTabelaPoentaza;
        });
        return $result->groupBy('organizaciona_celina_id');
    }

    public function getTableHeaders($mesecnatabelapoentaza)
    {

        $tableHeaders = [];
        foreach ($mesecnatabelapoentaza as $key => $value) {
            $tableHeaders = $value[0]->getAttributes();
            break;
        }

        $vrstePlacanja = $tableHeaders['vrste_placanja'];
        unset($tableHeaders['id']);
        unset($tableHeaders['organizaciona_celina_id']);
        unset($tableHeaders['user_id']);
        unset($tableHeaders['obracunski_koef_id']);
        unset($tableHeaders['datum']);
        unset($tableHeaders['created_at']);
        unset($tableHeaders['updated_at']);
        unset($tableHeaders['vrste_placanja']);
        unset($tableHeaders['srednje_ime']);
        unset($tableHeaders['prezime']);
        unset($tableHeaders['napomena']);
        unset($tableHeaders['status_poentaze']);

        $tableKeys =array_keys($tableHeaders);
        foreach ($vrstePlacanja as $key => $value) {
            array_push($tableKeys,$value['key']);
        }
        return $tableKeys;
    }
}
