<?php

namespace App\Console\Commands;

use App\Models\DpsmFiksnaPlacanja;
use App\Models\DpsmKrediti;
use App\Models\Kreditori;
use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Models\User;
use App\Modules\Obracunzarada\Repository\DpsmFiksnaPlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class AppUpdateFiksnaPlacanja extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:updateFiksnaP';

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
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly DpsmFiksnaPlacanjaRepositoryInterface               $dpsmFiksnaPlacanjaInterface,
        private readonly VrsteplacanjaRepositoryInterface          $vrsteplacanjaInterface,

    ){
        parent::__construct();
    }
    public function handle()
    {


        DpsmFiksnaPlacanja::truncate();
        $fiksnaPlacanja= $this->getFiksnaPlacanjaData();

        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();
        Schema::table('dpsm_fiksna_placanjas', function (Blueprint $table) {
        $table->unsignedBigInteger('obracunski_koef_id')->nullable()->change();
        });
        $counter=0;
        foreach ($fiksnaPlacanja as $fpData) {
            $radnikMdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj', $fpData['MBRD'])->first()->toArray();

            $counter++;
            $data = [
                'user_dpsm_id' =>null,
                'sifra_vrste_placanja' => $fpData['RBVP'],
                'naziv_vrste_placanja' => $vrstePlacanjaSifarnik[$fpData['RBVP']]['naziv_naziv_vrste_placanja'],
                'sati' => (int) $fpData['SATI'] ?? 0,
                'iznos' => (float) $fpData['IZNO'] ?? 0,
                'procenat' => (float) $fpData['PERC'] ?? 0,
                'user_mdr_id' => $radnikMdrData['id'],
                'obracunski_koef_id' => null,
                'maticni_broj'=>$fpData['MBRD'],
//                'status'=>$fpData['STATUS']!=='',
            ];
            $this->dpsmFiksnaPlacanjaInterface->create($data);
        }

        $this->alert('Komanda izvrsena, azurirano: '.$counter);

    }


    public function getFiksnaPlacanjaData()
    {
        $filePath = storage_path('app/backup/plata_25_12_2024/DFVP.csv');

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }

}
