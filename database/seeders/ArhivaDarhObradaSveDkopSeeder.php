<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ArhivaDarhObradaSveDkopSeeder extends Seeder
{
    public function __construct(
        private readonly VrsteplacanjaRepositoryInterface                    $vrsteplacanjaInterface,
    )
    {

    }

    public function run(): void
    {
        $datas = $this->getDataFromCsv();
//        RBVP;PERC;SATI;IZNO;SLOV;
//KESC;POK2;SIFK;SALD;RBRM;RBPS;P_R;KOEF;REC;GRAD;KPREB;LPREB;STSALD;
//RATP;RATB;HKMB;RBTC;PART;MRBTC;NAZI
        // TODO RBPS,REC,KPREB,GRAD,LPREB
        $sifarnikVrstePlacanja = $this->vrsteplacanjaInterface->getAllKeySifra();

        foreach ($datas as $data) {
            $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);

            DB::table('arhiva_darh_obrada_sve_dkops')->insert([
                'M_G_mesec_godina' =>$data['M_G'],
                'M_G_date' =>$date->format('Y-m-d'),
                'maticni_broj'=>$data['MBRD'],
                'sifra_vrste_placanja'=>$data['RBVP'],
                'naziv_vrste_placanja'=>isset($sifarnikVrstePlacanja[$data['RBVP']]) ? $sifarnikVrstePlacanja[$data['RBVP']]['naziv_naziv_vrste_placanja']: 'SIFRA NE POSTOJI U TRENUTNOM SIFARNIKU',
                'SLOV_grupa_vrste_placanja'=>$data['SLOV'],
                'sati'=>$data['SATI'],
                'iznos'=>$data['IZNO'],
                'procenat'=>$data['PERC'],
                'SALD_saldo'=>$data['SALD'],
                'POK2_obracun_minulog_rada'=>$data['POK2'],
                'KOEF_osnovna_zarada'=>$data['KOEF'],
                'RBRM_radno_mesto'=>$data['RBRM'],
                'KESC_prihod_rashod_tip'=>$data['KESC'],
                'P_R_oblik_rada'=>$data['P_R'],
//                'RBIM_isplatno_mesto_id'=>$data['DATAAA'], // TODO ??????? Da li je potrebno
//                'troskovno_mesto_id'=>$data['DATAAA'], // TODO ??????? Da li je potrebno
//                'organizaciona_celina_id'=>$data['DATAAA'], // TODO ??????? Da li je potrebno
                'SIFK_sifra_kreditora'=>$data['SIFK'],
                'STSALD_Prethodni_saldo'=>$data['STSALD'],
//                'NEAK_neopravdana_akontacija'=>$data['DATAAA'], // TODO ??????? Da li je potrebno
                'PART_partija_kredita'=>$data['PART'],
//                'POROSL_poresko_oslobodjenje'=>$data['DATAAA'], // TODO ??????? Da li je potrebno
//                'obracunski_koef_id'=>$data['DATAAA'], // TODO ??????? Da li je potrebno
//                'user_dpsm_id'=>$data['DATAAA'], // TODO ??????? Da li je potrebno
//                'user_mdr_id'=>$data['DATAAA'], // TODO ??????? Da li je potrebno
//                'tip_unosa'=>$data['DATAAA'], // TODO ??????? Da li je potrebno
                ]);
        }

    }



    public function getDataFromCsv()
    {
        $filePath = storage_path('app/backup/arhiva/DARH.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv;
    }
}
