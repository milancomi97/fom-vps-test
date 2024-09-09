<!-- resources/views/magacini/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Pregled Magacina</div>

                    <div class="card-body">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif

                        <a href="{{ route('magacin.create') }}" class="btn btn-primary mb-3">Dodaj novi Magacin</a>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Naziv</th>
                                <th>Lokacija</th>
                                <th>Akcije</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($magacini as $magacin)
                                <tr>
                                    <td>{{ $magacin->id }}</td>
                                    <td>{{ $magacin->name }}</td>
                                    <td>{{ $magacin->location ?? 'Nema lokacije' }}</td>
                                    <td>
                                        <a href="{{ route('magacin.edit', $magacin->id) }}" class="btn btn-sm btn-primary">Izmeni</a>
                                        <form action="{{ route('magacin.destroy', $magacin->id) }}" method="POST" class="d-inline">
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
