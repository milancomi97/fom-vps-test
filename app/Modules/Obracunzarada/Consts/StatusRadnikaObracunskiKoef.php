<?php

namespace App\Modules\Obracunzarada\Consts;

class StatusRadnikaObracunskiKoef
{
    const UPRIPREMI = 0;
    const POSLATNAPROVERU = 1;
    const ODOBREN = 2;
    const ODBIJEN = 3;

    public static function all()
    {
        return [
            self::UPRIPREMI => 'U pripremi',
            self::POSLATNAPROVERU => 'Poslat na proveru',
            self::ODOBREN => 'Odobren',
            self::ODBIJEN => 'Odbijen'

        ];
    }
}
