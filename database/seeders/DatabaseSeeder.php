<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            VrstaradasifarnikSeeder::class,
            StrucnakvalifikacijaSeeder::class,
            RadnamestaSeeder::class,
            ZanimanjasifarnikSeeder::class,
            OrganizacionecelineSeeder::class,
            PodaciofirmiSeeder::class,
            PartnerSeeder::class,
            CategorySeeder::class,
            StanjeZalihaSeeder::class,
            MaterijalSeeder::class,
            RadniciSeeder::class,
            OpstineSeeder::class
        ]);

    }
}
