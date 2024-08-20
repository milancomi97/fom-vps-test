<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaDarhObradaSveDkopRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;

class ExportFajlovaBankeService
{

    public const BANKEIDS=[
        992=>'RAIFFEISEN',
        980=>'DIREKTNAEURO'

    ];

    public function __construct(
        private readonly IsplatnamestaRepositoryInterface $isplatnamestaInterface,
        private readonly RadnamestaRepositoryInterface $radnamestaInterface,
        private readonly StrucnakvalifikacijaRepositoryInterface $strucnakvalifikacijaInterface,
        private readonly ArhivaDarhObradaSveDkopRepositoryInterface $arhivaDarhObradaSveDkopInterface,
    )
    {
    }

    public function exportRaiffeisen($groupItems)
    {
        return '';

    }

    public function exportDirektnaEuro($groupItems){
        $txtContent='';
            foreach ($groupItems as $item) {
                $formattedLine = str_pad('0000000000000000', 16);  // 16 mesta sve nule
                $formattedLine .= str_pad('941', 3);               // 3 mesta šifra valute

                $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '.', '');
                $formattedLine .= str_pad($amount, 16, ' ', STR_PAD_LEFT);  // 16 mesta iznos

                $date = now()->format('dmy');                     // 6 mesta datum valute (ddmmyy)
                $formattedLine .= str_pad($date, 6);

                $fullName = $item->ime . ' ' . $item->prezime;
                $formattedLine .= str_pad(substr($fullName, 0, 30), 30);  // 30 mesta ime i prezime

                $accountNumber = substr($item->ZRAC_tekuci_racun, 4, 13); // 13 mesta broj partije
                $formattedLine .= str_pad($accountNumber, 13);

                $txtContent .= $formattedLine . "\n";
            }

        return $txtContent;

    }

}
