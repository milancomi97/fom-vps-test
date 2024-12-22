<?php

namespace App\Console\Commands;

use App\Models\DpsmKrediti;
use App\Models\Kreditori;
use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Models\User;
use App\Models\UserPermission;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class AppUpdatePristupiMaticni extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:updatePristupiMaticni';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Komanda koja sredjuje projekat';

    /**
     * Execute the console command.
     */

    public function __construct(
    ){
        parent::__construct();
    }
    public function handle()
    {
        if (Schema::hasColumn('user_permissions', 'maticni_broj')) {
            $this->alert(PHP_EOL.'Postoji');

        }else{
            Schema::table('user_permissions', function (Blueprint $table) {
                $table->string('maticni_broj')->nullable();
            });

            $this->alert(PHP_EOL.'Ne postoji');

        }

        if (Schema::hasColumn('permesecnatabelapoents', 'obracunski_koef_id')) {
            Schema::table('permesecnatabelapoents', function (Blueprint $table) {
                $table->dropForeign(['obracunski_koef_id']);
                $table->dropColumn(['obracunski_koef_id']);



            });
            // Optionally drop the columns themselves if necessary
            // $table->dropColumn(['user_dpsm_id', 'obracunski_koef_id', 'user_mdr_id']);

        }else{

            $this->alert(PHP_EOL.'Ne postoji reference');

        }



        $userPermissions = UserPermission::all();

        foreach ($userPermissions as $user){
            $testt='test';

            $userData= User::find($user->user_id);
           $user->maticni_broj=$userData->maticni_broj;
            $user->save();
         $testt='test';


        }

        $this->alert(PHP_EOL.'Fale krediti za ljude sa maticnim:');
    }


    public function getKreditiData()
    {
        $filePath = storage_path('app/backup/kredit_19_11_2024/MKRE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }

}
