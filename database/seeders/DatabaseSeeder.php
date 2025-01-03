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

            // remove after devv



//            AvgustPravaPlataSeeder::class,

        // Materijalno start
            PartnerSeeder::class,
            DokumentSifarnikSeeder::class,

//            php artisan migrate --path=/database/migrations/2023_07_19_135614_create_materijals_table.php

//
            CategorySeeder::class,
            MagacinSeeder::class,
            MaterijalSeeder::class,
            StanjeZalihaSeeder::class,
            KarticeSeeder::class,
            PorudzbineSeeder::class,

            // Materijalno end
//            PorezdoprinosiSeeder::class,
//            KreditoriSeeder::class,
//            VrsteplacanjaSeeder::class,
//            RadniciSeeder::class,
            // Verzija stara
//            MaticnadatotekaradnikaSeeder::class,
        // 1.1
//            MaticnadatotekaradnikaSeeder::class,


//            OrganizacionecelineSeeder::class,
//            OpstineSeeder::class,
//            OblikradaSeeder::class,
//            VrstaradasifarnikSeeder::class,
//            StrucnakvalifikacijaSeeder::class,
//            RadnamestaSeeder::class,
//            ZanimanjasifarnikSeeder::class,
//            PodaciofirmiSeeder::class,
//            IsplatnamestaSeeder::class,
//            MinimalnebrutoosnoviceSeeder::class,


            // Avgust razliika
//            IsplatnamestaAvgustSeeder::class,
//            MinimalnebrutoosnoviceAvgustSeeder::class,

        // Nove Stvari za jul platu
//            JulDPSMPlataSeeder::class,

//            MartPlataSeeder::class,


//            AvgustNovoPlataSeeder::class,

//            MartPlataSeeder::class,
//            AvgustPlataSeeder::class,
//            DatotekaobracunskihKoefMesecDataSeeder::class,



            SeptembarFullUpdateSeeder::class,

//             Arhiva
            ArhivaMaticnadatotekaradnikaSeeder::class,
            ArhivaDarhObradaSveDkopSeeder::class,
            ArhivaSumeZaraPoRadnikuSeeder::class,

        ]);

    }
}
