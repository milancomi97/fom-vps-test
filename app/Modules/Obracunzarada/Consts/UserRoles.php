<?php

namespace App\Modules\Obracunzarada\Consts;

class UserRoles
{
    const NONE = 0;
    const DEFAULT = 1;
    const POENTER = 2;
    const PROGRAMERI = 3;
    const ADMINISTRATOR = 4;
    const SUPERVIZOR = 5;

    public static function all()
    {
        return [
            self::NONE => 'Bez pristupa',
            self::POENTER => 'Poenter',
            self::PROGRAMERI => 'Programer',
            self::ADMINISTRATOR => 'Administrator',
            self::SUPERVIZOR => 'Supervizor'

        ];
    }
}
