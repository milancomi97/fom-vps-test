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

            <h1 class="text-center"> Pregled poreza i doprinosa </h1>
            @if(count($data) > 0)
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                    <tr>
                        <th>Mesec</th>
                        <th>Godina</th>
                        <th>Opis iznosa poreskog oslobadjanja</th>
                        <th>Iznos poreskog oslobadjanja</th>
                        <th>Opis poreza</th>
                        <th>Porez</th>
                        <th>Opis zdravstvenog osiguranja na teret radnika</th>
                        <th>Zdravstveno osiguranje na teret radnika</th>
                        <th>Opis PIO na teret radnika</th>
                        <th>Pio na teret radnika</th>
                        <th>Opis osiguranja od nezaposljenosti na teret radnika</th>
                        <th>Osiguranje od nezaposlenosti na teret radnika</th>
                        <th>Ukupni doprinosi na teret radnika</th>
                        <th>Opis zdravstvenog osiguranja na teret poslodavca</th>
                        <th>Zdravstveno osiguranje na teret poslodavca</th>
                        <th>Opis pio na teret poslodavca</th>
                        <th>Pio na teret poslodavca</th>
                        <th>Ukupni doprinosi na teret poslodavca</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{ $item->mesec }}</td>
                            <td>{{ $item->godina }}</td>
                            <td>{{ $item->opis0_opis_iznos_poreskog_oslobadjanja }}</td>
                            <td>{{ $item->izn1_iznos_poreskog_oslobadjanja }}</td>
                            <td>{{ $item->oppor_opis_poreza }}</td>
                            <td>{{ $item->p1_porez }}</td>
                            <td>{{ $item->opis1_opis_zdravstvenog_osiguranja_na_teret_radnika }}</td>
                            <td>{{ $item->zdro_zdravstveno_osiguranje_na_teret_radnika }}</td>
                            <td>{{ $item->opis2_opis_pio_na_teret_radnika }}</td>
                            <td>{{ $item->pio_pio_na_teret_radnika }}</td>
                            <td>{{ $item->opis3_opis_osiguranja_od_nezaposlenosti_na_teret_radnika }}</td>
                            <td>{{ $item->onez_osiguranje_od_nezaposlenosti_na_teret_radnika }}</td>
                            <td>{{ $item->ukdop_ukupni_doprinosi_na_teret_radnika }}</td>
                            <td>{{ $item->opis4_opis_zdravstvenog_osiguranja_na_teret_poslodavca }}</td>
                            <td>{{ $item->dopzp_zdravstveno_osiguranje_na_teret_poslodavca }}</td>
                            <td>{{ $item->opis5_opis_pio_na_teret_poslodavca }}</td>
                            <td>{{ $item->dopp_pio_na_teret_poslodavca }}</td>
                            <td>{{ $item->ukdopp_ukupni_doprinosi_na_teret_poslodavca }}</td>
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

