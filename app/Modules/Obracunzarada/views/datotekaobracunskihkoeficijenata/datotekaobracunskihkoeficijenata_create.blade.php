@extends('obracunzarada::theme.layout.app')

@section('custom-styles')

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

<div>
    <div class="loading hidden">
        <div class='uil-ring-css' style='transform:scale(0.79);'>
            <div></div>
        </div>
    </div>
    <h1 class="obrada-title text-center text-primary mt-5 hidden">Obrada je u toku</h1>
</div>
    <div class="container mt-5 mb-5 main-container-calendar">
        <div id="statusMessage"></div>
        <div class="container mb-5 ">
            <div id="monthSlider" class="border mb-5  mt-5">
                <div class="row">
                    <div class="col-1">
                        <button class="btn btn-link" onclick="prevMonth()">&lt;</button>
                    </div>
                    <div class="col-10 text-center">
                        <h3 id="monthYear"></h3>
                    </div>
                    <div class="col-1 text-right">
                        <button class="btn btn-link" onclick="nextMonth()">&gt;</button>
                    </div>
                </div>
                <form>
                    @csrf
                </form>
                <div id="monthContainer" class="carousel slide mt-5 pb-5" data-ride="carousel">

                </div>
            </div>

        </div>
        <div id="check_data">

        </div>
    </div>

    <!-- Modal -->
    <div class="modal " id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Unos obračunskih koeficijenata za mesec:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your form goes here -->

                    <form id="myForm">

                        <input name="month_id" id="month_id" type="hidden">
                        <div class="form-group">
                            <label for="month_modal">Mesec</label>
                            <input disabled type="text" class="form-control" id="month_modal" >
                        </div>
                        <div class="form-group">
                            <label for="year_modal">Godina</label>
                            <input disabled type="text" class="form-control" id="year_modal" >
                        </div>

                        <div class="form-group">
                            <label for="kalendarski_broj_dana_modal">Kalendarski broj dana u mesecu</label>
                            <input disabled type="text" class="form-control" id="kalendarski_broj_dana_modal" >
                        </div>
                        <div class="form-group">
                            <label for="mesecni_fond_sati_modal">Mesečni fond sati bez drzavnog praznika</label>
                            <input type="text" class="form-control" id="mesecni_fond_sati_modal" >
                        </div>

                        <div class="form-group">
                            <input type="checkbox"  id="enable_mesecni_fond_sati_praznika_modal">
                            <label for="mesecni_fond_sati_praznika_modal">Dodaj sate (praznik)</label>
                            <input disabled type="number" value="0" class="form-control" id="mesecni_fond_sati_praznika_modal" >
                        </div>

                        <div class="form-group">
                            <label for="prosecni_godisnji_fond_sati_modal">Prosečni godišnji fond sati</label>
                            <input type="text" class="form-control" value="174" id="prosecni_godisnji_fond_sati_modal" >
                        </div>

                        <div class="form-group">
                            <label for="cena_rada_tekuci_modal">Cena rada tekući</label>
                            <input type="text" class="form-control"  value="1" id="cena_rada_tekuci_modal" >
                        </div>

                        <div class="form-group">
                            <label for="cena_rada_prethodni_modal">Pomoćni koeficijent</label>
                            <input type="text" min="0" max="2"  class="form-control" id="cena_rada_prethodni_modal" >
                        </div>
                        <div class="form-group d-none">
                            <label for="vrednost_akontacije_modal">Vrednost akontacije</label>
                            <input type="number" class="form-control" value="0" id="vrednost_akontacije_modal" >
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="exampleFormControlInput6">Tip</label>--}}
{{--                            <input type="text" class="form-control" id="exampleFormControlInput6" >--}}
{{--                        </div>--}}

                        <div class="form-group">
                            <label for="period_isplate_od_modal">Period isplate od</label>
                            <input type="date" class="form-control" id="period_isplate_od_modal" >
                        </div>
                        <div class="form-group">
                            <label for="period_isplate_do_modal">Period isplate do</label>
                            <input type="date" class="form-control" id="period_isplate_do_modal" >
                        </div>
                        <!-- Add more form elements as needed -->
                    </form>
                </div>
                <div class="text-center text-danger" id="statusModalMessage"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvori</button>
                    <button type="button" class="btn btn-primary" id="submitFormBtn">Sačuvaj</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let databaseData = {!! $datotekaobracunskihkoeficijenata !!};
        let storeRoute ='{!! route('datotekaobracunskihkoeficijenata.store') !!}'
        let getStoreDataRoute ='{!! route('datotekaobracunskihkoeficijenata.getStoreData') !!}'
        let showRoute = '{!! url('obracunzarada/datotekaobracunskihkoeficijenata/show_all?month_id=')!!}'

        let showAkontacijeRoute = '{!! url('obracunzarada/datotekaobracunskihkoeficijenata/show_all_akontacije?month_id=')!!}'
        let showFiksnapRoute ='{!! url('obracunzarada/datotekaobracunskihkoeficijenata/show_all_fiksnap?month_id=') !!}'
        let showKreditiRoute ='{!! url('obracunzarada/datotekaobracunskihkoeficijenata/show_all_krediti?month_id=') !!}'

        let storeUpdateRoute ='{!! route('datotekaobracunskihkoeficijenata.store_update') !!}'

        let odobravanjeRoute = '{!! url('obracunzarada/datotekaobracunskihkoeficijenata/odobravanje?month_id=')!!}'
        let getMonthDataByIdRoute = '{{ route('datotekaobracunskihkoeficijenata.getMonthDataById') }}'

        let indexObradaRoute ='{!! url('obracunzarada/datotekaobracunskihkoeficijenata/mesecna_obrada_index?month_id=') !!}'
        let showPlateRoute ='{!! url('obracunzarada/datotekaobracunskihkoeficijenata/show_all_plate?month_id=') !!}'


        let izvestajRangListaZarade ='{!! url('obracunzarada/izvestaji/ranglistazarade?month_id=') !!}'
        let izvestajRekapitulaciajaZarade ='{!! url('obracunzarada/izvestaji/rekapitulacijazarade?month_id=') !!}'

        let arhiviranjeMeseca ='{!! url('obracunzarada/datotekaobracunskihkoeficijenata/arhiviranje_meseca?month_id=') !!}'


        let activeMonth ='{{$activeMonth}}';
        let activeYear = '{{$activeYear}}';
        let activeMonthExist = '{{$activeMonthExist}}';

        let obradaProsekaRoute = '{!! url('obracunzarada/datotekaobracunskihkoeficijenata/obrada_proseka?month_id=')!!}'

        let prikazPoVrstiPlacanjaRoute = '{!! url('obracunzarada/datotekaobracunskihkoeficijenata/form_po_vrsti_placanja?month_id=')!!}'


    </script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_create/calendar_logic.js') }}"></script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_create/ajax_logic.js') }}"></script>

@endsection

