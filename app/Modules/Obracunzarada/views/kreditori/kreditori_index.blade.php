@extends('obracunzarada::theme.layout.app')

@section('custom-styles')

@endsection

@section('content')
    <div class="container">
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->
            <h1 class="text-center"> Pregled kreditora </h1>
            @if(count($data) > 0)
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                    <tr>
                        <th>Sifra kreditora</th>
                        <th>Naziv kreditora</th>
                        <th>Sedište kreditora</th>
                        <th>Tekući račun za uplatu</th>
                        <th>Partija kreditora</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->sifk_sifra_kreditora }}</td>
                            <td>{{ $item->imek_naziv_kreditora }}</td>
                            <td>{{ $item->sediste_kreditora }}</td>
                            <td>{{ $item->tekuci_racun_za_uplatu }}</td>
                            <td>{{ $item->partija_kredita }}</td>
                            <td>
                                <!-- Edit button -->
                                <a href="{{ route('kreditori.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">Izmeni</a>

                                <!-- Delete button -->
                                {{--                                <form action="{{ route('organizacioneceline.edit', ['id' => $item->id]) }}" method="post" style="display:inline;">--}}
                                {{--                                    @csrf--}}
                                {{--                                    @method('DELETE')--}}
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                {{--                                </form>--}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>No data available.</p>
            @endif
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
@endsection

