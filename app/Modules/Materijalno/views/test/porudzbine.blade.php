<!-- resources/views/stanje-zaliha/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
    <style>
        div.dataTables_length select{
            width: 40% !important;
            text-align: center !important;
        }

        .container-fluid{
            width: 80%!important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">

        <!-- Tabovi za različite entitete -->
        @include('materijalno::vertical_nav_magacin')

        <!-- Dinamičko učitavanje sadržaja taba -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="porudzbine" role="tabpanel" aria-labelledby="porudzbine-tab">
                <h3 class="text-center mt-4">Porudžbine</h3>
                <table id="porudzbineTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Šifra Porudžbine</th>
                        <th>Naziv</th>
                        <th>Datum Otvaranja</th>
                        <th>Datum Zatvaranja</th>
                        <th>Ugovor</th>
                    </tr>
                    </thead>
                </table>
            </div>


        </div>
    </div>


@endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {

            $('#porudzbineTable').DataTable({
                ajax: '{{ route('porudzbine.data') }}',
                columns: [
                    { data: 'rbpo' },
                    { data: 'napo' },
                    { data: 'dident' },
                    { data: 'dclose' },
                    { data: 'ugovor' },
                ]
            });

        });
    </script>
@endsection
