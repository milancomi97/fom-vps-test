@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link href="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">

    <style>
        .main-footer {
            margin-top: 60vh;
        }

        #statusMessage {
            text-align: center;
            font-weight: 700;
        }

        #monthSlider {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .month-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;

        }
        .modal-backdrop {
            background-color: transparent;
        }
        .carousel-item {
            display: contents !important;
        }
        *.hidden {
            display: none !important;
        }

        #monthContainer{
            padding-right: 70px;
        }
        div.loading{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(16, 16, 16, 0);
        }

        @-webkit-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-webkit-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-moz-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-ms-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-moz-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-webkit-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @-o-keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        @keyframes uil-ring-anim {
            0% {
                -ms-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -webkit-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -ms-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -webkit-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
        .uil-ring-css {
            margin: auto;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 200px;
            height: 800px;
        }
        .uil-ring-css > div {
            position: absolute;
            display: block;
            width: 200px;
            height: 200px;
            top: 20px;
            left: 20px;
            border-radius: 100px;
            box-shadow: 0 8px 0 0 #BDC7FF;
            -ms-animation: uil-ring-anim 1.4s linear infinite;
            -moz-animation: uil-ring-anim 1.4s linear infinite;
            -webkit-animation: uil-ring-anim 1.4s linear infinite;
            -o-animation: uil-ring-anim 1.4s linear infinite;
            animation: uil-ring-anim 1.4s linear infinite;
        }

        .btn-link{
            font-size: 50px;
            padding: 0;
            margin: 0;
        }

        .bolder{
            font-weight: 700;
        }

        .custom_border{
            border-bottom:  2px solid #007fff !important;
        }
    </style>
@endsection

@section('content')

     <h1 class="text-center mt-5">Prikaz kredita po kreditorima:</h1>

     <h1 class="text-center mt-5">{{$datum}}</h1>
     <div class="row">
         <div class="container">
             <form id="paymentForm" action="{{ route('datotekaobracunskihkoeficijenata.prikaz_kredita_po_kreditoru') }}" method="POST">
                 @csrf
                 <div class="form-group">
                     <select class="form-control" id="kreditor_id" name="kreditor_id" onchange="updateKreditorIdExport(); document.getElementById('paymentForm').submit();">
                         <!-- Assume $options is an array of dynamic data -->
                         @foreach($selectOptionData as $key =>$value)
                             <option value="{{ $key}}">{{$value}}</option>
                         @endforeach
                     </select>

                     <input type="hidden" name="month_id" value="{{$month_id}}">
                 </div>
             </form>
         </div>
     </div>

     <div class="container">
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <a href='{!! url('obracunzarada/datotekaobracunskihkoeficijenata/form_po_vrsti_placanja?month_id=') . $month_id !!}' class="btn mt-5 mr-5 btn-primary btn-lg">
                        Nazad na pretragu
                    </a>
                    <form method="POST"  action="{{ route('izvestaji.stampa_po_vrsti_placanja_krediti_kreditori') }}">
                        @csrf
                        <input type="hidden" name="month_id" value="{{ $month_id }}">
                        <input type="hidden" name="vrsta_placanja" value="{{ $vrsta_placanja }}">

                        <input type="hidden" name="kreditor_id_export" id="kreditor_id_export" value="{{$selectedKreditorId}}">

                        <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">
                            PDF &nbsp;&nbsp;<i class="fa fa-print fa-2xl" aria-hidden="true"></i>
                        </button>
                    </form>

                </div>
            </div>
         @foreach ($dkopData as $nazivKreditora =>$krediti)
             <h3 class="text-center text-secondary mt-5 custom_border">{{$nazivKreditora}}</h3>
            <table class="table table-bordered mt-2">
                <thead>
                <tr>
                    <th>Broj</th>
                    <th>Radnik</th>
                    <th>Glavnica</th>
                    <th>Saldo</th>
                    <th>Rata</th>
                    <th>Iznos</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $satiBrojac=0;
                $iznosBrojac=0;
                $brojac=1;
                    ?>


                    @foreach($krediti as $vrstaPlacanja)
                                    <tr>
                                        <td>{{$brojac++}}.</td>
                                        <td><a href="{!! url('obracunzarada/datotekaobracunskihkoeficijenata/show_plate?radnik_maticni=').$vrstaPlacanja['maticni_broj'].'&month_id='.$month_id!!}">
                                                {{  $vrstaPlacanja['maticni_broj'] }} {{  $vrstaPlacanja['mdrData']['PREZIME_prezime'] }}  {{  $vrstaPlacanja['mdrData']['srednje_ime'] }}. {{  $vrstaPlacanja['mdrData']['IME_ime'] }}</a></td>
                                        <td class="text-right">{{number_format($vrstaPlacanja['kreditData']['GLAVN_glavnica'],2,'.',',') }}</td>
                                        <td class="text-right">{{number_format($vrstaPlacanja['kreditData']['SALD_saldo'],2,'.',',') }}</td>
                                        <td class="text-right">{{number_format($vrstaPlacanja['kreditData']['RATA_rata'],2,'.',',') }}</td>
                                        <td class="text-right">{{number_format($vrstaPlacanja['iznos'],2,'.',',') }}</td>

                                    </tr>
                    <?php
                    $satiBrojac+= $vrstaPlacanja['sati'];
                    $iznosBrojac+=$vrstaPlacanja['iznos'];
                        ?>
                @endforeach

                <tr class="bolder">
                    <td colspan="4">
                        Ukupno:
                    </td>
                    <td class="text-right text-danger">{{number_format($iznosBrojac,2,'.',',')}}</td>
                </tr>
                </tbody>
            </table>
         @endforeach

     </div>

    <!-- Modal -->

@endsection



@section('custom-scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/build/js/tempusdominus-bootstrap-4.min.js"></script>

    <script>
    $(document).ready(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'MM.YYYY'
        });

        $('#datetimepicker2').datetimepicker({
            format: 'MM.YYYY'
        });
    });
</script>

    <script>
        function updateKreditorIdExport() {
            document.getElementById('kreditor_id_export').value = document.getElementById('kreditor_id').value;
        }
    </script>

@endsection

