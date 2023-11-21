<?php

namespace Database\Seeders;

use App\Models\User;
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
                'active' => (bool)$radnik['Aktivan'],
                'ime' => $radnik['Ime'],
                'prezime' => $radnik['Prezime'],
                'datum_prestanka_radnog_odnosa' => $radnik['Datum_odlaska'] == '' ? null : Carbon::createFromFormat('m/d/Y', $radnik['Datum_odlaska'])->format('Y-m-d'),
                'troskovno_mesto' => $radnik['trosk_mesto'],
                'maticni_broj' => $radnik['mat_broj'],
                'email' => $radnik['mat_broj'] . $radnik['Ime'] . '@fom.com',
                'password' => Hash::make('Test1234')
            ]);

            $user = User::where('maticni_broj', $radnik['mat_broj'])->get();
            $user[0]->permission()->create([
                'role_name' => 'role_name',
                'user_id' => $user[0]->id,
                'osnovni_podaci' => false
            ]);
        }
    }

    public function getPartnerArray2(){
        $filePath = storage_path('app/backup/Radnici.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }
}
