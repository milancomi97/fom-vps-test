<?php

namespace App\Console\Commands;

use App\Models\DpsmKrediti;
use App\Models\Kreditori;
use App\Models\Maticnadatotekaradnika;
use App\Models\Mesecnatabelapoentaza;
use App\Models\User;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\Csv\Reader;
use Illuminate\Support\Facades\DB;

class AppUpdateKrediti extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appp:updateKrediti';

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
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface
    ){
        parent::__construct();
    }
    public function handle()
    {
        $kreditiKojiFale=[];

        DpsmKrediti::truncate();
        $kreditiData= $this->getKreditiData();

//        $this->checkKreditiData($kreditiData);

        foreach ($kreditiData as $kredit) {
            $kreditiReaderdata[] = $kredit;
        }

        $collectRadnikKrediti = collect($kreditiReaderdata)->groupBy('MBRD');

        foreach ($collectRadnikKrediti as $krediti){

            $maticniBrojParametar =$krediti[0]['MBRD'];
            $radnikMdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj',$maticniBrojParametar)->first();

            if($radnikMdrData){
                //                $idRadnikaDPSM = $this->mesecnatabelapoentazaInterface->where('maticni_broj', $fiksnaPlacanjaData[0]['MBRD'])->first();

                foreach ($krediti as $kredit){
                    if($kredit['SIFK'] ==''){
//                    var_dump('SIFRA KREDITORA NE POSTOJI');
//                    var_dump($kredit);

                        continue;
                    }

                    $kreditorData = Kreditori::where('sifk_sifra_kreditora',$kredit['SIFK'])->first();
                    if($kreditorData){

                        $data=[
                            'maticni_broj'=>$kredit['MBRD'],
                            'SIFK_sifra_kreditora'=>$kredit['SIFK'],
                            'IMEK_naziv_kreditora'=>$kreditorData->imek_naziv_kreditora,
                            'PART_partija_poziv_na_broj'=>$kredit['PART'],
                            'GLAVN_glavnica'=>(float)$kredit['GLAV'],
                            'SALD_saldo'=>(float)$kredit['SALD'],
                            'RATA_rata'=>(float)$kredit['RATA'],
//                    'RATP_prethodna'=>(float)$kredit['RATP'],
                            'POCE_pocetak_zaduzenja'=>$kredit['POCE']!=='N',
                            'user_mdr_id'=>$radnikMdrData['id'],
//                    'RBZA'=>(float)$kredit['RBZA'],
//                    'RATP'=>(float)$kredit['RATP'],
//                    'RATB'=>(float)$kredit['RATB']
                        ];
                $this->dpsmKreditiInterface->create($data);
                    }else{
                        var_dump('Kreditor ne postoji u bazi: '.$kredit['SIFK']);

                        continue;

                    }

                }
            }else{
                var_dump('Radnik ne postoji u bazi: '.$kredit['MBRD']);

            }


        }






        $this->alert(PHP_EOL.'Fale krediti za ljude sa maticnim:'.count($kreditiKojiFale));

        $this->alert(PHP_EOL.'Fale krediti za ljude sa maticnim:'.json_encode($kreditiKojiFale));
    }

    public function createKrediti($kreditiData){

        foreach ($kreditiData as $kredit){
//            DpsmKrediti::create([]);
        }
    }

    public function updateKrediti($kreditiData){

        foreach ($kreditiData as $kredit){
//            DpsmKrediti::create([]);
        }
    }

    public function checkKreditiData($kreditiData){

        foreach ($kreditiData as $kredit){
            $kreditiBaza =DpsmKrediti::where('maticni_broj',$kredit['MBRD'])->get();

            if($kreditiBaza){
                $kreditPronadjenUbazi=false;
                foreach ($kreditiBaza as $bazaKredit){
                    $test='testt';

                    $sifraKreditora=$bazaKredit['SIFK_sifra_kreditora']; // SIFK
                    $partijaPNB=$bazaKredit['PART_partija_poziv_na_broj']; // PART

                    $sifk = $kredit['SIFK'];
                    $part = $kredit['PART'];

                    if($sifraKreditora==$sifk&& $partijaPNB==$part){
                        $kreditPronadjenUbazi=true;
                        $kreditiZaAzuriranje[]=$kredit;
                    }


                }
                if(!$kreditPronadjenUbazi){
                    $kreditiKojiFale[]=$kredit;
                }
            }else{
                $kreditiKojiFale[]=$kredit['MBRD'];
            }


        }
    }
    public function getKreditiData()
    {
        $filePath = storage_path('app/backup/plata_25_12_2024/MKRE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }

}
