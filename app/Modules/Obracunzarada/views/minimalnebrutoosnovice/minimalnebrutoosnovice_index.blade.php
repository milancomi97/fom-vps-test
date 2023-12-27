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
                        <th>Mesec Godina M_G</th>
                        <th>Prosečna mesečna zarada u republici NT1</th>
                        <th>Minimalna neto zarada po satu STOPA2</th>
                        <th>Koeficijent najviše osnovice za obračun dobrinos STOPA6</th>
                        <th>Stopa poreza P1</th>
                        <th>Koeficijent za obračun neto na bruto STOPA1</th>
                        <th>Minimalna bruto zarada NT2</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->M_G_mesec_dodina }}</td>
                            <td>{{ $item->NT1_prosecna_mesecna_zarada_u_republici }}</td>
                            <td>{{ $item->STOPA2_minimalna_neto_zarada_po_satu }}</td>
                            <td>{{ $item->STOPA6_koeficijent_najvise_osnovice_za_obracun_doprinos }}</td>
                            <td>{{ $item->P1_stopa_poreza }}</td>
                            <td>{{ $item->STOPA1_koeficijent_za_obracun_neto_na_bruto }}</td>
                            <td>{{ $item->NT2_minimalna_bruto_zarada }}</td>
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

