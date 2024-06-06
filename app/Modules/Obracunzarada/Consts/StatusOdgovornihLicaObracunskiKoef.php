<?php

namespace App\Modules\Obracunzarada\Consts;

class StatusOdgovornihLicaObracunskiKoef
{
    const NACEKANJU = 0;
    const ODOBREN = 1;

    public static function all()
    {
        return [
            self::NACEKANJU => 'Na čekanju',
            self::ODOBREN => 'Odobren',
        ];
    }
}
