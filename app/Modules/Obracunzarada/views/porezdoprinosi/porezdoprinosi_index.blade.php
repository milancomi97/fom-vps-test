@extends('obracunzarada::theme.layout.app')

@section('custom-styles')

@endsection

@section('content')
    <div class="container-fluid">
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->

            <h1 class="text-center"> Pregled poreza i doprinosa </h1>
            @if(count($data) > 0)
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                    <tr>
                        <th>Mesec i godina M_G</th>
                        <th>Iznos poreskog oslobadjanja IZN1</th>
                        <th>Opis poreza OPPOR</th>
                        <th>Porez P1</th>
                        <th>Opis zdravstvenog osiguranja na teret radnika OPIS1</th>
                        <th>Zdravstveno osiguranje na teret radnika ZDRO</th>
                        <th>Opis PIO na teret radnika OPIS2</th>
                        <th>Pio na teret radnika PIO</th>
                        <th>Opis osiguranja od nezaposljenosti na teret radnika OPIS3</th>
                        <th>Osiguranje od nezaposlenosti na teret radnika ONEZ</th>
                        <th>Ukupni doprinosi na teret radnika UKDOPR</th>
                        <th>Opis zdravstvenog osiguranja na teret poslodavca OPIS4</th>
                        <th>Zdravstveno osiguranje na teret poslodavca DOPRA</th>
                        <th>Opis pio na teret poslodavca OPIS5</th>
                        <th>Pio na teret poslodavca DOPRB</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->M_G_mesec_godina }}</td>
                            <td>{{ $item->IZN1_iznos_poreskog_oslobodjenja }}</td>
                            <td>{{ $item->OPPOR_opis_poreza }}</td>
                            <td>{{ $item->P1_porez_na_licna_primanja }}</td>
                            <td>{{ $item->OPIS1_opis_zdravstvenog_osiguranja_na_teret_radnika }}</td>
                            <td>{{ $item->ZDRO_zdravstveno_osiguranje_na_teret_radnika }}</td>
                            <td>{{ $item->OPIS2_opis_pio_na_teret_radnika }}</td>
                            <td>{{ $item->PIO_pio_na_teret_radnika }}</td>
                            <td>{{ $item->OPIS3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika }}</td>
                            <td>{{ $item->ONEZ_osiguranje_od_nezaposlenosti_na_teret_radnika }}</td>
                            <td>{{ $item->UKDOPR_ukupni_doprinosi_na_teret_radnika }}</td>
                            <td>{{ $item->OPIS4_opis_zdravstvenog_osiguranja_na_teret_poslodavca }}</td>
                            <td>{{ $item->DOPRA_zdravstveno_osiguranje_na_teret_poslodavca }}</td>
                            <td>{{ $item->OPIS5_opis_pio_na_teret_poslodavca }}</td>
                            <td>{{ $item->DOPRB_pio_na_teret_poslodavca }}</td>
                            <td>
                                <!-- Edit button -->
                                <a href="{{ route('porezdoprinosi.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">Izmeni</a>

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

