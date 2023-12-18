<?php

namespace App\Modules\Obracunzarada\Service;


class UpdateNapomena
{
    public function __construct(
    )
    {
    }

    public function execute($radnikEvidencija,$input_key,$input_value){


        $userName = auth()->user()->ime .' '. auth()->user()->prezime;
        $currentDate = date('d.m.Y');
        $oldNapomena = $radnikEvidencija->napomena;
        $newNapomena = $input_value .' - '.$userName . ' : '.$currentDate;

        if($oldNapomena){
            $radnikEvidencija->napomena = $oldNapomena .' <br>'. $newNapomena;
        }else{
            $radnikEvidencija->napomena = $newNapomena;
        }
        return $radnikEvidencija->save();
        }
}
