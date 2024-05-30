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
        $result = $this->model->with('organizacionecelina','maticnadatotekaradnika')->orderBy('organizaciona_celina_id')->orderBy('maticni_broj','asc')->where($column, $value)->get();

        $unserializedVrstePlacanja= $result->map(function ($mesecnaTabelaPoentaza) {
            // Transform each item (user) by returning the desired value

            $unsorted = json_decode($mesecnaTabelaPoentaza['vrste_placanja'],true);
            usort($unsorted,  function($a, $b) {
                return $a['redosled_poentaza_zaglavlje'] - $b['redosled_poentaza_zaglavlje'];
            });

            $mesecnaTabelaPoentaza['vrste_placanja'] = $unsorted;
            $mesecnaTabelaPoentaza['ime'] =  $mesecnaTabelaPoentaza['prezime'] .' ' . $mesecnaTabelaPoentaza['srednje_ime']  .' ' . $mesecnaTabelaPoentaza['ime'];
            $mesecnaTabelaPoentaza['BRCL_REDOSLED'] = (int)$mesecnaTabelaPoentaza->maticnadatotekaradnika->BRCL_redosled_poentazi;
            return $mesecnaTabelaPoentaza;
        });

        return $unserializedVrstePlacanja->sortBy('BRCL_REDOSLED')->sortBy('organizaciona_celina_id')->groupBy('organizaciona_celina_id');
    }

    public function getTableHeaders($mesecnatabelapoentaza)
    {

        $tableHeaders = [];
        foreach ($mesecnatabelapoentaza as $key => $value) {
            $tableHeaders = $value[0]->getAttributes();
            break;
        }

        $vrstePlacanja = is_array($tableHeaders['vrste_placanja']) ? $tableHeaders['vrste_placanja'] : json_decode($tableHeaders['vrste_placanja'],true);
//        unset($tableHeaders['id']);
//        unset($tableHeaders['organizaciona_celina_id']);
//        unset($tableHeaders['user_id']);
//        unset($tableHeaders['obracunski_koef_id']);
//        unset($tableHeaders['datum']);
//        unset($tableHeaders['BRCL_REDOSLED']);
//        unset($tableHeaders['created_at']);
//        unset($tableHeaders['updated_at']);
//        unset($tableHeaders['vrste_placanja']);
//        unset($tableHeaders['srednje_ime']);
//        unset($tableHeaders['prezime']);
//        unset($tableHeaders['napomena']);
//        unset($tableHeaders['user_mdr_id']);
//        unset($tableHeaders['status_poentaze']);

        $tableKeys[] = 'M. Broj';
        $tableKeys[] = 'Radnik';
        foreach ($vrstePlacanja as $key => $value) {

            array_push($tableKeys,$value['key']);
        }


        return $tableKeys;
    }

    public function groupForTableAkontacije($column, $value)
    {

//        $result = $this->model->orderBy('maticni_broj','asc')->where($column, $value)->get()->groupBy('organizaciona_celina_id');
        $result = $this->model->with('organizacionecelina','maticnadatotekaradnika','dpsmakontacije')->orderBy('organizaciona_celina_id')->orderBy('maticni_broj','asc')->where($column, $value)->get();

        $unserializedVrstePlacanja= $result->map(function ($mesecnaTabelaPoentaza) {
            // Transform each item (user) by returning the desired value
//           $vrstePlacanjaArray = json_decode($mesecnaTabelaPoentaza['vrste_placanja'],true);
//            $mesecnaTabelaPoentaza['vrste_placanja'] =  $vrstePlacanjaArray;
////            $mesecnaTabelaPoentaza['vrste_placanja_akontacija']= collect($vrstePlacanjaArray)->where('key', '061')->first(); ADD LOGIC TO load Akontacije data

            $mesecnaTabelaPoentaza['vrste_placanja_akontacija'] = $mesecnaTabelaPoentaza->dpsmakontacije->iznos;
            $mesecnaTabelaPoentaza['ime'] =  $mesecnaTabelaPoentaza['prezime'] .' ' . $mesecnaTabelaPoentaza['srednje_ime']  .' ' . $mesecnaTabelaPoentaza['ime'];
            $mesecnaTabelaPoentaza['BRCL_REDOSLED'] = (int)$mesecnaTabelaPoentaza->maticnadatotekaradnika->BRCL_redosled_poentazi;
            return $mesecnaTabelaPoentaza;
        });


        return $unserializedVrstePlacanja->sortBy('BRCL_REDOSLED')->sortBy('organizaciona_celina_id')->groupBy('organizaciona_celina_id');
    }

}
