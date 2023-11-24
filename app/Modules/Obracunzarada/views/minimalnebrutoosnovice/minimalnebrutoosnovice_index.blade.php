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

            <h1 class="text-center"> Pregled Minimalnih bruto osnovica </h1>
            @if(count($data) > 0)
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                    <tr>
                        <th>Mesec</th>
                        <th>Godina</th>
                        <th>Prosečna mesečna osnovica</th>
                        <th>Minimalna neto zarada po satu</th>
                        <th>Koeficijent najviše osnovice za obračun dobrinos</th>
                        <th>Stopa poreza</th>
                        <th>Koeficijent za obračun neto na bruto</th>
                        <th>Najniža osnovica za plaćanje dobrinosa</th>
                        <th>Minimalna bruto zarada</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->mesec }}</td>
                            <td>{{ $item->godina }}</td>
                            <td>{{ $item->nt1_prosecna_mesecna_osnovica }}</td>
                            <td>{{ $item->stopa2_minimalna_neto_zarada_po_satu }}</td>
                            <td>{{ $item->stopa6_koeficijent_najvise_osnovice_za_obracun_doprinos }}</td>
                            <td>{{ $item->p1_stopa_poreza }}</td>
                            <td>{{ $item->stopa1_koeficijent_za_obracun_neto_na_bruto }}</td>
                            <td>{{ $item->nt3_najniza_osnovica_za_placanje_doprinos }}</td>
                            <td>{{ $item->nt2_minimalna_bruto_zarada }}</td>
                            <td>
                                <!-- Edit button -->
                                <a href="{{ route('minimalnebrutoosnovice.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">Izmeni</a>

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

