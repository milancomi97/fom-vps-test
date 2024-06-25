<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;

use App\Modules\Obracunzarada\Repository\ArhivaDarhObradaSveDkopRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaMaticnadatotekaradnikaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\ArhivaSumeZaraPoRadnikuRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class ArhivaController extends Controller
{

    public function __construct(
        private readonly ArhivaMaticnadatotekaradnikaRepositoryInterface $arhivaMaticnadatotekaradnikaInterface,
        private readonly ArhivaSumeZaraPoRadnikuRepositoryInterface $arhivaSumeZaraPoRadnikuInterface,
        private readonly ArhivaDarhObradaSveDkopRepositoryInterface $arhivaDarhObradaSveDkopInterface
    ){
    }



    public function index(Request $request)
    {

        return view('obracunzarada::arhiva.arhiva_index');
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
        $maticniBroj = $request->maticniBroj;
        $datum = $request->datum;
        return view('obracunzarada::arhiva.ukupna_rekapitulacija');
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
