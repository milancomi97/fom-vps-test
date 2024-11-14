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

class AppUpdateAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:updateAll';

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
        if (!Schema::hasColumn('user_permissions', 'maticni_broj')) {

            $testes='testt';
            Schema::table('user_permissions', function (Blueprint $table) {
                $table->string('maticni_broj')->unique();
            });
        }

        $this->alert(PHP_EOL.'Komanda je uspesno izvrsena : res1:');
    }


}
