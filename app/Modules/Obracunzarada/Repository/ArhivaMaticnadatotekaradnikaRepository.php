<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\ArhivaMaticnadatotekaradnika;
use App\Repository\BaseRepository;

class ArhivaMaticnadatotekaradnikaRepository extends BaseRepository implements ArhivaMaticnadatotekaradnikaRepositoryInterface
{
    /**
     *
     * @param ArhivaMaticnadatotekaradnika $model
     */
    public function __construct(ArhivaMaticnadatotekaradnika $model)
    {
        parent::__construct($model);
    }

}
