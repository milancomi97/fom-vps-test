<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class PodaciofirmiSeeder extends Seeder
{
    public function run(): void
    {
        $datas = $this->getDataFromCsv();

        foreach ($datas as $data) {
            DB::table('podaciofirmis')->insert([
                'naziv_firme' => $data['Naziv Firme-Skraceni naziv'],
                'poslovno_ime' => $data['Poslovno_ime'],
                'skraceni_naziv_firme' => $data['Naziv Firme-Skraceni naziv'],
                'status' => $data['Status'],
                'pravna_forma' => $data['Pravna_forma'],
                'maticni_broj' => $data['maticni_broj'],
                'datum_osnivanja' => Carbon::createFromFormat('m.d.Y', $data['Datum_osnivanja'])->format('Y-m-d'),
                'adresa_sedista' => $data['Adresa Sedista'],
//                'opstina_id'=>  $data['Sifra Opstine'],
                'ulica_broj_slovo' => $data['Ulica i Broj'],
                'broj_poste' => '11420',
                'pib' => $data['PIB'],
                'sifra_delatnosti' => $data['Sifra_delatnosti'],
                'naziv_delatnosti' => $data['Naziv_delatnosti'],
                'racuni_u_bankama' => $data['Računi u Bankama'],
                'adresa_za_prijem_poste' => $data['Adresa za prijem poste'],
                'adresa_za_prijem_elektronske_poste' => $data['Adresa za Prijem Elektronske Pošte'],
                'telefon' => $data['Telefon'],
                'internet_adresa' => $data['Internet Adresa'],
                'zakonski_zastupnik_ime_prezime' => $data['Zakonski Zastupnik'],
                'zakonski_zastupnik_funkcija' => $data['Zakonski Zastupnik - Funkcija'],
                'zakonski_zastupnik_jmbg' => $data['Zakonski Zastupnik - JMBG'],
                'obaveznik_revizije' => $data['Obaveznik Revizije'],
                'velicina_po_razvrstavanju' => $data['Velicina Po Razvrstavanju'],
                'minulirad' => 0.4,
                'minulirad_aktivan' => true
            ]);
        }

    }

    public function getDataFromCsv()
    {
        $filePath = storage_path('app/backup/PodaciOfirmi.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }

}
