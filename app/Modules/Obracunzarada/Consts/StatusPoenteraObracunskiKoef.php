<?php

namespace App\Modules\Obracunzarada\Consts;

class StatusPoenteraObracunskiKoef
{
    const UPRIPREMI = 0;
    const POSLATNAPROVERU = 1;
    const ODOBREN = 2;

    public static function all()
    {
        return [
            self::UPRIPREMI => 'U pripremi',
            self::POSLATNAPROVERU => 'Poslat na proveru',
            self::ODOBREN => 'Odobren',
        ];
    }
}
