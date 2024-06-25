<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\Obracunzarada\Repository\ArhivaDarhObradaSveDkopRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaMaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaSumeZaraPoRadnikuRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MaticnadatotekaradnikaRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class ArhivaController extends Controller
{

    public function __construct(
        private readonly ArhivaMaticnadatotekaradnikaRepositoryInterface $arhivaMaticnadatotekaradnikaInterface,
        private readonly ArhivaSumeZaraPoRadnikuRepositoryInterface $arhivaSumeZaraPoRadnikuInterface,
        private readonly ArhivaDarhObradaSveDkopRepositoryInterface $arhivaDarhObradaSveDkopInterface,
        private readonly MaticnadatotekaradnikaRepositoryInterface $maticnadatotekaradnikaInterface
    ){
    }



    public function index(Request $request)
    {

        $radniciSelectData=[];
       $data = $this->maticnadatotekaradnikaInterface->getAll();

       foreach ($data as $radnik){
           $test='test';
           $radniciSelectData[]=['id'=>$radnik->MBRD_maticni_broj ,'text'=>$radnik->MBRD_maticni_broj.' '. $radnik->PREZIME_prezime .' '.  $radnik->srednje_ime.' '.  $radnik->IME_ime];
       }

       $test='test';
        return view('obracunzarada::arhiva.arhiva_index',['radniciSelectData'=>$radniciSelectData]);
    }

    public function mesec(Request $request)
    {


        $arhiva_datum=$request->arhiva_datum;

        return view('obracunzarada::arhiva.arhiva_mesec',['arhiva_datum'=>$arhiva_datum]);
    }

    public function radnik(Request $request)
    {


        return view('obracunzarada::arhiva.arhiva_radnik');
    }

    public function arhivaMaticneDatoteke(Request $request)
    {
        $maticniBroj = $request->maticniBroj;
        $datum = $request->datum;

// Parse the input date to get the start and end of the month
        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();
        $startDate = $startOfMonth->format('Y-m-d');

// Retrieve records using Eloquent
        $arhivaMdr =$this->arhivaMaticnadatotekaradnikaInterface->where('M_G_date', $startDate)->where('MBRD_maticni_broj',$maticniBroj)->get();

//        $arhivaMaticnadatotekaradnikaInterface
//        $arhivaSumeZaraPoRadnikuInterface
//        $arhivaDarhObradaSveDkopInterface
        return view('obracunzarada::arhiva.arhiva_maticne_datoteke',['arhivaMdr'=>$arhivaMdr]);
    }
    public function obracunskeListe(Request $request)
    {
        $maticniBroj = $request->maticniBroj;
        $datum = $request->datum;
        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();
        $startDate = $startOfMonth->format('Y-m-d');
        $zaraData =$this->arhivaSumeZaraPoRadnikuInterface->where('M_G_date', $startDate)->where('maticni_broj',$maticniBroj)->get();
        $dkopData = $this->arhivaDarhObradaSveDkopInterface->where('M_G_date', $startDate)->where('maticni_broj',$maticniBroj)->get();

        $test='test';
        return view('obracunzarada::arhiva.obracunske_liste',['zaraData'=>$zaraData,'dkopData'=>$dkopData]);
    }
    public function ukupnaRekapitulacija(Request $request)
    {
        $datum = $request->datum;
        $startOfMonth = Carbon::createFromFormat('m.Y', $datum)->startOfMonth();

        $startDate = $startOfMonth->format('Y-m-d');

        $zaraData =$this->arhivaSumeZaraPoRadnikuInterface->where('M_G_date', $startDate)->get();

        return view('obracunzarada::arhiva.ukupna_rekapitulacija',['zaraData'=>$zaraData]);
    }

    public function potvrdaProseka(Request $request)
    {

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;

        return view('obracunzarada::arhiva.potvrda_proseka');
    }

    public function godisnjiKarton(Request $request)
    {

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;
        return view('obracunzarada::arhiva.godisnji_karton');
    }

    public function pppPrijava(Request $request)
    {

        $maticniBroj = $request->maticniBroj;
        $datumOd = $request->datumOd;
        $datumDo = $request->datumDo;
        return view('obracunzarada::arhiva.ppp_prijava');
    }

}
