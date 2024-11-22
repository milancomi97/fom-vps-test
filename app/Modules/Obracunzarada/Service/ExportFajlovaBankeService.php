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
            $tekuciRacun=$item->maticnadatotekaradnika->ZRAC_tekuci_racun;

            $tekuciRacunFormated= str_replace("-", "",$tekuciRacun);
            $jmbg=$item->LBG_jmbg;
            $amount= $item->UKIS_ukupan_iznos_za_izplatu;
            $salary = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '', ''); // Salary with 2 decimals

            $formattedAmount = str_pad($salary, 19, "0", STR_PAD_LEFT); // Pad to 19 characters with leading zeros

            $line =$tekuciRacunFormated.'  '.$jmbg.$formattedAmount;
            $txtContent.=$line. "\n";
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
        $fixedText = "PLATA"; // Fixed text

        foreach ($groupItems as $item) {

            $tekuciRacun=$item->maticnadatotekaradnika->ZRAC_tekuci_racun;
            $tekuciRacunFormated= str_replace("-", "",$tekuciRacun);
            $account = str_pad($tekuciRacunFormated, 30, " ", STR_PAD_RIGHT); // Account padded to 30 characters

            $salary = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '', ''); // Salary with 2 decimals

            $salary = str_pad($salary, 15, " ", STR_PAD_LEFT); // Salary padded to 15 characters
            $fixedTextPadded = str_pad($fixedText, 50, " ", STR_PAD_RIGHT); // Fixed text padded to 50 characters

            // Combine all parts to form the line
            $line = $companyId . $transactionDate . $account . $salary . $fixedTextPadded;
            $txtContent .= $line . PHP_EOL;
        }


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
        $outputContent = '';
        foreach ($groupItems as $item) {
            $line = str_pad('', 3);

            $accountFormatted= str_replace("-", "",$item->maticnadatotekaradnika->ZRAC_tekuci_racun);
            $account = str_pad($accountFormatted, 20, " ", STR_PAD_RIGHT); // Account padded to 20 characters

            $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '.', ''); // Salary with 2 decimals
            $amount = str_pad($amount, 15, " ", STR_PAD_LEFT); // Amount padded to 15 characters (left-aligned for numbers)
            $name = str_pad($item->ime.'  '.$item->prezime, 50, " ", STR_PAD_RIGHT); // Name padded to 50 characters
            $fixedChar = "C"; // Fixed character

            // Combine all parts to form the line
            $line .= $account . $amount . $name . $fixedChar;

            // Append the line to the output content with a line break
            $outputContent .= $line . PHP_EOL;
        }
//        foreach ($groupItems as $item) {
//            // 3 prazna mesta
//            $formattedLine = str_pad('', 3);
//
//            // Partija (broj računa) - 18 mesta
//            $accountNumber = str_pad($item->ZRAC_tekuci_racun, 18, ' ', STR_PAD_RIGHT);
//            $formattedLine .= $accountNumber;
//
//            // Neto iznos - 15 mesta, poravnat desno
//            $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '.', '');  // Format sa 2 decimalna mesta
//            $formattedLine .= str_pad($amount, 15, ' ', STR_PAD_LEFT);
//
//            // Ime i prezime - 56 mesta
//            $fullName = strtoupper($item->ime . ' ' . $item->prezime);  // Velika slova za ime i prezime
//            $formattedLine .= str_pad(substr($fullName, 0, 56), 56, ' ', STR_PAD_RIGHT);
//
//            // Indikator banke - 1 mesto
//            $formattedLine .= 'C';
//
//            // Dodaj red u fajl
//            $txtContent .= $formattedLine . "\n";
//        }

        return ['data'=>$outputContent,'fileName'=>$bankName];
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
        $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu,2,'','');
        $formattedLine .= str_pad($amount, 17, '0', STR_PAD_LEFT);

            // Opis (opciono) - 80 karaktera
//        $description = str_pad('Opis transakcije', 80, ' ', STR_PAD_RIGHT);
//        $formattedLine .= $description;

            // Dodaj red u fajl
        $txtContent .= $formattedLine . "\n";
        }

//        // Generisanje kontrolnog zapisa
//        $totalAmount = number_format($groupItems->sum(function ($item) {
//            return $item->UKIS_ukupan_iznos_za_izplatu;
//        }), 2, '.', '');
//
//        $controlLine = '1';  // Kontrola
//        $companyAccount = str_pad('123456789012345678', 18, ' ', STR_PAD_RIGHT);  // Broj računa preduzeća (primer)
//        $companyId = str_pad('1234567890123', 13, ' ', STR_PAD_RIGHT);  // Matični broj preduzeća (primer)
//        $totalRecords = str_pad(count($groupItems), 6, '0', STR_PAD_LEFT);  // Broj zapisa
//        $controlLine .= $companyAccount . $companyId . $totalRecords;
//        $controlLine .= str_pad($totalAmount, 24, '0', STR_PAD_LEFT);
//
//        // Datum formiranja - 8 karaktera
//        $controlLine .= now()->format('dmY');
//
//        // Vreme formiranja - 6 karaktera
//        $controlLine .= now()->format('His');
//
//        // Dodaj kontrolni slog u fajl
//        $txtContent .= $controlLine . "\n";

        return ['data'=>$txtContent,'fileName'=>$bankName];
    }

    public function exportUnicredit($groupItems,$bankKey,$bankName){
        $txtContent = '';

        foreach ($groupItems as $item) {

            // Broj računa - 21 karaktera
            $accountFormatted= str_replace("-", "",$item->maticnadatotekaradnika->ZRAC_tekuci_racun);

            $account = str_pad($accountFormatted, 21, " ", STR_PAD_RIGHT); // Account padded to 21 characters

            // 10 spaces after account
//            $account .= str_repeat(" ", 10);

            // Iznos - 12 karaktera
            $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '.', ''); // Format amount with 2 decimals
            $amount = str_pad($amount, 12, " ", STR_PAD_LEFT); // Amount padded to 12 characters

            // Ime - 20 karaktera
            $firstName = str_pad($item->ime, 20, " ", STR_PAD_RIGHT); // First name padded to 20 characters

            // Prezime - 20 karaktera
//            $lastName = str_pad($item->prezime, 20, " ", STR_PAD_RIGHT); // Last name padded to 20 characters

            // Combine all parts to form the line (NO space between amount and firstName)
            $line = $account . $amount .'    '. $firstName . $item->prezime;

            // Append to txt content with a newline
            $txtContent .= $line . PHP_EOL;
        }
        return ['data'=>$txtContent,'fileName'=>$bankName];
    }

    public function exportKomercijalna($groupItems,$bankKey,$bankName){

        $txtContent = '';

        foreach ($groupItems as $item) {
            // Broj računa - 20 karaktera

            $accountFormatted=str_replace("205-", "000",$item->ZRAC_tekuci_racun);

            if (substr($accountFormatted, 3, 3) === '100') {
                // Replace '100' with '000'
                $account = substr_replace($accountFormatted, '000', 3, 3);
            }else{
                $account=$accountFormatted;
            }
            $account = substr_replace($account, '941', -3);

            $account = str_pad($account, 20, " ", STR_PAD_RIGHT); // Account padded to 20 characters

            // 8 spaces after account
            $account .= str_repeat(" ", 8);

            // Iznos - 10 karaktera
            $amount = number_format($item->UKIS_ukupan_iznos_za_izplatu, 2, '.', ''); // Format amount with 2 decimals
            $amount = str_pad($amount, 10, " ", STR_PAD_LEFT); // Amount padded to 10 characters
            // Datum or code
            $dateCode = date("dmy"); // Dynamic date in `ddmmyy` format
            // Ime i prezime - 40 karaktera
            $fullName = $item->prezime . " " . $item->ime; // Combine last name and first name
            $fullName = str_pad($fullName, 40, " ", STR_PAD_RIGHT); // Full name padded to 40 characters

            // Fixed string 'Plata' - 6 characters
            $fixedText = str_pad("Plata", 5, " ", STR_PAD_RIGHT); // Fixed text padded to 6 characters
            // Combine all parts to form the line
            $line = $account . $amount . $dateCode . $fullName . $fixedText;
            // Append to txt content with a newline
            $txtContent .= $line . PHP_EOL;
        }

        return ['data'=>$txtContent,'fileName'=>$bankName];
    }
}
