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
    <div class="container mb-5">
        <div id="statusMessage"></div>
        <div class="container mb-5">
            <div id="monthSlider" class="border mb-5">
                <div class="row">
                    <div class="col-1">
                        <button class="btn btn-link" onclick="prevMonth()">&lt;</button>
                    </div>
                    <div class="col-10 text-center">
                        <h5 id="monthYear"></h5>
                    </div>
                    <div class="col-1 text-right">
                        <button class="btn btn-link" onclick="nextMonth()">&gt;</button>
                    </div>
                </div>
                <form>
                    @csrf
                </form>
                <div id="monthContainer" class="carousel slide " data-ride="carousel">

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
                    <h5 class="modal-title" id="exampleModalLabel">Unos obracunskih koeficijenata za mesec:</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your form goes here -->
                    <form id="myForm">

                        <div class="form-group">
                            <label for="exampleFormControlInput2">Mesec</label>
                            <input type="text" class="form-control" id="exampleFormControlInput2" >
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput3">Godina</label>
                            <input type="text" class="form-control" id="exampleFormControlInput3" >
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput4">Kalendarski broj dana u mesecu</label>
                            <input type="text" class="form-control" id="exampleFormControlInput4" >
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput5">Mesecni fond sati</label>
                            <input type="text" class="form-control" id="exampleFormControlInput5" >
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput6">Tip</label>
                            <input type="text" class="form-control" id="exampleFormControlInput6" >
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput7">Prosecni godisnji fond sati</label>
                            <input type="text" class="form-control" id="exampleFormControlInput7" >
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput8">Period isplate</label>
                            <input type="text" class="form-control" id="exampleFormControlInput8" >
                        </div>
                        <!-- Add more form elements as needed -->
                    </form>
                </div>
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
        let checkRoute ='{!! route('datotekaobracunskihkoeficijenata.check') !!}'
        let showRoute = '{!! url('obracunzarada/datotekaobracunskihkoeficijenata/show?month_id=')!!}'

    </script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_create/calendar_logic.js') }}"></script>
    <script src="{{ asset('modules/obracunzarada/datotekaobracunskihkoef_create/ajax_logic.js') }}"></script>

@endsection

