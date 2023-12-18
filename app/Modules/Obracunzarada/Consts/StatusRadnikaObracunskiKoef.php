<?php

namespace App\Modules\Obracunzarada\Consts;

class StatusRadnikaObracunskiKoef
{
    const ODOBREN = 1;
    const PROVERA = 2;
    const PROVERAPODATAKA = 3;

    public static function all()
    {
        return [
            self::ODOBREN => 'Odobren',
            self::PROVERA => 'Proveri sa (Odgovorno lice)',
            self::PROVERAPODATAKA => 'Proveri podatke'

        ];
    }
}
