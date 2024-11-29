<?php

namespace App\Console\Commands;

use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Models\User;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class AppUpdateMaticnaEmailSlanje extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:updateEmailSlanje';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Komanda koja sredjuje projekat';

    /**
     * Execute the console command.
     */

    public function handle()
    {


        if (Schema::hasColumn('maticnadatotekaradnikas', 'email_za_plate')) {
        $this->alert(PHP_EOL.'Postoji');

        }else{
            Schema::table('maticnadatotekaradnikas', function (Blueprint $table) {
                $table->string('email_za_plate')->nullable();
                $table->boolean('email_za_plate_poslat')->nullable();
            });

            $this->alert(PHP_EOL.'Ne postoji');

        }


        $emails = $this->getEmailData();

        foreach ($emails as $emailData){
            $mdrRadnik = Maticnadatotekaradnika::where('MBRD_maticni_broj',$emailData['MATICNI_BROJ'])->first();
            $mdrRadnik->email_za_plate = $emailData['EMAIL'];
            $mdrRadnik->save();
            $test='testt';
        }
    }

    public function getEmailData()
    {
        $filePath = storage_path('app/backup/azuriranje_email_plate/finalni_email_excel_semincol.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
