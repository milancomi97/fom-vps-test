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
    </style>
@endsection

@section('content')

     <h1 class="text-center">Prikaz proseka</h1>
        <div class="container">

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Maticni Broj</th>
                    <th>Radnik</th>
                    <th>PRIZ Ukupan Bruto Iznos</th>
                    <th>PRCAS Ukupni Sat</th>
                    <th>Prosek</th>
                    <th>BROJ Broj Meseci</th>
                </tr>
                </thead>
                <tbody>
{{--                @foreach($sumResult as $item)--}}
{{--                    <tr class=" {{$item['PRCAS_ukupni_sati_za_ukupan_bruto_iznost'] == 0 ? 'bg-warning':'' }}--}}
{{--                    ">--}}
{{--                        <td>{{ $item['MBRD_maticni_broj'] }}</td>--}}
{{--                        <td>{{ $item['PREZIME_prezime'] }} {{ $item['srednje_ime'] }} {{ $item['IME_ime'] }}</td>--}}
{{--                        <td>{{ number_format($item['PRIZ_ukupan_bruto_iznos'],2,'.',',')}}</td>--}}
{{--                        <td>{{$item['PRCAS_ukupni_sati_za_ukupan_bruto_iznost']}}</td>--}}
{{--                        @if($item['PRCAS_ukupni_sati_za_ukupan_bruto_iznost']>0)--}}
{{--                        <td>{{ number_format($item['PRIZ_ukupan_bruto_iznos']/$item['PRCAS_ukupni_sati_za_ukupan_bruto_iznost'],2,'.',',')}}</td>--}}
{{--                        @else--}}
{{--                            <td>0</td>--}}
{{--                        @endif--}}
{{--                        <td>{{ $item['BROJ_broj_meseci_za_obracun'] }}</td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}
                </tbody>
            </table>
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


@endsection

