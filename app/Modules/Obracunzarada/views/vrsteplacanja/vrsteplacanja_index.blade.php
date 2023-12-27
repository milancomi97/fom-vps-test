@extends('obracunzarada::theme.layout.app')

@section('custom-styles')

@endsection

@section('content')
    <div class="ml-5 container-fluid">
        <div class="content ml-5 ">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->
            <h1 class="text-center"> Pregled vrste plaćanja </h1>
            @if(count($data) > 0)
                <table class="table table-bordered table-striped mt-5">
                    <thead>
                    <tr>
{{--                        <th>Sifra vrste plaćanja</th>--}}
{{--                        <th>Naziv vrste plaćanja</th>--}}
{{--                        <th>Formula za obračun </th>--}}
                        <th>Naziv vrste plaćanja</th>
                        <th>Sifra vrste plaćanja</th>
                        <th>Formula</th>
                        <th>Redosled poentaze zaglavlja POEN</th>
                        <th>Redosled poentaze opis RIK</th>
                        <th>Grupe vrsta placanja SLOV</th>
                        <th>Grupisanje sati, novca POK1</th>
                        <th>Obračun minulog rada POK2</th>
                        <th>Prikaz kroz unos POK3</th>
                        <th>Prihod rashod tip KESC</th>
                        <th>Efektivni sati EFSA</th>
                        <th>Prosek po kvalifikacijama PRKV</th>
                        <th>Ograničenje za minimalac OGRAN</th>
                        <th>Prosečni obračun PROSEK</th>
                        <th>Minuli rad varijabla VARI</th>
                        <th>Tip vrste plaćanja DOVP</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $item)
                        <tr>
{{--                            <td>{{ $item->rbvp_sifra_vrste_placanja }}</td>--}}
{{--                            <td>{{ $item->naziv_naziv_vrste_placanja }}</td>--}}
{{--                            <td>{{ $item->formula_formula_za_obracun }}</td>--}}

                            <td>{{$item->naziv_naziv_vrste_placanja}}</td>
                            <td>{{$item->rbvp_sifra_vrste_placanja}}</td>
                            <td>{{$item->formula_formula_za_obracun}}</td>
                            <td>{{$item->redosled_poentaza_zaglavlje}}</td>
                            <td>{{$item->redosled_poentaza_opis}}</td>
                            <td>{{$item->SLOV_grupe_vrsta_placanja}}</td>
                            <td>{{$item->POK1_grupisanje_sati_novca}}</td>
                            <td>{{$item->POK2_obracun_minulog_rada}}</td>
                            <td>{{$item->POK3_prikaz_kroz_unos}}</td>
                            <td>{{$item->KESC_prihod_rashod_tip}}</td>
                            <td>{{$item->EFSA_efektivni_sati}}</td>
                            <td>{{$item->PRKV_prosek_po_kvalifikacijama}}</td>
                            <td>{{$item->OGRAN_ogranicenje_za_minimalac}}</td>
                            <td>{{$item->PROSEK_prosecni_obracun}}</td>
                            <td>{{$item->VARI_minuli_rad}}</td>
                            <td>{{$item->DOVP_tip_vrste_placanja}}</td>
                            <td>
                                <!-- Edit button -->
                                <a href="{{ route('vrsteplacanja.edit', ['id' => $item->id]) }}" class="btn btn-primary btn-sm">Izmeni</a>

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

