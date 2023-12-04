<?php declare(strict_types=1);

namespace App\Modules\Osnovnipodaci\Repository;

use App\Models\Organizacioneceline;
use App\Repository\BaseRepository;

class OrganizacionecelineRepository extends BaseRepository implements OrganizacionecelineRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Organizacioneceline $model
     */
    public function __construct(Organizacioneceline $model)
    {
        parent::__construct($model);
    }

    public function getSelectOptionData(): array
    {
        $data= $this->getAll();
        $resultCollection = $data->sortBy('sifra_troskovnog_mesta')->map(function ($item) {
            $newValue = [
                'value'=>$item['sifra_troskovnog_mesta'] . ' ' . $item['naziv_troskovnog_mesta'],
                'key'=>$item['sifra_troskovnog_mesta']];

            return $item['sifra_troskovnog_mesta'] = $newValue;
        });
        return $resultCollection->toArray();
    }
}
