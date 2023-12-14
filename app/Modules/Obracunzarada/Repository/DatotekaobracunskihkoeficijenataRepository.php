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
        $year =$array['year'];
        $startOfMonth = Carbon::create($year, (int)$month, 1);
        $workingDays = $this->calculateWorkingHour($startOfMonth);
        $workingHours= $workingDays * 8;
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $data =[
            'kalendarski_broj_data'=>$endOfMonth->format('d'),
            'mesecni_fond_sati'=>$workingHours,
            'prosecni_godisnji_fond_sati'=>$array['prosecni_godisnji_fond_sati'],
            'cena_rada_tekuci'=>$array['cena_rada_tekuci'],
            'cena_rada_prethodni'=>$array['cena_rada_prethodni'],
            'datum'=>$startOfMonth,
            'status'=>1
        ];
        // TODO: Implement createMesecnatabelaPoentaza() method.
       return $this->create($data);
    }

    public function calculateWorkingHour($startOfMonth){

        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $workingDays = 0;

        while ($startOfMonth <= $endOfMonth) {
            // Check if the day is a working day (Monday to Friday)
            if ($startOfMonth->isWeekday()) {
                $workingDays++;
            }

            $startOfMonth->addDay();
        }
        return $workingDays;
    }
}
