<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PorezdoprinosiSeeder::class,
            KreditoriSeeder::class,
            VrsteplacanjaSeeder::class,
            MinimalnebrutoosnoviceSeeder::class,
            RadniciSeeder::class,
            MaticnadatotekaradnikaSeeder::class,
            OrganizacionecelineSeeder::class,
            IsplatnamestaSeeder::class,
            OpstineSeeder::class,
            OblikradaSeeder::class,
            VrstaradasifarnikSeeder::class,
            StrucnakvalifikacijaSeeder::class,
            RadnamestaSeeder::class,
            ZanimanjasifarnikSeeder::class,
            PodaciofirmiSeeder::class,
            // Trenutna plata
            MartPlataSeeder::class,
            DatotekaobracunskihKoefMesecDataSeeder::class,
//             Arhiva
//        ArhivaMaticnadatotekaradnikaSeeder::class,
//            ArhivaDarhObradaSveDkopSeeder::class,
//            ArhivaSumeZaraPoRadnikuSeeder::class,

        ]);

    }
}
