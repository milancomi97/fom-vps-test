<?php declare(strict_types=1);

namespace App\Modules\Osnovnipodaci\Repository;

use App\Models\Podaciofirmi;
use App\Repository\BaseRepository;

class PodaciofirmiRepository extends BaseRepository implements PodaciofirmiRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Podaciofirmi $model
     */
    public function __construct(Podaciofirmi $model)
    {
        parent::__construct($model);
    }

    public function createCompany(array $data){
           $data['obaveznik_revizije'] = ($data['obaveznik_revizije'] ?? '')  =='on';
           $data['status'] = ($data['status'] ?? '') =='on';

           return $this->create($data);
    }
}
