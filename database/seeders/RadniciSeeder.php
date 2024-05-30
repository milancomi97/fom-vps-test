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
                'datum_prestanka_radnog_odnosa' =>$this->resolvedate($radnik['DAT_KRA']),
                'datum_zasnivanja_radnog_odnosa'=>$this->resolvedate($radnik['DAT_POC']),
            //   'broj_ugovora_o_radu'
                'sifra_mesta_troska_id' => (int)$radnik['RBTC'],
                'maticni_broj' => $radnik['MBRD'],
                'email' => $radnik['MBRD'].'@fom.com',
                'password' => Hash::make('Test1234')
            ]);

            $user = User::where('maticni_broj', $radnik['MBRD'])->get();


            $user[0]->permission()->create([
                'role_id' =>$this->resolveRoleByMaticni($radnik['MBRD']),
                'user_id' => $user[0]->id,
                'osnovni_podaci' => true,
                'obracun_zarada' => true,
                'kadrovska_evidencija' => true,
                'troskovna_mesta_poenter' =>$this->resolvePoenterPermission($radnik['MBRD'])
            ]);
        }
    }

    public function resolvePoenterPermission($maticniBroj){

        if($maticniBroj=='1234567' || $maticniBroj=='0006001' || $maticniBroj=='0006026'){
            return '{"10000000": true, "20000000": true, "21000000": true, "22000000": true, "22100000": true, "22200000": true, "22300000": true, "22400000": true, "23000000": true, "23100000": true, "23200000": true, "30000000": true, "31000000": true, "31100000": true, "31200000": true, "31300000": true, "31400000": true, "32100000": true, "32110000": true, "32120000": true, "32200000": true, "32210000": true, "32220000": true, "32230000": true, "32240000": true, "32250000": true, "32260000": true, "32270000": true, "32280000": true, "32290000": true, "32300000": true, "32310000": true, "32320000": true, "32330000": true, "32340000": true, "32400000": true, "32500000": true, "33000000": true, "33000002": true, "33100000": true, "33200000": true, "33300000": true, "40000000": true, "41000000": true, "42000000": true, "50000000": true, "60000000": true, "90000000": true, "90000001": true, "90000002": true, "90000003": true, "90000004": true}';
        } elseif($maticniBroj=='7654321') {
            return '{"10000000":false, "20000000":false, "21000000":false, "22000000":false, "22100000":false, "22200000":false, "22300000":false, "22400000":false, "23000000":false, "23100000":false, "23200000":false, "30000000":false, "31000000":false, "31100000":false, "31200000":false, "31300000":false, "31400000":false, "32100000":true, "32110000":true, "32120000":true, "32200000":true, "32210000":true, "32220000":true, "32230000":true, "32240000":false, "32250000":false, "32260000":false, "32270000":false, "32280000":false, "32290000":false, "32300000":false, "32310000":false, "32320000":false, "32330000":false, "32340000":false, "32400000":false, "32500000":false, "33000000":false, "33000002":false, "33100000":false, "33200000":false, "33300000":false, "40000000":false, "41000000":false, "42000000":false, "50000000":false, "60000000":false, "90000000":false, "90000001":false, "90000002":false, "90000003":false, "90000004": true}';
        }else{
            return '{"10000000":false, "20000000":false, "21000000":false, "22000000":false, "22100000":false, "22200000":false, "22300000":false, "22400000":false, "23000000":false, "23100000":false, "23200000":false, "30000000":false, "31000000":false, "31100000":false, "31200000":false, "31300000":false, "31400000":false, "32100000":false, "32110000":false, "32120000":false, "32200000":false, "32210000":false, "32220000":false, "32230000":false, "32240000":false, "32250000":false, "32260000":false, "32270000":false, "32280000":false, "32290000":false, "32300000":false, "32310000":false, "32320000":false, "32330000":false, "32340000":false, "32400000":false, "32500000":false, "33000000":false, "33000002":false, "33100000":false, "33200000":false, "33300000":false, "40000000":false, "41000000":false, "42000000":false, "50000000":false, "60000000":false, "90000000":false, "90000001":false, "90000002":false, "90000003":false, "90000004": true}';
        }
    }
    public function resolveRoleByMaticni($maticniBroj){

        $supervizor = ["0006001"];
        $poenteri = ['0004026','0009326','0009363','0006026','0005577','0004791','0005643','0005561','0005740','0005680','0005642','0009405'];

        $administratori=['0006026'];
        $programeri = ['1234567','7654321'];

        if(in_array($maticniBroj,$supervizor)){
          return UserRoles::SUPERVIZOR;
        }

        if(in_array($maticniBroj,$poenteri)){
            return UserRoles::POENTER;
        }
        if(in_array($maticniBroj,$administratori)){
            return UserRoles::ADMINISTRATOR;
        }
        if(in_array($maticniBroj,$programeri)){
            return UserRoles::PROGRAMER;
        }

        return UserRoles::NONE;

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
        return '{"10000000": true, "20000000": true, "21000000": true, "22000000": true, "22100000": true, "22200000": true, "22300000": true, "22400000": true, "23000000": true, "23100000": true, "23200000": true, "30000000": true, "31000000": true, "31100000": true, "31200000": true, "31300000": true, "31400000": true, "32100000": true, "32110000": true, "32120000": true, "32200000": true, "32210000": true, "32220000": true, "32230000": true, "32240000": true, "32250000": true, "32260000": true, "32270000": true, "32280000": true, "32290000": true, "32300000": true, "32310000": true, "32320000": true, "32330000": true, "32340000": true, "32400000": true, "32500000": true, "33000000": true, "33000002": true, "33100000": true, "33200000": true, "33300000": true, "40000000": true, "41000000": true, "42000000": true, "50000000": true, "60000000": true, "90000000": true, "90000001": true, "90000002": true, "90000003": true, "90000004": true}';
    }

    public function resolvedate($datum){


        if($datum !== ''){
            $date=Carbon::createFromFormat('m/d/Y', $datum);
            if ($date->year < 1930) {
                $date->addYears(100);// Add 100 years to the date
            }
            return $date->format('Y-m-d');
        }else{
            return null;
        }
    }
}
