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

class AppUpdateMdrPristupiZaduzenja extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:updateMaticna';

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

        $users=User::all();

        foreach ($users as $user){
            try {
                if($user->active){
                    $mdrUser = Maticnadatotekaradnika::where('MBRD_maticni_broj',$user->maticni_broj)->first();

                    if($mdrUser){
                        $mdrUser->IME_ime= $user->ime;
                        $mdrUser->PREZIME_prezime= $user->prezime;
                        $mdrUser->srednje_ime= $user->srednje_ime;
                        $mdrUser->save();
                    }else{
                        $test='test';
                    }

                }

            }catch (\Exception $exception){
                $test='test';
            }

        }
        $this->alert(PHP_EOL.'Komanda je uspesno izvrsena : res1:');
    }


}
