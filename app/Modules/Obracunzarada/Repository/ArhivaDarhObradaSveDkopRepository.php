<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\ArhivaDarhObradaSveDkop;
use App\Repository\BaseRepository;

class ArhivaDarhObradaSveDkopRepository extends BaseRepository implements ArhivaDarhObradaSveDkopRepositoryInterface
{
    /**
     *
     * @param ArhivaDarhObradaSveDkop $model
     */
    public function __construct(ArhivaDarhObradaSveDkop $model)
    {
        parent::__construct($model);
    }


}
