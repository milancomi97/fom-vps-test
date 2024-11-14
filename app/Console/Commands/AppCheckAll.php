<?php

namespace App\Console\Commands;

use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Models\User;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use Illuminate\Console\Command;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AppCheckAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:checkAll';

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

        $kadrData = $this->getKadrData();
        $mdrData = $this->getMdrData();

        $kadrNotExist=[];
        $mdrNotExist=[];
        // 1. Logika za azuriranje KADR
        foreach ($kadrData as $kadr){
            $maticniBroj = $kadr['MBRD'];

            $testt='test';

            $userData = User::where('maticni_broj',$maticniBroj)->first();

            if($userData==null){
                $kadrNotExist[]=$maticniBroj;
                // create logika
            }else{
                // update logika
            }
        }


        // 2. Logika za azuriranje kadr
        foreach ($mdrData as $mdr){
            $maticniBroj = $mdr['MBRD'];
            $testt='test';

            $mdrData = Maticnadatotekaradnika::where('MBRD_maticni_broj' ,$maticniBroj)->first();
            if($mdrData==null){
                $mdrNotExist[]=$maticniBroj;
                // create logika
            }else{
                // update logika
            }



        }

        // 3. Logika za proveravanje User Permision
        if (!Schema::hasColumn('user_permissions', 'maticni_broj')) {

           $testes='testt';
            Schema::table('user_permissions', function (Blueprint $table) {
                $table->string('maticni_broj')->unique();
            });
        }

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


        $this->info('KADR ne postoje.'.json_encode($kadrNotExist));

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
        $filePath = storage_path('app/backup/plata_14_11_2024/MDR.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }

}
