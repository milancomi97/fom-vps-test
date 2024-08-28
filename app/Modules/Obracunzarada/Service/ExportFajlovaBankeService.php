<?php

namespace App\Modules\Obracunzarada\Service;

use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaDarhObradaSveDkopRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ObradaDkopSveVrstePlacanjaRepositoryInterface;

class ExportFajlovaBankeService
{

    public const BANKEIDS = [
        992 => 'RAIFFEISEN',
        980 => 'DIREKTNAEURO',
        930 => 'INTESA',
        910 => 'OTP',
        920 =>'POSTANSKASTEDIONICA',
        997=>'UNICREDIT',
        991=>'KOMERCIJALNA'
    ];

    public function __construct(
        private readonly IsplatnamestaRepositoryInterface           $isplatnamestaInterface,
        private readonly RadnamestaRepositoryInterface              $radnamestaInterface,
        private readonly StrucnakvalifikacijaRepositoryInterface    $strucnakvalifikacijaInterface,
        private readonly ArhivaDarhObradaSveDkopRepositoryInterface $arhivaDarhObradaSveDkopInterface,
    )
    {
    }

    public function exportRaiffeisen($groupItems,$bankKey,$bankName)
    {
        $txtContent = '';
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

        return ['data'=>$txtContent,'fileName'=>$bankName];
    }

    public function exportDirektnaEuro($groupItems,$bankKey,$bankName)
    {
        $txtContent = '';
        foreach ($groupItems as $item) {
            $formattedLine = str_pad('0000000000000000', 16);  // 16 mesta sve nule
            $formattedLine .= str_pad('941', 3);               // 3 mesta šifra valute

            $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '.', '');
            $formattedLine .= str_pad($amount, 16, ' ', STR_PAD_LEFT);  // 16 mesta iznos

            $date = now()->format('dmy');                     // 6 mesta datum valute (ddmmyy)
            $formattedLine .= str_pad($date, 6);

            $fullName = $item->ime . ' ' . $item->prezime;
            $formattedLine .= str_pad(substr($fullName, 0, 30), 30);  // 30 mesta ime i prezime

//            $accountNumber = substr($item->ZRAC_tekuci_racun, 4, 13); // 13 mesta broj partije // TODO Pogledati ovo

            $accountNumber = substr($item->ZRAC_tekuci_racun, 0, 13); // 13 mesta broj partije


            $formattedLine .= str_pad($accountNumber, 13);

            $txtContent .= $formattedLine . "\n";
        }

        return ['data'=>$txtContent,'fileName'=>$bankName];

    }

    public function exportIntesa($groupItems,$bankKey,$bankName)
    {
        $txtContent = '';
        $companyId = '0042613019';
        $transactionDate = now()->format('d.m.Y');  // Datum u formatu dd.mm.yyyy

        foreach ($groupItems as $item) {
            $accountNumber =$item->ZRAC_tekuci_racun;

            $newAccountNumber = '';
            $accountParts = explode("-", $accountNumber);
            if(count($accountParts)==3){
                foreach ($accountParts as $key=> $part){
                    if($key==2){
                        $newPart= str_replace('/', '',$part);
                        if(strlen($part)<8){
                            $newPart=str_pad($newPart, 8, '0', STR_PAD_LEFT);
                        }
                        $newAccountNumber.=$newPart;
                    }else{
                        $newAccountNumber.=$part;
                    }
                }
            }elseif(count($accountParts)==4){
                $newAccountNumber.=implode('',$accountParts);
            }else{
                $greska='greska';
            }


            // Iznos priliva, formatiran bez decimalnih separatora
            $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu * 100, 0, '', '');  // Pomnoženo sa 100 da se uklone decimale

            if($amount==0){
                $amount='000';
            }
            $amount = str_pad($amount, 25, ' ', STR_PAD_LEFT);  // Iznos priliva poravnat desno

            // Opis priliva
//            $description = str_pad('Zarada za ' . $transactionDate, 44);
            $description = str_pad('PLATA', 44);

            // Kreiranje jednog sloga
            $formattedLine = $companyId . $transactionDate . $newAccountNumber . $amount . $description;

            $txtContent .= $formattedLine . "\n";
        }

//// Ukupan slog (sumarni slog na kraju)
//        $totalAmount = $groupItems->sum(function ($item) {
//            return (int)($item->UKIS_ukupan_iznos_za_izplatu * 100);
//        });
//        $summaryLine = $companyId . $transactionDate . str_repeat(' ', 13) . str_pad($totalAmount, 25, ' ', STR_PAD_LEFT) . str_repeat(' ', 44);
//        $txtContent .= $summaryLine . "\n";

        $prefix = 'PL';
        $companyName = 'YOURCOMPANY';
        $fileNumber = '01';
        $paymentType = 'PLATA';
        $fileDate = now()->format('dmY');

        $fileName = "{$prefix}{$companyName}{$fileNumber}{$paymentType}{$fileDate}.txt";

        return ['data'=>$txtContent,'fileName'=>$bankName];

    }


    public function exportOtp($groupItems,$bankKey,$bankName)
    {
        $txtContent = '';

        foreach ($groupItems as $item) {
            // 3 prazna mesta
            $formattedLine = str_pad('', 3);

            // Partija (broj računa) - 18 mesta
            $accountNumber = str_pad($item->ZRAC_tekuci_racun, 18, ' ', STR_PAD_RIGHT);
            $formattedLine .= $accountNumber;

            // Neto iznos - 15 mesta, poravnat desno
            $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '.', '');  // Format sa 2 decimalna mesta
            $formattedLine .= str_pad($amount, 15, ' ', STR_PAD_LEFT);

            // Ime i prezime - 56 mesta
            $fullName = strtoupper($item->ime . ' ' . $item->prezime);  // Velika slova za ime i prezime
            $formattedLine .= str_pad(substr($fullName, 0, 56), 56, ' ', STR_PAD_RIGHT);

            // Indikator banke - 1 mesto
            $formattedLine .= 'C';

            // Dodaj red u fajl
            $txtContent .= $formattedLine . "\n";
        }

        return ['data'=>$txtContent,'fileName'=>$bankName];
    }

    public function exportPostanskaStedionica($groupItems,$bankKey,$bankName)
    {
//        920 =>'POSTANSKASTEDIONICA',

        $txtContent = '';

        // Generisanje pojedinačnih zapisa
        foreach ($groupItems as $item)
        {
            // Kontrola - uvek 0
        $formattedLine = '';

            // Broj računa - 18 karaktera
            $brojRacuna = $item->ZRAC_tekuci_racun;
            $duzinaBrojaRacuna = strlen($item->ZRAC_tekuci_racun);

            if($duzinaBrojaRacuna==8){
                $brojRacuna = '200'.$brojRacuna;

            }elseif($duzinaBrojaRacuna==9){
                $brojRacuna = '20'.$brojRacuna;
            } elseif($duzinaBrojaRacuna==7){
                $brojRacuna= '2000'.$brojRacuna;
            }else{
                $test='greska';

            }


        $formattedLine .= $brojRacuna;

            // Matični broj vlasnika - 13 karaktera
//        $ownerId = str_pad($item->maticni_broj, 13, ' ', STR_PAD_RIGHT);
//        $formattedLine .= $ownerId;

            // Iznos - 24 karaktera, desno poravnat, 2 decimalna mesta
        $amount = str_replace('.', '', $item->UKIS_ukupan_iznos_za_izplatu);
        $formattedLine .= str_pad($amount, 17, '0', STR_PAD_LEFT);

            // Opis (opciono) - 80 karaktera
//        $description = str_pad('Opis transakcije', 80, ' ', STR_PAD_RIGHT);
//        $formattedLine .= $description;

            // Dodaj red u fajl
        $txtContent .= $formattedLine . "\n";
        }

        // Generisanje kontrolnog zapisa
        $totalAmount = number_format($groupItems->sum(function ($item) {
            return $item->UKIS_ukupan_iznos_za_izplatu;
        }), 2, '.', '');

        $controlLine = '1';  // Kontrola
        $companyAccount = str_pad('123456789012345678', 18, ' ', STR_PAD_RIGHT);  // Broj računa preduzeća (primer)
        $companyId = str_pad('1234567890123', 13, ' ', STR_PAD_RIGHT);  // Matični broj preduzeća (primer)
        $totalRecords = str_pad(count($groupItems), 6, '0', STR_PAD_LEFT);  // Broj zapisa
        $controlLine .= $companyAccount . $companyId . $totalRecords;
        $controlLine .= str_pad($totalAmount, 24, '0', STR_PAD_LEFT);

        // Datum formiranja - 8 karaktera
        $controlLine .= now()->format('dmY');

        // Vreme formiranja - 6 karaktera
        $controlLine .= now()->format('His');

        // Dodaj kontrolni slog u fajl
        $txtContent .= $controlLine . "\n";

        return ['data'=>$txtContent,'fileName'=>$bankName];
    }

    public function exportUnicredit($groupItems,$bankKey,$bankName){
        $txtContent = '';

        foreach ($groupItems as $item) {
            // Broj računa - 20 karaktera
            $accountNumber = str_pad($item->ZRAC_tekuci_racun, 20, ' ', STR_PAD_RIGHT);

            // Iznos - 15 karaktera, desno poravnat sa dve decimale
            $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '.', '');
            $formattedAmount = str_pad($amount, 15, ' ', STR_PAD_LEFT);

            // Ime - 20 karaktera, levo poravnat
            $firstName = str_pad($item->ime, 20, ' ', STR_PAD_RIGHT);

            // Prezime - 20 karaktera, levo poravnat
            $lastName = str_pad($item->prezime, 20, ' ', STR_PAD_RIGHT);

            // Kombinovanje linije
            $formattedLine = $accountNumber . $formattedAmount . $firstName . $lastName;

            // Dodaj red u fajl
            $txtContent .= $formattedLine . "\n";
        }

        return ['data'=>$txtContent,'fileName'=>$bankName];
    }

    public function exportKomercijalna($groupItems,$bankKey,$bankName){

        $txtContent = '';

        foreach ($groupItems as $item) {
            // Broj računa (sa prefiksom) - 19 karaktera
            $accountNumber =$item->ZRAC_tekuci_racun;

            $newAccountNumber = '';
            $accountParts = explode("-", $accountNumber);
            if(count($accountParts)==3){

                $test='test';
                foreach ($accountParts as $key => $part) {
                    $newPart='';
                    if ($key == 0) {
                        $test = 'test';
                        if ($part == '205') {
                            $newPart = '000';
                        }
                    }
                    if ($key == 1) {

                        $pattern = "/^100/";

                        if (preg_match($pattern, $part)) {

                            $newPart=preg_replace($pattern, "000", $part);

                        }else{
                            $newPart=$part;

                        }
                    }
                    if ($key == 2) {

                        $test='test';
                    }

                    $newAccountNumber.=$newPart;



                }
//                        $newPart= str_replace('/', '',$part);
//                        if(strlen($part)<8){
//                            $newPart=str_pad($newPart, 8, '0', STR_PAD_LEFT);
//                        }
//                        $newAccountNumber.=$newPart;
//                    }else{
//                        $newAccountNumber.=$part;
//                    }
//                }
            }elseif(count($accountParts)==1) {

                $partOne = $accountParts[0];
                if(str_starts_with($partOne, "205")){
                    $partOne = substr_replace($partOne, "000", 0, 3);
                }

                if(substr($partOne, 3, 3) === "100"){
                    $partOne = substr_replace($partOne, "000", 3, 3);
                }

                $newAccountNumber = str_pad($partOne, 13, '0', STR_PAD_LEFT) .'941';

                $test='test';

            }elseif(count($accountParts)==2) {

                if($accountParts[0]=='205'){
                    $partOne = '000';
                }else{
                    $partOne = $accountParts[0];

                }


                $pattern = "/^100/";

                if (preg_match($pattern, $accountParts[1])) {

                    $partTwo=preg_replace($pattern, "000", $accountParts[1]);


                }else{
                    $partTwo=$accountParts[1];

                }
                if (strlen($partTwo) > 2) {
                    // Remove the last two characters
                    $partTwo = substr($partTwo, 0, -2);
                }

                $newPart = $partOne.$partTwo.'941';

                $newAccountNumber = str_pad($newPart, 19, '0', STR_PAD_LEFT);

                $test='test';
            }elseif(count($accountParts)==4){
                $newAccountNumber.=implode('',$accountParts);
            }else{
                $greska='greska';
            }


            if(strlen($newAccountNumber) <19){
                $newAccountNumber = str_pad($newAccountNumber, 19, '0', STR_PAD_LEFT);

            }
            // Šifra valute - 3 karaktera
            $currencyCode = '941';

            // Iznos - 16 karaktera, desno poravnat sa dve decimale
            $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '.', '');
            $formattedAmount = str_pad($amount, 16, ' ', STR_PAD_LEFT);

            // Datum valute - 6 karaktera (ddmmyy format)
            $valueDate = now()->format('dmy');

            // Ime i prezime - 40 karaktera, poravnat levo
            $fullName = strtoupper($item->prezime . ' ' . $item->ime);
            $formattedName = str_pad(substr($fullName, 0, 40), 40, ' ', STR_PAD_RIGHT);

            // Opis transakcije - 10 karaktera, poravnat levo
            $description = str_pad('Plata', 10, ' ', STR_PAD_RIGHT);

            // Kombinovanje linije
            $formattedLine = $newAccountNumber.' ORIG:'.$item->ZRAC_tekuci_racun . $currencyCode . $formattedAmount . $valueDate . $formattedName . $description;

            // Dodaj red u fajl
            $txtContent .= $formattedLine . "\n";
        }

        return ['data'=>$txtContent,'fileName'=>$bankName];
    }
}
