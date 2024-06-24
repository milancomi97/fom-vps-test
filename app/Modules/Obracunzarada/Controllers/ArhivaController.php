<?php

namespace App\Modules\Obracunzarada\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ArhivaController extends Controller
{

    public function __construct(

     )
    {
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
        return view('obracunzarada::arhiva.arhiva_maticne_datoteke');
    }
    public function obracunskeListe(Request $request)
    {
        $maticniBroj = $request->maticniBroj;
        $datum = $request->datum;
        return view('obracunzarada::arhiva.obracunske_liste');
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
