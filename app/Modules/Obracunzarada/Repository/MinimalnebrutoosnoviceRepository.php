<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Minimalnebrutoosnovice;
use App\Repository\BaseRepository;

class MinimalnebrutoosnoviceRepository extends BaseRepository implements MinimalnebrutoosnoviceRepositoryInterface
{
    /**
     * constructor.
     *
     * @param Minimalnebrutoosnovice $model
     */
    public function __construct(Minimalnebrutoosnovice $model)
    {
        parent::__construct($model);
    }

    public function getDataForCurrentMonth($date)
    {
        $timestamp = strtotime($date);
        $month = date('m', $timestamp);
        $year = date('y', $timestamp);
        $criteria = $month.$year;

        $result = $this->model->where('M_G_mesec_dodina',$criteria)->first();
        if($result!==null){
            return $result;
        }else{
          return $this->model->latest('M_G_date')->take(1)->get()->first();
        }

        // TODO Za testiranje otvaranja meseca, da se ne brise baza
//        return $this->model->where('M_G_mesec_dodina','0123')->first();

    }
}
