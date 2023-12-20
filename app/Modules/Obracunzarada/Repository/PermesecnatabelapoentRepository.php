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
        $data = [$array['userId'] =>$array['status']];
        if($array['statusType'] =='odgovorna_lica_status'){
            $record->odgovorna_lica_status=json_encode($data);
        } elseif ($array['statusType'] = 'poenteri_status'){
            $record->poenteri_status = json_encode($data);
        }
        return $record->save();
    }
}
