<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;

class CheckData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-data {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');


        $dkopCSV = $this->getDkopDataFromCsv();
        $zaraCSV =$this->getZaraDataFromCsv();

        $bar = $this->output->createProgressBar(count($dkopCSV));

        $bar->start();

        foreach ($datas as $data) {
            $this->info('Maticni broj: '.$data['MBRD']);
            $bar->advance();

        }
        $bar->finish();





        $this->askWithCompletion('Koji podatak zelite da proverite ?',['1','2']);
//        $this->info('Provera podataka za ID: '.$id);
//        $this->comment('Provera podataka za ID: '.$id);
//        $this->question('Provera podataka za ID: '.$id);
//        $this->error('Provera podataka za ID: '.$id);
//        $this->warn('Provera podataka za ID: '.$id);

        $this->alert('Komanda je uspesno izvrsena');
    }

    public function getDkopDataFromCsv()
    {
        $filePath = storage_path('app/backup/novo/ZARA.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

    public function getZaraDataFromCsv()
    {
        $filePath = storage_path('app/backup/novo/DKOP.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
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

}
