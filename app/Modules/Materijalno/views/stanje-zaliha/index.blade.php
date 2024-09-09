<!-- resources/views/stanje-zaliha/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pregled Stanja Zaliha</div>

                    <div class="card-body">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif

                        <a href="{{ route('stanje-zaliha.create') }}" class="btn btn-primary mb-3">Dodaj novi Stanje Zaliha</a>

                        <table id="stanje_zaliha_table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Materijal</th>
                                <th>Magacin</th>
                                <th>Količina</th>
                                <th>Vrednost</th>
                                <th>Akcije</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stanjeZaliha as $zaliha)
                                <tr>
                                    <td>{{ $zaliha->id }}</td>
                                    <td>{{ optional($zaliha->material)->naziv_materijala ?? 'Nema materijala' }}</td>
                                    <td>{{ optional($zaliha->warehouse)->name ?? 'Nema magacina' }}</td>
                                    <td>{{ $zaliha->stanje_kolicina }}</td>
                                    <td>{{ $zaliha->stanje_vrednost }}</td>
                                    <td>
                                        <a href="{{ route('stanje-zaliha.edit', $zaliha->id) }}" class="btn btn-sm btn-primary">Izmeni</a>
                                        <form action="{{ route('stanje-zaliha.destroy', $zaliha->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Obriši</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#stanje_zaliha_table').DataTable({
                language: {
                    search: '<i class="fas fa-search"></i>&nbsp;&nbsp;&nbsp;&nbsp;Pretraga&nbsp;:',
                    info: "_START_ - _END_ od ukupno _TOTAL_ stanja zaliha",
                    lengthMenu: "Prikaži &nbsp;&nbsp; _MENU_ &nbsp;&nbsp; stanja zaliha",
                    infoFiltered: "(Filtrirano od _MAX_ ukupno stanja zaliha)",
                    paginate: {
                        first: "Prvi",
                        previous: "Prethodni",
                        next: "Sledeći",
                        last: "Poslednji"
                    }
                }
            });
        });
    </script>
@endsection
