<?php

namespace Database\Seeders;

use App\Models\Datotekaobracunskihkoeficijenata;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmFiksnaPlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmPoentazaslogRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PermesecnatabelapoentRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Service\KreirajObracunskeKoeficiente;
use App\Modules\Obracunzarada\Service\KreirajPermisijePoenteriOdobravanja;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Csv\Reader;

class MartPlataSeeder extends Seeder
{

    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly KreirajObracunskeKoeficiente                        $kreirajObracunskeKoeficiente,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly KreirajPermisijePoenteriOdobravanja                 $kreirajPermisijePoenteriOdobravanja,
        private readonly PermesecnatabelapoentRepositoryInterface            $permesecnatabelapoentInterface,
        private readonly DpsmPoentazaslogRepositoryInterface                 $dpsmPoentazaslogInterface,
        private readonly DpsmFiksnaPlacanjaRepositoryInterface               $dpsmFiksnaPlacanjaInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly VrsteplacanjaRepositoryInterface          $vrsteplacanjaInterface,
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface

    ){
    }

    public function run(): void
    {
        Log::channel('user_action')->debug('Test custom logger START MART');

        var_dump('test');
        $podaciMesec = $this->getDataFromCsvPodaciMesec();

        $varijabilnaP = $this->getDataFromCsvVarijabilnaP();
        $varijabilneVrtsePlacanjaReader = $this->getDataFromCsvFiksnaP();
        $kreditiReader = $this->getDataFromCsvKrediti();
        $monthId = 0;

        foreach ($podaciMesec as $data2) {

            $newDataPodaciMesec[]=$data2;
        }

            $monthData='';

        foreach ($newDataPodaciMesec as $data){
            if ($data['M_G'] == '0324') {
                $test = 'test';

                $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);


                $monthRecord = DB::table('datotekaobracunskihkoeficijenatas')->insert([
                    'kalendarski_broj_dana' => $data['DANI'],
                    'mesecni_fond_sati' => $data['BR_S'],
                    'prosecni_godisnji_fond_sati' => $data['S3'],
                    'cena_rada_tekuci' => $data['C_R'],
                    'mesecni_fond_sati_praznika' => 0,
                    'cena_rada_prethodni' => $data['C_R2'],
                    'vrednost_akontacije' => 0,
                    'datum' => $date->format('Y-m-d'),
                    'mesec'=>$date->month,
                    'godina' =>$date->year,
                    'status' => Datotekaobracunskihkoeficijenata::AKTUELAN,
                    'period_isplate_od' => Carbon::createFromFormat('d/m/Y', $data['DATUM1']),
                    'period_isplate_do' => Carbon::createFromFormat('d/m/Y', $data['DATUM2']),

                ]);

                $monthData = $this->datotekaobracunskihkoeficijenataInterface->where('kalendarski_broj_dana', $data['DANI'])->get()->first();

            }


        }
        if ($monthData) {
            $monthId = $monthData->id;

            $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();

            $podaciRadniciMesec = $this->kreirajObracunskeKoeficiente->otvoriAktivneRadnikeImport($monthData, $varijabilnaP,$vrstePlacanjaSifarnik);
            $resultDatoteka = $this->mesecnatabelapoentazaInterface->createMany($podaciRadniciMesec);


            $resultPMB = $this->kreirajPermisijePoenteriOdobravanja->execute($monthData);
            $resultPermission = $this->permesecnatabelapoentInterface->createMany($resultPMB);
            $idRadnikaZaMesec = $this->mesecnatabelapoentazaInterface->where('obracunski_koef_id', $monthData->id)->select(['id', 'maticni_broj'])->get();

            $variabilnaUpdateData = $this->dpsmPoentazaslogInterface->where('obracunski_koef_id', $monthData->id)->get();

            foreach ($variabilnaUpdateData as $variabilnoP) {
                $idRadnikaDPSM = $this->mesecnatabelapoentazaInterface->where('maticni_broj', $variabilnoP->maticni_broj)->first()->id;
                $variabilnoP->user_dpsm_id = $idRadnikaDPSM;
                $variabilnoP->save();
            }

            foreach ($varijabilneVrtsePlacanjaReader as $vrstaPlacanja) {
                $fiksneVrtsePlacanja[] = $vrstaPlacanja;
            }
            $collectRadnikFiksnaPGroup = collect($fiksneVrtsePlacanja)->groupBy('MBRD');

            foreach ($collectRadnikFiksnaPGroup as $fiksnaPlacanjaData) {
                $test = 'test';
                $radnikMdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj', $fiksnaPlacanjaData[0]['MBRD'])->first()->toArray();
                $idRadnikaDPSM = $this->mesecnatabelapoentazaInterface->where('maticni_broj', $fiksnaPlacanjaData[0]['MBRD'])->first();

                foreach ($fiksnaPlacanjaData as $fpData){
                    $data = [
                        'user_dpsm_id' => $idRadnikaDPSM['id'] ?? null,
                        'sifra_vrste_placanja' => $fpData['RBVP'],
                        'naziv_vrste_placanja' => $vrstePlacanjaSifarnik[$fpData['RBVP']]['naziv_naziv_vrste_placanja'],
                        'sati' => (int) $fpData['SATI'] ?? 0,
                        'iznos' => (float) $fpData['IZNO'] ?? 0,
                        'procenat' => (float) $fpData['PERC'] ?? 0,
                        'user_mdr_id' => $radnikMdrData['id'],
                        'obracunski_koef_id' => $monthData['id'],
                        'maticni_broj'=>$fpData['MBRD'],
                        'status'=>$fpData['STATUS']!=='',
                    ];
                    $this->dpsmFiksnaPlacanjaInterface->create($data);
                }
            }
            $test = "test";









            foreach ($kreditiReader as $kredit) {
                $kreditiReaderdata[] = $kredit;
            }

            $collectRadnikKrediti = collect($kreditiReaderdata)->groupBy('MBRD');

            foreach ($collectRadnikKrediti as $krediti){
                $radnikMdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj', $krediti[0]['MBRD'])->first()->toArray();
//                $idRadnikaDPSM = $this->mesecnatabelapoentazaInterface->where('maticni_broj', $fiksnaPlacanjaData[0]['MBRD'])->first();

                foreach ($krediti as $kredit){
                    if($kredit['SIFK'] ==''){
                        var_dump('SIFRA KREDITORA NE POSTOJI');
                        continue;
                    }
                    $data=[
                        'maticni_broj'=>$kredit['MBRD'],
                        'SIFK_sifra_kreditora'=>$kredit['SIFK'],
                        'PART_partija_poziv_na_broj'=>$kredit['PART'],
                        'GLAVN_glavnica'=>$kredit['GLAV'],
                        'SALD_saldo'=>(float)$kredit['SALD'],
                        'RATA_rata'=>(float)$kredit['RATA'],
                        'RATP_prethodna'=>(float)$kredit['RATP'],
                        'POCE_pocetak_zaduzenja'=>$kredit['POCE']!=='N',
                        'user_mdr_id'=>$radnikMdrData['id'],
                        'RBZA'=>(float)$kredit['RBZA'],
                        'RATP'=>(float)$kredit['RATP'],
                        'RATB'=>(float)$kredit['RATB']
                    ];
                    $this->dpsmKreditiInterface->create($data);
                }

            }
        }

//        'kalendarski_broj_dana'=>$data['DANI']
        // DKOE.csv podaciomesecu
        // DPSM - Varijabilna placanja
        // DFVP - Fiksna placanja slog
        // MKRE -krediti


//        foreach ($datas as $data) {
//            DB::table('podaciofirmis')->insert([
//                'naziv_firme' => $data['Naziv Firme-Skraceni naziv'],
//                'poslovno_ime' => $data['Poslovno_ime'],
//                'skraceni_naziv_firme' => $data['Naziv Firme-Skraceni naziv'],
//                'status' => $data['Status'],
//                'pravna_forma' => $data['Pravna_forma'],
//                'maticni_broj' => $data['maticni_broj'],
//                'datum_osnivanja' => Carbon::createFromFormat('m.d.Y', $data['Datum_osnivanja'])->format('Y-m-d'),
//                'adresa_sedista' => $data['Adresa Sedista'],
////                'opstina_id'=>  $data['Sifra Opstine'],
//                'ulica_broj_slovo' => $data['Ulica i Broj'],
//                'broj_poste' => '11420',
//                'pib' => $data['PIB'],
//                'sifra_delatnosti' => $data['Sifra_delatnosti'],
//                'naziv_delatnosti' => $data['Naziv_delatnosti'],
//                'racuni_u_bankama' => $data['Računi u Bankama'],
//                'adresa_za_prijem_poste' => $data['Adresa za prijem poste'],
//                'adresa_za_prijem_elektronske_poste' => $data['Adresa za Prijem Elektronske Pošte'],
//                'telefon' => $data['Telefon'],
//                'internet_adresa' => $data['Internet Adresa'],
//                'zakonski_zastupnik_ime_prezime' => $data['Zakonski Zastupnik'],
//                'zakonski_zastupnik_funkcija' => $data['Zakonski Zastupnik - Funkcija'],
//                'zakonski_zastupnik_jmbg' => $data['Zakonski Zastupnik - JMBG'],
//                'obaveznik_revizije' => $data['Obaveznik Revizije'],
//                'velicina_po_razvrstavanju' => $data['Velicina Po Razvrstavanju'],
//                'minulirad' => 0.4,
//                'minulirad_aktivan' => true
//            ]);
//        }

        Log::channel('user_action')->debug('Test custom logger END MART');

    }

    public function getDataFromCsvPodaciMesec()
    {
        $filePath = storage_path('app/backup/novo/DKOE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

    public function getDataFromCsvVarijabilnaP()
    {
        $filePath = storage_path('app/backup/novo/DPSM.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

    public function getDataFromCsvFiksnaP()
    {
        $filePath = storage_path('app/backup/novo/DFVP.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

    public function getDataFromCsvKrediti()
    {
        $filePath = storage_path('app/backup/novo/MKRE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(',');
        return $csv;
    }

}
