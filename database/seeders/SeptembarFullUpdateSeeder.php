<?php

namespace Database\Seeders;

use App\Models\Datotekaobracunskihkoeficijenata;
use App\Models\User;
use App\Modules\Obracunzarada\Repository\DatotekaobracunskihkoeficijenataRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmFiksnaPlacanjaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\DpsmKreditiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MesecnatabelapoentazaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class SeptembarFullUpdateSeeder extends Seeder
{
    public function __construct(
        private readonly DatotekaobracunskihkoeficijenataRepositoryInterface $datotekaobracunskihkoeficijenataInterface,
        private readonly MesecnatabelapoentazaRepositoryInterface            $mesecnatabelapoentazaInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface,
        private readonly VrsteplacanjaRepositoryInterface          $vrsteplacanjaInterface,
        private readonly DpsmFiksnaPlacanjaRepositoryInterface               $dpsmFiksnaPlacanjaInterface,
        private readonly DpsmKreditiRepositoryInterface $dpsmKreditiInterface

    )
    {
    }

    public function run(): void
    {
        $DataFromCsvPodaciMesec=$this->getDataFromCsvPodaciMesec();

        foreach ($DataFromCsvPodaciMesec as $data) {
            if ($data['M_G'] == '0924') {
                $test = 'test';

                $date = Carbon::createFromFormat('my', '0924')->startOfMonth()->setDay(1);

                // Prepare the data for update or insert
                $recordData = [
                    'kalendarski_broj_dana' => $data['DANI'],
                    'mesecni_fond_sati' => $data['BR_S'],
                    'prosecni_godisnji_fond_sati' => $data['S3'],
                    'cena_rada_tekuci' => $data['C_R'],
                    'mesecni_fond_sati_praznika' => 0,
                    'cena_rada_prethodni' => $data['C_R2'],
                    'vrednost_akontacije' => 0,
                    'datum' => $date->format('Y-m-d'),
                    'mesec' => $date->month,
                    'godina' => $date->year,
                    'status' => Datotekaobracunskihkoeficijenata::AKTUELAN,
                    'period_isplate_od' => Carbon::createFromFormat('d/m/Y', $data['DATUM1']),
                    'period_isplate_do' => Carbon::createFromFormat('d/m/Y', $data['DATUM2']),
                ];

                // Check if the record already exists
                $existingRecord = DB::table('datotekaobracunskihkoeficijenatas')
                    ->where('kalendarski_broj_dana', $data['DANI'])
                    ->where('mesec', $date->month)
                    ->where('godina', $date->year)
                    ->first();

                if ($existingRecord) {
                    // Update the existing record
                    DB::table('datotekaobracunskihkoeficijenatas')
                        ->where('kalendarski_broj_dana', $data['DANI'])
                        ->where('mesec', $date->month)
                        ->where('godina', $date->year)
                        ->update($recordData);
                } else {
                    // Insert new record if it does not exist
                    DB::table('datotekaobracunskihkoeficijenatas')->insert($recordData);
                }

                // Optionally, get the month data after the operation
                $monthData = $this->datotekaobracunskihkoeficijenataInterface
                    ->where('kalendarski_broj_dana', $data['DANI'])
                    ->first();
            }
        }


        $MinimalneBrutoOsnovice=$this->getMinimalneBrutoOsnovice();

        foreach ($MinimalneBrutoOsnovice as $data) {

            if ($data['M_G'] == '0924') {
                $test2 = 'test';
                $date = Carbon::createFromFormat('my', $data['M_G'])->startOfMonth()->setDay(1);

                // Check if the record already exists
                $existingRecord = DB::table('minimalnebrutoosnovices')
                    ->where('M_G_mesec_dodina', $data['M_G'])
                    ->first();

                // Prepare the data for update or insert
                $recordData = [
                    'M_G_mesec_dodina' => $data['M_G'],
                    'M_G_date' => $date->format('Y-m-d'),
                    'NT1_prosecna_mesecna_zarada_u_republici' => (float) str_replace(",", ".", $data['NT1']),
                    'STOPA2_minimalna_neto_zarada_po_satu' => (float) str_replace(",", ".", $data['STOPA2']),
                    'STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos' => (float) str_replace(",", ".", $data['STOPA6']),
                    'P1_stopa_poreza' => (float) str_replace(",", ".", $data['P1']),
                    'STOPA1_koeficijent_za_obracun_neto_na_bruto' => (float) str_replace(",", "", preg_replace('/,/', '.', $data['STOPA1'], 1)),
                    'NT2_minimalna_bruto_zarada' => (float) str_replace(",", ".", $data['NT2']),
                ];

                if ($existingRecord) {
                    // Update the existing record
                    DB::table('minimalnebrutoosnovices')
                        ->where('M_G_mesec_dodina', $data['M_G'])
                        ->update($recordData);
                } else {
                    // Insert new record if it does not exist
                    DB::table('minimalnebrutoosnovices')->insert($recordData);
                }
            }
        }

$test='test';


        $DataFromCsvFiksnaP = $this->getDataFromCsvFiksnaP();
        $vrstePlacanjaSifarnik = $this->vrsteplacanjaInterface->getAllKeySifra();

// Group data by employee's MBRD
        $fiksneVrtsePlacanja = collect($DataFromCsvFiksnaP)->groupBy('MBRD');

        foreach ($fiksneVrtsePlacanja as $fiksnaPlacanjaData) {
            $employeeMbrd = $fiksnaPlacanjaData[0]['MBRD'];

            // Fetch employee data
            $radnikMdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj', $employeeMbrd)->first();
            if (!$radnikMdrData) {
                var_dump("Employee not found for MBRD: $employeeMbrd");
                continue;
            }

            // Fetch monthly data for the employee
            $idRadnikaDPSM = $this->mesecnatabelapoentazaInterface->where('maticni_broj', $employeeMbrd)->first();
            if (!$idRadnikaDPSM) {
                var_dump("Radnik nije otvoren u mesecnatabelapoentaza MBRD: $employeeMbrd");
                continue;
            }

            // Process each payment type data for the employee
            foreach ($fiksnaPlacanjaData as $fpData) {
                // Prepare the data for insertion
                $data = [
                    'user_dpsm_id' => $idRadnikaDPSM['id'],
                    'sifra_vrste_placanja' => $fpData['RBVP'],
                    'naziv_vrste_placanja' => $vrstePlacanjaSifarnik[$fpData['RBVP']]['naziv_naziv_vrste_placanja'] ?? 'Unknown',
                    'sati' => (int) ($fpData['SATI'] ?? 0),
                    'iznos' => (float) ($fpData['IZNO'] ?? 0),
                    'procenat' => (float) ($fpData['PERC'] ?? 0),
                    'user_mdr_id' => $radnikMdrData['id'],
                    'obracunski_koef_id' => $monthData['id'] ?? null,
                    'maticni_broj' => $fpData['MBRD'],
                    'status' => !empty($fpData['STATUS']),
                ];

                // Insert or log an error if insertion fails
                try {
                    $this->dpsmFiksnaPlacanjaInterface->create($data);
                } catch (\Exception $e) {
                    var_dump("Failed to create payment record for MBRD: $employeeMbrd, Error: " . $e->getMessage());
                }
            }
        }





        $DataFromCsvKrediti=$this->getDataFromCsvKrediti();
// Collect credit data from the reader
        $kreditiReaderdata = [];
        foreach ($DataFromCsvKrediti as $kredit) {
            $kreditiReaderdata[] = $kredit;
        }

// Group data by employee's MBRD
        $collectRadnikKrediti = collect($kreditiReaderdata)->groupBy('MBRD');

        foreach ($collectRadnikKrediti as $krediti) {
            $employeeMbrd = $krediti[0]['MBRD'];

            // Fetch employee data
            $radnikMdrData = $this->maticnadatotekaradnikaInterface->where('MBRD_maticni_broj', $employeeMbrd)->first();
            if (!$radnikMdrData) {
                var_dump("Employee not found for MBRD: $employeeMbrd");
                continue;
            }

            // Process each credit for the employee
            foreach ($krediti as $kredit) {
                // Check if the creditor code is present
                if (empty($kredit['SIFK'])) {
                    var_dump("Missing creditor code (SIFK) for MBRD: $employeeMbrd");
                    continue;
                }

                // Additional data validation checks can be added here
                if (empty($kredit['PART']) || !is_numeric($kredit['GLAV']) || !is_numeric($kredit['SALD'])) {
                    var_dump("Problem sa podacima: maticni=". $kredit['MBRD'].' SIFK='.$kredit['SIFK']);
                    continue;
                }

                // Prepare the data for insertion
                $data = [
                    'maticni_broj' => $kredit['MBRD'],
                    'SIFK_sifra_kreditora' => $kredit['SIFK'],
                    'PART_partija_poziv_na_broj' => $kredit['PART'],
                    'GLAVN_glavnica' => (float)$kredit['GLAV'],
                    'SALD_saldo' => (float)$kredit['SALD'],
                    'RATA_rata' => (float)$kredit['RATA'],
                    'RATP_prethodna' => (float)$kredit['RATP'],
                    'POCE_pocetak_zaduzenja' => $kredit['POCE'] !== 'N', // Convert to boolean
                    'user_mdr_id' => $radnikMdrData->id,
                    'RBZA' => (float)$kredit['RBZA'] ?? 0,
                    'RATP' => (float)$kredit['RATP'] ?? 0,
                    'RATB' => (float)$kredit['RATB'] ?? 0
                ];

                // Insert the record into the database
                try {
                    $this->dpsmKreditiInterface->create($data);
                } catch (\Exception $e) {
                    var_dump("Failed to create credit record for MBRD: $employeeMbrd, Error: " . $e->getMessage());
                }
            }
        }



    }

//DFVP.csv
//DKOE.csv
//MKRE.csv
    public function getDataFromCsvPodaciMesec()
    {
        $filePath = storage_path('app/backup/mts_server_priprema_14_10_2024/DKOE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
    public function getDataFromCsvFiksnaP()
    {
        $filePath = storage_path('app/backup/mts_server_priprema_14_10_2024/DFVP.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }

    public function getDataFromCsvKrediti()
    {
        $filePath = storage_path('app/backup/mts_server_priprema_14_10_2024/MKRE.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }

    public function getMinimalneBrutoOsnovice(){
        $filePath = storage_path('app/backup/mts_server_priprema_14_10_2024/DNTO.csv');
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);
        $csv->setDelimiter(';');
        return $csv->getRecords();
    }
}
