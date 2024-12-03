<?php

namespace App\Console\Commands;

use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Models\User;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppCheckUpdateMdr extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:checkUpdateMdr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Komanda koja proverava projekat';

    /**
     * Execute the console command.
     */




    public function handle()
    {

        $mdrData = $this->getMdrData();

        $kadrNotExist=[];
        $mdrNotExist=[];
        $kadrDeActivated=[];
        $mdrDeActivated=[];
        // 1. Logika za azuriranje KADR



        // 2. Logika za azuriranje kadr
        foreach ($mdrData as $data){
            $maticniBroj = $data['MBRD'];
            $testt='test';
            $userData = User::where('maticni_broj',$maticniBroj)->first();

            $mdrData = Maticnadatotekaradnika::where('MBRD_maticni_broj' ,$maticniBroj)->first();
            if($mdrData==null){
                $mdrNotExist[]=$maticniBroj;
                // create logika

                DB::table('maticnadatotekaradnikas')->insert([
                        'MBRD_maticni_broj' => $data['MBRD'],
                        'PREZIME_prezime' => $userData->prezime,
                        'IME_ime' => $userData->ime,
                        'user_id'=>$userData->id,
                        'srednje_ime' =>$userData->srednje_ime,
                        'RBRM_radno_mesto' => $data['RBRM'],
                        'RBIM_isplatno_mesto_id' => $data['RBIM'],
                        'ZRAC_tekuci_racun' => $data['ZRAC'],
                        'BRCL_redosled_poentazi' => $data['BRCL'],
//                    'BR_vrsta_rada' => $data['BR'],
                        'BR_vrsta_rada' => '1',
                        'P_R_oblik_rada' => $data['P_R'],
                        'RJ_radna_jedinica' => $data['RJ'],
                        'BRIG_brigada' => $data['BRIG'],
                        'GGST_godine_staza' => $data['GGST'],
                        'MMST_meseci_staza' => $data['MMST'],
                        'MRAD_minuli_rad_aktivan' => $data['MRAD'] == "D",
                        'PREB_prebacaj' => $data['PREB'],
                        'RBSS_stvarna_strucna_sprema' => $data['RBSS'],
                        'RBPS_priznata_strucna_sprema' => $data['RBPS'],
                        'KOEF_osnovna_zarada' => $data['KOEF'] !== '' ? $data['KOEF'] : 0,
                        'KOEF1_prethodna_osnovna_zarada' => $data['KOEF1'] !== '' ? $data['KOEF1'] : 0,
                        'LBG_jmbg' => $data['LBG'],
                        'POL_pol' => $data['POL'],
                        'PRCAS_ukupni_sati_za_ukupan_bruto_iznost' => $data['PRCAS'],
                        'PRIZ_ukupan_bruto_iznos' => $data['PRIZ'],
                        'BROJ_broj_meseci_za_obracun' => $data['BROJ'],
                        'DANI_kalendarski_dani' => $data['DANI'] !== '' ?  $data['DANI'] : 0,
                        'IZNETO1_bruto_zarada_za_akontaciju' => $data['IZNETO1'] !== '' ? $data['IZNETO1'] : 0,
                        'POROSL1_poresko_oslobodjenje_za_akontaciju' => $data['POROSL1'] !== '' ? $data['POROSL1'] : 0,
                        'SIP1_porez_za_akontaciju' => $data['SIP1'] !== '' ? $data['SIP1'] : 0,
                        'BROSN1_minimalna_osnovica_za_obracun_doprinosa_za_akontaciju' => $data['BROSN1'] !== '' ? $data['BROSN1'] : 0,
                        'ZDRR1_zdravstveno_osiguranje_na_teret_radnika_za_akontaciju' => $data['ZDRR1'] !== '' ? $data['ZDRR1'] : 0,
                        'ZDRP1_zdravstveno_osiguranje_na_teret_poslodavca_za_akontaciju' => $data['ZDRP1'] !== '' ? $data['ZDRP1'] : 0,
                        'ONEZR1_osig_nezaposlenosti_na_teret_radnika_za_akontaciju' => $data['ONEZR1'] !== '' ? $data['ONEZR1'] : 0,
                        'PIOR_ukupni_pio_doprinos_na_teret_radnika' => $data['PIOR'] !== '' ? $data['PIOR'] : 0,
                        'PIOP_ukupni_pio_doprinos_na_teret_poslodavca' => $data['PIOP'] !== '' ? $data['PIOP'] : 0,
                        'ONEZR_ukupni_doprinos_za_nezaposlenost_na_teret_radnika' => $data['ONEZR'] !== '' ? $data['ONEZR'] : 0,
                        'ZDRR_ukupni_doprinos_za_zdravstveno_osiguranje_na_teret_radnika' => $data['ZDRR'] !== '' ? $data['ZDRR'] : 0,
                        'ZDRP_ukupni_doprinos_zdrav_osig_teret_poslodavca' => $data['ZDRP'] !== '' ? $data['ZDRP'] : 0,
                        'BROSN_bruto_zarada_za_obracun_doprinosa' => $data['BROSN'] !== '' ? $data['BROSN'] : 0,
                        'POROSL_ukupno_poresko_oslobodjenje' => $data['POROSL'] !== '' ? $data['POROSL'] : 0,
                        'SIP_ukupni_porezi' => $data['SIP'] !== '' ? $data['SIP'] : 0,
                        'ACTIVE_aktivan' => $data['ACTIVE'] == 'TRUE',
                        'IZNETO_ukupna_bruto_zarada' => $data['IZNETO'] !== '' ? $data['IZNETO'] : 0,
                        'KFAK_korektivni_faktor' => $data['KFAK'] !== '' ? $data['KFAK'] : 0,
                        'troskovno_mesto_id' => $data['RBTC'] !== '' ? $data['RBTC'] : 0,
                        'opstina_id' => $data['RBOP'] !== '' ? $data['RBOP'] : null,
                        'adresa_ulica_broj' => $data['ULICA'],
                        'adresa_mesto' => $data['MESTO']
                        ]
                    );

            }else{

                $mdrData->update([
                    'user_id'=>$userData->id,
                    'RBRM_radno_mesto' => $data['RBRM'],
                    'RBIM_isplatno_mesto_id' => $data['RBIM'],
                    'ZRAC_tekuci_racun' => $data['ZRAC'],
                    'BRCL_redosled_poentazi' => $data['BRCL'],
//                    'BR_vrsta_rada' => $data['BR'],
                    'BR_vrsta_rada' => '1',
                    'P_R_oblik_rada' => $data['P_R'],
                    'RJ_radna_jedinica' => $data['RJ'],
                    'BRIG_brigada' => $data['BRIG'],
                    'GGST_godine_staza' => $data['GGST'],
                    'MMST_meseci_staza' => $data['MMST'],
                    'MRAD_minuli_rad_aktivan' => $data['MRAD'] == "D",
                    'PREB_prebacaj' => $data['PREB'],
                    'RBSS_stvarna_strucna_sprema' => $data['RBSS'],
                    'RBPS_priznata_strucna_sprema' => $data['RBPS'],
                    'KOEF_osnovna_zarada' => $data['KOEF'] !== '' ? $data['KOEF'] : 0,
                    'KOEF1_prethodna_osnovna_zarada' => $data['KOEF1'] !== '' ? $data['KOEF1'] : 0,
                    'LBG_jmbg' => $data['LBG'],
                    'POL_pol' => $data['POL'],
                    'PRCAS_ukupni_sati_za_ukupan_bruto_iznost' => $data['PRCAS'],
                    'PRIZ_ukupan_bruto_iznos' => $data['PRIZ'],
                    'BROJ_broj_meseci_za_obracun' => $data['BROJ'],
                    'DANI_kalendarski_dani' => $data['DANI'] !== '' ?  $data['DANI'] : 0,
                    'IZNETO1_bruto_zarada_za_akontaciju' => $data['IZNETO1'] !== '' ? $data['IZNETO1'] : 0,
                    'POROSL1_poresko_oslobodjenje_za_akontaciju' => $data['POROSL1'] !== '' ? $data['POROSL1'] : 0,
                    'SIP1_porez_za_akontaciju' => $data['SIP1'] !== '' ? $data['SIP1'] : 0,
                    'BROSN1_minimalna_osnovica_za_obracun_doprinosa_za_akontaciju' => $data['BROSN1'] !== '' ? $data['BROSN1'] : 0,
                    'ZDRR1_zdravstveno_osiguranje_na_teret_radnika_za_akontaciju' => $data['ZDRR1'] !== '' ? $data['ZDRR1'] : 0,
                    'ZDRP1_zdravstveno_osiguranje_na_teret_poslodavca_za_akontaciju' => $data['ZDRP1'] !== '' ? $data['ZDRP1'] : 0,
                    'ONEZR1_osig_nezaposlenosti_na_teret_radnika_za_akontaciju' => $data['ONEZR1'] !== '' ? $data['ONEZR1'] : 0,
                    'PIOR_ukupni_pio_doprinos_na_teret_radnika' => $data['PIOR'] !== '' ? $data['PIOR'] : 0,
                    'PIOP_ukupni_pio_doprinos_na_teret_poslodavca' => $data['PIOP'] !== '' ? $data['PIOP'] : 0,
                    'ONEZR_ukupni_doprinos_za_nezaposlenost_na_teret_radnika' => $data['ONEZR'] !== '' ? $data['ONEZR'] : 0,
                    'ZDRR_ukupni_doprinos_za_zdravstveno_osiguranje_na_teret_radnika' => $data['ZDRR'] !== '' ? $data['ZDRR'] : 0,
                    'ZDRP_ukupni_doprinos_zdrav_osig_teret_poslodavca' => $data['ZDRP'] !== '' ? $data['ZDRP'] : 0,
                    'BROSN_bruto_zarada_za_obracun_doprinosa' => $data['BROSN'] !== '' ? $data['BROSN'] : 0,
                    'POROSL_ukupno_poresko_oslobodjenje' => $data['POROSL'] !== '' ? $data['POROSL'] : 0,
                    'SIP_ukupni_porezi' => $data['SIP'] !== '' ? $data['SIP'] : 0,
                    'ACTIVE_aktivan' => $data['ACTIVE'] == 'TRUE',
                    'IZNETO_ukupna_bruto_zarada' => $data['IZNETO'] !== '' ? $data['IZNETO'] : 0,
                    'KFAK_korektivni_faktor' => $data['KFAK'] !== '' ? $data['KFAK'] : 0,
                    'troskovno_mesto_id' => $data['RBTC'] !== '' ? $data['RBTC'] : 0,
                    'opstina_id' => $data['RBOP'] !== '' ? $data['RBOP'] : null,
                    'adresa_ulica_broj' => $data['ULICA'],
                    'adresa_mesto' => $data['MESTO']
                ]);
                // update logika
                $test='test';
//                $mdrDeActivated[]=$maticniBroj;
//                if($mdrData->ACTIVE_aktivan==1 && $mdr['ACTIVE']=='FALSE'){
//                    $mdrDeActivated['one'][]=$maticniBroj;
//
//                }
//
//                if($mdrData->ACTIVE_aktivan==0 && $mdr['ACTIVE']=='TRUE'){
//                    $mdrDeActivated['two'][]=$maticniBroj;
//
//                }
                // check deactivated
            }



        }

        // 3. Logika za proveravanje User Permision
//        if (!Schema::hasColumn('user_permissions', 'maticni_broj')) {
//
//           $testes='testt';
//            Schema::table('user_permissions', function (Blueprint $table) {
//                $table->string('maticni_broj')->unique();
//            });
//        }

        // 4. Logika za proveravanje Radnik - Troskovni centar - rasporedi radnike

        // 5. Logika za ispavke - promeni sifru placanja (primer)


        // 6. Logika za proveru kaskadnih kljuceva


//        Schema::table('your_table', function (Blueprint $table) {
//            $table->dropForeign(['column_name']); // Drop the existing constraint
//            $table->foreign('column_name')
//                ->references('id')
//                ->on('other_table'); // Re-add without onDelete('cascade')
//        });
//        DB::statement('ALTER TABLE your_table DROP FOREIGN KEY your_foreign_key_name');
//        DB::statement('ALTER TABLE your_table ADD CONSTRAINT your_foreign_key_name FOREIGN KEY (column_name) REFERENCES other_table(id)');


        // 7. Logika za proveru AKTIVAN MESEC ID _


//        $this->info('KADR ACTIVE neslaganja.'.json_encode($kadrDeActivated));
//
//        $this->info('MDR ACTIVE neslaganja.'.json_encode($mdrDeActivated));


        $this->info('MDR ne postoje.'.json_encode($mdrNotExist));


        $this->info(PHP_EOL.'Komanda je uspesno izvrsena');


    }


//array_diff(): Compares arrays and returns the values that are present in the first array but not in the others.
//
//$array1 = [1, 2, 3, 4, 5];
//$array2 = [3, 4, 5, 6, 7];
//$diff = array_diff($array1, $array2);
//print_r($diff); // Output: [1, 2]
//
//
//array_intersect(): Compares arrays and returns the values that are present in all arrays.
//
//$array1 = [1, 2, 3, 4, 5];
//$array2 = [3, 4, 5, 6, 7];
//$intersect = array_intersect($array1, $array2);
//print_r($intersect); // Output: [3, 4, 5]
//
//
//array_merge(): Merges one or more arrays into one.
//
//$array1 = [1, 2, 3];
//$array2 = ['a', 'b', 'c'];
//$merged = array_merge($array1, $array2);
//print_r($merged); // Output: [1, 2, 3, 'a', 'b', 'c']

//array_map(): Applies a callback function to each element of an array and returns the resulting array.
//// Example 1: Doubling each element in the array
//$array = [1, 2, 3, 4, 5];
//$doubled = array_map(function($value) {
//    return $value * 2;
//}, $array);
//print_r($doubled); // Output: [2, 4, 6, 8, 10]
//
//// Example 2: Appending 'Hello' to each element in the array
//$array = ['John', 'Doe', 'Alice'];
//$greetings = array_map(function($name) {
//    return 'Hello ' . $name;
//}, $array);
//print_r($greetings); // Output: ['Hello John', 'Hello Doe', 'Hello Alice']

//array_filter(): Filters elements of an array using a callback function. The callback function should return true to keep the element or false to remove it.
//
//// Example 1: Filtering out odd numbers from an array
//$array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
//$evens = array_filter($array, function($value) {
//    return $value % 2 == 0;
//});
//print_r($evens); // Output: [2, 4, 6, 8, 10]
//
//// Example 2: Filtering out empty strings from an array
//$array = ['', 'Hello', '', 'World', '', ''];
//$nonEmptyStrings = array_filter($array, function($value) {
//    return !empty($value);
//});
//print_r($nonEmptyStrings); // Output: ['Hello', 'World']

//array_reduce(): Iteratively reduce the array to a single value using a callback function.
//array_keys(): Return all the keys or a subset of the keys of an array.
//array_values(): Return all the values of an array.
//array_slice(): Extract a slice of the array.
//array_splice(): Remove a portion of the array and replace it with something else.
//array_unique(): Removes duplicate values from an array.
//array_flip(): Exchanges all keys with their associated values in an array.
//array_search(): Searches the array for a given value and returns the first corresponding key if successful.
//array_column(): Return the values from a single column in the input array.
//array_walk(): Apply a user-defined function to each element of an array.


    public function getKadrData()
    {
        $filePath = storage_path('app/backup/plata_14_11_2024/KADR.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }

    public function getMdrData()
    {

        $filePath = storage_path('app/backup/plata_02_12_2024/MDR.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
    public function resolvedate($datum)
    {


        if ($datum !== '') {
            $date = Carbon::createFromFormat('m/d/Y', $datum);
            if ($date->year < 1930) {
                $date->addYears(100);// Add 100 years to the date
            }
            return $date->format('Y-m-d');
        } else {
            return null;
        }
    }
}
