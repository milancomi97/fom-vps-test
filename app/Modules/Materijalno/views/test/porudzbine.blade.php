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
        <h1 class="text-center">Pregled podataka</h1>

        <!-- Tabovi za različite entitete -->
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
                {{dd($activeTab)}}
                <a class="nav-link {{ $activeTab=='materijal' ? 'active' : '' }}" href="{{ route('materijalno.materijali.index') }}">Materijali</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab=='stanje-materijala' ? 'active' : '' }}" href="{{ route('materijalno.stanje-materijala.index') }}">Stanje Materijala</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab=='kartice' ? 'active' : '' }}" href="{{ route('materijalno.kartice.index') }}">Kartice</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab=='porudzbine' ? 'active' : '' }}" href="{{ route('materijalno.porudzbine.index') }}">Porudžbine</a>
            </li>
        </ul>

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
