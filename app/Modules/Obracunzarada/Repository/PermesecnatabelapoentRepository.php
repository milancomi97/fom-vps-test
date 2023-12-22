<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Permesecnatabelapoent;
use App\Repository\BaseRepository;

class PermesecnatabelapoentRepository extends BaseRepository implements PermesecnatabelapoentRepositoryInterface
{
    /**
     *
     * @param Permesecnatabelapoent $model
     */
    public function __construct(Permesecnatabelapoent $model)
    {
        parent::__construct($model);
    }

    public function createMany($array)
    {
        return $this->model->insert($array);
    }

    public function updateStatus($array)
    {
        $record = $this->getById($array['recordId']);
        if($array['statusType'] =='odgovorna_lica_status'){
           $odgovornaLicaData =  json_decode($record->odgovorna_lica_status,true);
           $odgovornaLicaData[$array['userId']]= $array['status'];
            $record->odgovorna_lica_status = json_encode($odgovornaLicaData);
        } elseif ($array['statusType'] = 'poenteri_status'){
            $poenteriData = json_decode($record->poenteri_status,true);
            $poenteriData[$array['userId']]= $array['status'];
            $record->poenteri_status = json_encode($poenteriData);
        }
        return $record->save();
    }
}
