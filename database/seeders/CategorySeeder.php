<?php

namespace Database\Seeders;

use App\Enums\PartnerFields;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = $this->getCategoryArray2();

        foreach ($partners as $partner) {
            DB::table('categories')->insert([
                'id' => $partner['GRUPA_ID'],
                'name'=>$partner['NAZIV']

            ]);
        }

    }

    public function getCategoryArray2(){
        $filePath = storage_path('app/backup/GRU.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }
}
