<!-- resources/views/category/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css" />
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pregled Kategorija</div>

                    <div class="card-body">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif

                        <table id="category_table" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Naziv Kategorije</th>
                                <th>Roditeljska Kategorija</th>
                                <th>Akcije</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->parent ? $category->parent->name : 'Nema' }}</td>
                                    <td>
                                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-primary">Izmeni</a>
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
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTables with search, pagination, and other features
            $('#category_table').DataTable({
                language: {
                    search: '<i class="fas fa-search"></i>&nbsp;&nbsp;&nbsp;&nbsp;Pretraga&nbsp;:',
                    info: "_START_ - _END_ od ukupno _TOTAL_ kategorija",
                    lengthMenu: "Prikaži &nbsp;&nbsp; _MENU_ &nbsp;&nbsp; kategorija",
                    infoFiltered: "(Filtrirano od _MAX_ ukupno kategorija)",
                    paginate: {
                        first: "Prvi",
                        previous: "Prethodni",
                        next: "Sledeći",
                        last: "Poslednji"
                    }
                },
                columns: [
                    { title: 'ID' },
                    { title: 'Naziv Kategorije' },
                    { title: 'Roditeljska Kategorija' },
                    { title: 'Akcije' }
                ],
            });
        });
    </script>
@endsection
