<?php declare(strict_types=1);

namespace App\Modules\Obracunzarada\Repository;

use App\Models\Drzave;
use App\Models\Datotekaobracunskihkoeficijenata;
use App\Repository\BaseRepository;
use Carbon\Carbon;

class DatotekaobracunskihkoeficijenataRepository extends BaseRepository implements DatotekaobracunskihkoeficijenataRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param Datotekaobracunskihkoeficijenata $model
     */
    public function __construct(Datotekaobracunskihkoeficijenata $model)
    {
        parent::__construct($model);
    }

    public function createMesecnatabelapoentaza($array)
    {
        $month = (int)$array['month'];
        $realMonth=$month+1;
        $year =(int)$array['year'];
        $startOfMonth = Carbon::create($year, (int)$realMonth, 1);
        $datumBaza = $startOfMonth->format('Y-m-d');
        $endOfMonthTwo = $startOfMonth->copy()->endOfMonth();

        $dani=$endOfMonthTwo->format('d');
//        $startOfMonth=$startOfM->addMonth();
        $workingDays = $this->calculateWorkingHour($startOfMonth);
        $workingHours= $workingDays * 8;
        $endOfMonth = $startOfMonth->copy()->endOfMonth();
        $data =[
            'kalendarski_broj_dana'=>$dani,
            'mesecni_fond_sati'=>$array['mesecni_fond_sati'],
            'prosecni_godisnji_fond_sati'=>$array['prosecni_godisnji_fond_sati'],
            'cena_rada_tekuci'=>$array['cena_rada_tekuci'],
            'mesecni_fond_sati_praznika'=>$array['mesecni_fond_sati_praznika'],
            'cena_rada_prethodni'=>$array['cena_rada_prethodni'],
            'vrednost_akontacije'=>$array['vrednost_akontacije'],
            'datum'=>$datumBaza,
            'mesec'=>$realMonth,
            'godina'=>$array['year'],
            'status'=> Datotekaobracunskihkoeficijenata::AKTUELAN,
            'period_isplate_od'=>$array['period_isplate_od'],
            'period_isplate_do'=>$array['period_isplate_do']
        ];
       return $this->create($data);
    }

    public function calculateWorkingHour($startOfMonth){

        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $workingDays = 0;

        while ($startOfMonth <= $endOfMonth) {
            if ($startOfMonth->isWeekday()) {
                $workingDays++;
            }

            $startOfMonth->addDay();
        }
        return $workingDays;
    }
    public function updateMesecnatabelapoentaza($array)
    {
        $month = (int)$array['month'];
        $year =$array['year'];
        $startOfMonth = Carbon::create($year, (int)$month, 1);
        $workingDays = $this->calculateWorkingHour($startOfMonth);
        $workingHours= $workingDays * 8;
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $data =[
            'kalendarski_broj_dana'=>$endOfMonth->format('d'),
            'mesecni_fond_sati'=>$workingHours,
            'prosecni_godisnji_fond_sati'=>$array['prosecni_godisnji_fond_sati'],
            'cena_rada_tekuci'=>$array['cena_rada_tekuci'],
            'cena_rada_prethodni'=>$array['cena_rada_prethodni'],
            'vrednost_akontacije'=>$array['vrednost_akontacije'],
            'datum'=>$startOfMonth,
            'mesec'=>$array['month'],
            'godina'=>$array['year'],
            'status'=>1
        ];
        return $this->create($data);
    }


}
