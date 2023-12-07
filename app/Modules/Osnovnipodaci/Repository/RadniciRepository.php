<?php declare(strict_types=1);

namespace App\Modules\Osnovnipodaci\Repository;

use App\Models\Drzave;
use App\Models\User;
use App\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class RadniciRepository extends BaseRepository implements RadniciRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function createUser(array $attributes): Model {

        $attributes['active'] = ( $attributes['active'] ?? "") =='on';
        return $this->create($attributes);
    }

    public function getAllActive(){
       return $this->model->with('maticnadatotekaradnika')->where('active',1)->get();
    }

}
