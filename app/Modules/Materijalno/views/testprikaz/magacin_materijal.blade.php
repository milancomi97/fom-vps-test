<!-- resources/views/stanje-zaliha/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')

@endsection

@section('content')
    <div class="container">
        <h3 class="text-center mt-4">Materijali u Magacinu: {{ $magacinId }}</h3>
        <table id="materijaliTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>Šifra Materijala</th>
                <th>Naziv Materijala</th>
                <th>Količina</th>
                <th>Vrednost</th>
                <th>Cena</th>
            </tr>
            </thead>
            <tbody>
            @foreach($materijali as $materijal)
                <tr>
                    <td>{{ $materijal->sifra_materijala }}</td>
                    <td>{{ $materijal->materijal->naziv_materijala }}</td>
                    <td>{{ $materijal->kolicina }}</td>
                    <td>{{ $materijal->vrednost }}</td>
                    <td>{{ $materijal->cena }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


@endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection
