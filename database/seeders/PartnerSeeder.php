<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0;$i<2000;$i++){

        DB::table('partners')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10) . '@gmail.com',
            'short_name' => Str::random(10),
            'contact_employee' => Str::random(10),
            'pib' => Str::random(10),
            'phone' => Str::random(10),
            'web_site' => Str::random(10),
            'sifra_delatnosti' => Str::random(10),
            'odgovorno_lice' => Str::random(10),
            'maticni_broj' => Str::random(10),
            'registarski_broj' => Str::random(10),
            'mesto' => 2,
            'pripada_pdvu' => false,
            'active'=>rand(0,1),
            'adress' => Str::random(10),
            'internal_sifra'=>$i
        ]);
        }

    }
}
