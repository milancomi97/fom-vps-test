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

class AppUpdateKljucevi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:updateKljucevi';

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
        Schema::table('dpsm_fiksna_placanjas', function (Blueprint $table) {
//            $table->dropForeign(['user_mdr_id']);
//            $table->index('maticni_broj');

        });

        Schema::table('dpsm_kreditis', function (Blueprint $table) {
            $table->dropForeign(['user_mdr_id']);

            $table->index('maticni_broj');
        });

        Schema::table('dpsm_poentazaslogs', function (Blueprint $table) {
            $table->dropForeign(['user_dpsm_id']);
            $table->dropForeign(['obracunski_koef_id']);
            $table->dropForeign(['user_mdr_id']);

            $table->index('maticni_broj');

        });

        Schema::table('obrada_dkop_sve_vrste_placanjas', function (Blueprint $table) {
            $table->dropForeign(['user_dpsm_id']);
            $table->dropForeign(['obracunski_koef_id']);
            $table->dropForeign(['user_mdr_id']);

            $table->index('maticni_broj');

        });

        Schema::table('obrada_kreditis', function (Blueprint $table) {
            $table->dropForeign(['obracunski_koef_id']);
            $table->dropForeign(['user_mdr_id']);

            $table->index('maticni_broj');

        });

        Schema::table('obrada_zara_po_radnikus', function (Blueprint $table) {
            $table->dropForeign(['user_dpsm_id']);
            $table->dropForeign(['obracunski_koef_id']);
            $table->dropForeign(['user_mdr_id']);

            $table->index('maticni_broj');

        });

        $this->alert(PHP_EOL.'Komanda je uspesno izvrsena : res1:');
    }


}
