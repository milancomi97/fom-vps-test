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
            max-width: 1000px;
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

    </style>
@endsection

@section('content')
    <div class="container mt-5 mb-5">
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
                <div id="monthContainer" class="carousel slide mt-5" data-ride="carousel">

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
                            <label for="mesecni_fond_sati_modal">Mesečni fond sati</label>
                            <input type="text" class="form-control" id="mesecni_fond_sati_modal" >
                        </div>

                        <div class="form-group">
                            <input type="checkbox"  id="enable_mesecni_fond_sati_praznika_modal">
                            <label for="mesecni_fond_sati_praznika_modal">Dodaj sate (praznik)</label>
                            <input disabled type="number" value="0" class="form-control" id="mesecni_fond_sati_praznika_modal" >
                        </div>

                        <div class="form-group">
                            <label for="prosecni_godisnji_fond_sati_modal">Prosečni godišnji fond sati</label>
                            <input type="text" class="form-control" id="prosecni_godisnji_fond_sati_modal" >
                        </div>

                        <div class="form-group">
                            <label for="cena_rada_tekuci_modal">Cena rada tekući</label>
                            <input type="text" class="form-control" id="cena_rada_tekuci_modal" >
                        </div>

                        <div class="form-group">
                            <label for="cena_rada_prethodni_modal">Cena rada prethodni</label>
                            <input type="text" class="form-control" id="cena_rada_prethodni_modal" >
                        </div>
                        <div class="form-group">
                            <label for="vrednost_akontacije_modal">Vrednost akontacije</label>
                            <input type="number" class="form-control" id="vrednost_akontacije_modal" >
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

        let showObradaRoute ='{!! url('obracunzarada/datotekaobracunskihkoeficijenata/mesecna_obrada_index?month_id=') !!}'

    </script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_create/calendar_logic.js') }}"></script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_create/ajax_logic.js') }}"></script>

@endsection

