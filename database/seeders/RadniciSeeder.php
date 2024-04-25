<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Obracunzarada\Consts\UserRoles;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\Csv\Reader;
use Exception;

class RadniciSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $radnici = $this->getPartnerArray2();

        foreach ($radnici as $radnik) {

            DB::table('users')->insert([
                'active' => (bool)$radnik['ACTIVE'],
                'ime' => $radnik['IME'],
                'prezime' => $radnik['PREZIME'],
                'ime_oca'=>$radnik['IMEOCA'],
                'srednje_ime'=>$radnik['SREDIME'],
                'datum_prestanka_radnog_odnosa' =>$this->resolvedate($radnik),
                'sifra_mesta_troska_id' => (int)$radnik['RBTC'],
                'maticni_broj' => $radnik['MBRD'],
                'email' => $radnik['MBRD'].'@fom.com',
                'password' => Hash::make('Test1234')
            ]);

            $user = User::where('maticni_broj', $radnik['MBRD'])->get();


            $user[0]->permission()->create([
                'role_id' => UserRoles::ADMINISTRATOR,
                'user_id' => $user[0]->id,
                'osnovni_podaci' => true,
                'obracun_zarada' => true,
                'kadrovska_evidencija' => true,
                'troskovna_mesta_poenter' => $this->poenterPermissionsTest()
            ]);
        }
    }

    public function getPartnerArray2()
    {
        $filePath = storage_path('app/backup/novo/KADR.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

    public function poenterPermissionsTest()
    {
        return '{"10000000": true, "20000000": true, "21000000": true, "22000000": true, "22100000": true, "22200000": true, "22300000": true, "22400000": true, "23000000": true, "23100000": true, "23200000": true, "30000000": true, "31000000": true, "31100000": true, "31200000": true, "31300000": true, "31400000": true, "32100000": true, "32110000": false, "32120000": false, "32200000": false, "32210000": false, "32220000": false, "32230000": false, "32240000": false, "32250000": false, "32260000": false, "32270000": false, "32280000": false, "32290000": false, "32300000": false, "32310000": false, "32320000": false, "32330000": false, "32340000": false, "32400000": false, "32500000": false, "33000000": false, "33000002": false, "33100000": false, "33200000": false, "33300000": false, "40000000": false, "41000000": false, "42000000": false, "50000000": false, "60000000": false, "90000000": false, "90000001": false, "90000002": false, "90000003": false, "90000004": false}';
    }

    public function resolvedate($radnik){


        if($radnik['DAT_KRA'] !== ''){
            $date=Carbon::createFromFormat('m/d/Y', $radnik['DAT_KRA']);
            if ($date->year < 1930) {
                $date->addYears(100);// Add 100 years to the date
            }
            return $date->format('Y-m-d');
        }else{
            return null;
        }
    }
}
