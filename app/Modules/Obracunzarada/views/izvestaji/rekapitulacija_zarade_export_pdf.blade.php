<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: A4 portrait;
            margin-top: 5mm!important;
            margin-left: 25mm!important;
            margin-right: 25mm!important;

        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*table-layout: fixed;*/
        }

        th, td {
            border: 1px solid #000;
            padding: 2px 1px;
            text-align: center
        }

        th {
            background-color: #f2f2f2;
        }

        .text-left{
            text-align: left;
            padding-left:5px;
        }

        .text-right{
            text-align: right;
            padding-right:5px;
        }
        .text-center{
            text-align: center;
        }
        .table-container {
            width: 100%;
            max-width: 150mm; /* A4 width in mm minus margins */
            margin: 0 auto;
        }

        .container-below{
            margin-top: 20px;
        }
        .radnik_name{
            min-width: 100px;
            text-align: left;
            padding: 5px 5px 5px 5px;
        }
        /* Custom styles for the two sub-tables */

        .sub-table {
            width: 49%; /* Half of the container width */
            margin-right: 2%; /* Adjust for space between tables */
            float: left; /* Ensures they are side-by-side */
            border-collapse: collapse;
        }

        .sub-table th,
        .sub-table td {
            border: 0px solid #000;
            padding: 8px;
            text-align: left;
        }

        .sub-table th {
            background-color: #f2f2f2;
        }

        .bolder{
            font-weight: 700;
        }
    </style>

</head>
<body>
    <div class="container">

        <div class="row">
            <div class="col-lg-10 offset-lg-1">

                <div class="container">


                    <div class="sub-table-container">
                        <table class="sub-table">
                            <thead>
                            <tr>
                                <th> {{$podaciFirme['naziv_firme']}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td >
                                    {{$podaciFirme['skraceni_naziv_firme']}}

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Second sub-table: Company Data -->
                    <div class="sub-table-container">
                        <table class="sub-table">
                            <thead>
                            <tr>
                                <th style="text-align: right!important;">Datum štampe: <b>{{$datumStampe}} </b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>






                    <div class="row mb-3">
                        <h2 class="text-center"></h2>
                        <h2 class="text-center">Rekapitulacija Ostvarene Zarade</h2>

                        <h1 class="text-center">Datum:<b>{{$datum}}</b></h1>
                        <div class="col-sm-10"></div>
                        <div class="col-sm-2 text-right">
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th >VP</th>
                            <th class="text-left" >Naziv vrste placanja</th>
                            <th >Sati</th>
                            <th >Iznos</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $ukupanPrihod=0;
                        ?>
                        @foreach($dkopData as $vrstaPlacanja)

                            @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='P')
                        <tr>
                            <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>
                            <td  class="text-left">{{$vrstaPlacanja->naziv_vrste_placanja}}</td>
                            <td  class="text-right">{{number_format($vrstaPlacanja->sati)}}</td>
                            <td  class="text-right">{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>
                        </tr>
                                <?php
                            $ukupanPrihod+=$vrstaPlacanja->iznos;
                                    ?>
                            @endif

                        @endforeach
                        <tr style="border-top:2px solid black">
                            <td></td>
                            <td></td>
                            <td class="text-left"><b>Bruto zarada:</b></td>
                            <td class="text-right" ><b  >{{number_format($ukupanPrihod, 2, '.', ',')}}</b></td>
                        </tr>

                        <?php
                        $ukupniPorezi=0;
                        ?>
                        @foreach($dkopData as $vrstaPlacanja)

                            @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='R' &&$vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']=='P')
                                <tr>
                                    <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>
                                    <td  class="text-left">{{$vrstaPlacanja->naziv_vrste_placanja}}</td>
                                    <td  class="text-right">{{number_format($vrstaPlacanja->sati)}}</td>
                                    <td  class="text-right">{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>
                                    <?php
                                    $ukupniPorezi+=$vrstaPlacanja->iznos;
                                    ?>
                            @endif


                        @endforeach
                        <tr style="border-top:2px solid black">
                            <td></td>
                            <td></td>
                            <td class="text-left"><b>Ukupni doprinosi na teret radnika:</b></td>
                            <td class="text-right"><b >{{number_format($ukupniPorezi, 2, '.', ',')}}</b></td>
                        </tr>


                        <?php
                        $ukupniPoreziLicnaPrimanja=0;
                        ?>

                        @foreach($dkopData as $vrstaPlacanja)

                            @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='R'  &&$vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']==='U')
                                <tr>
                                    <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>
                                    <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>
                                    <td class="text-right">{{number_format($vrstaPlacanja->sati)}}</td>
                                    <td class="text-right">{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>
                                    <?php
                                    $ukupniPoreziLicnaPrimanja+=$vrstaPlacanja->iznos;
                                    ?>
                            @endif

                        @endforeach


                        <tr style="border-top:2px solid black">
                            <td></td>
                            <td></td>
                            <td class="text-left"><b>Ukupan porez na licna primanja:</b></td>
                            <td class="text-right"><b>{{number_format($ukupniPoreziLicnaPrimanja, 2, '.', ',')}}</b></td>
                        </tr>






                        <?php
                        $ukupniRashod=0;
                        ?>

                            @foreach($dkopData as $vrstaPlacanja)

                                @if($vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['KESC_prihod_rashod_tip']=='R'  &&$vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']!=='P' && $vrstePlacanjaSifarnik[$vrstaPlacanja->sifra_vrste_placanja]['SLOV_grupe_vrsta_placanja']!=='U')
                            <tr>
                                <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>
                                <td class="text-left">{{$vrstaPlacanja->naziv_vrste_placanja}}</td>
                                <td  class="text-right">{{number_format($vrstaPlacanja->sati)}}</td>
                                <td  class="text-right">{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>
                                <?php
                                 $ukupniRashod+=$vrstaPlacanja->iznos;
                                ?>
                                @endif

                            @endforeach
                            <tr style="border-top:2px solid black">
                                <td></td>
                                <td></td>
                                <td class="text-left"><b>Ukupne obustave:</b></td>
                                <td class="text-right"><b >{{number_format($ukupniRashod, 2, '.', ',')}}</b></td>
                            </tr>

{{--                        @foreach($dkopData as $vrstaPlacanja)--}}

{{--                            <tr>--}}
{{--                                <td>{{$vrstaPlacanja->sifra_vrste_placanja}}</td>--}}
{{--                                <td>{{$vrstaPlacanja->naziv_vrste_placanja}}</td>--}}
{{--                                <td  class="text-right">{{number_format($vrstaPlacanja->sati)}}</td>--}}
{{--                                <td  class="text-right">{{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}</td>--}}


{{--                            </tr>--}}

{{--                        @endforeach--}}
                        </tbody>
                    </table>
                </div>
                <div class="container-below">
                    <table class="table table-bordered">
                        <tbody>
                        <tr class="bolder">
                            <td class="text-left">1. BRUTO ZARADA</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">- IZNOS PORESKOG OSLOBODJENJA</td>
                            <td></td>r
                            <td  class="text-right">{{number_format($zaraData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">- OPOREZIVI IZNOS ZARADE</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade -$zaraData->POROSL_poresko_oslobodjenje, 2, '.', ',')}}</td>
                        </tr>
                        <tr class="bolder">
                            <td class="text-left">2. NETO ZARADA (1-5)</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->NETO_neto_zarada , 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">3. UK. OBUSTAVE</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->SIOB_ukupni_iznos_obustava +  $zaraData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>
                        </tr>
                        <tr class="bolder">
                            <td class="text-left">4. ZA ISPLATU (1-5-3)</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade -  $zaraData->SIP_ukupni_iznos_poreza - $zaraData->SID_ukupni_iznos_doprinosa - $zaraData->SIOB_ukupni_iznos_obustava - $zaraData->ZARKR_ukupni_zbir_kredita, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">UKUPNI DOPRINOSI</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">050 POREZ (10%)</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->SIP_ukupni_iznos_poreza, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">5. UKUPNI POREZI I DOPRINOSI (a+b)</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->SIP_ukupni_iznos_poreza + $zaraData->SID_ukupni_iznos_doprinosa, 2, '.', ',')}}</td>
                        </tr>

                        <tr>
                            <td class="text-left">6. OBAVEZE NA TERET POSLODAVCA: </td>
                            <td></td>
                            <td></td>

                        </tr>
                        <tr>
                            <td class="text-left" style="padding-left: 25px">Zdravstveno osiguranje (p)</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td class="text-left" style="padding-left: 25px">Penzijsko-invalidsko osig. (p)</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Ukupni doprinosi</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>
                        </tr>
                        <tr class="bolder">
                            <td class="text-left">7. Potrebna sredstva (BRUTO II):</td>
                            <td></td>
                            <td  class="text-right">{{number_format($zaraData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade +$zaraData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zaraData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',')}}</td>

                        </tr>
                        <tr>
                            <td class="text-left">12. BROJ AKTIVNIH RADNIKA:</td>
                            <td></td>
                            <td class="text-right">{{$aktivnihRadnika}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">13. BROJ RADNIKA SA ZARADOM:</td>
                            <td></td>
                            <td class="text-right">{{$radnikaSaZaradom}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
