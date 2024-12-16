@extends('obracunzarada::theme.layout.app')

@section('custom-styles')

@endsection

@section('content')

    <div class="container-fluid mt-4 mb-5" style="padding-left: 15%;padding-right: 5%">

        <h4>ZA MESEC: {{$datum}}</h4>
<div class="row">
    <div class="col-md-5">
        <h3>Sa E-poštom</h3>

            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>Matični broj</th>
                        <th>Prezime</th>
                        <th>Ime</th>
                        <th>E-pošta</th>
                        <th>Status E-pošte</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                @foreach($withEmail as $radnik)
                    <tr>
                        <td>{{$radnik->maticni_broj}}</td>
                        <td>{{$radnik->prezime}}</td>
                        <td>{{$radnik->ime}}</td>
                        <td>{{$radnik->maticnadatotekaradnika->email_za_plate}}</td>
                     <td>   @if($radnik->maticnadatotekaradnika->email_za_plate_poslat)
                            <span class="status_icon text-success">Poslat</span>

                        @else
                            <span class="status_icon text-warning">Nije poslat</span>
                        @endif
                     </td>
                    </tr>
                @endforeach
                </tbody>

            </table>





    </div>

    <div class="offset-md-2 col-md-5">
        <h3>Bez E-pošte</h3>
        <table class="table table-striped mt-3">
            <thead>
            <tr>
                <th>Matični broj</th>
                <th>Prezime</th>
                <th>Ime</th>
            </tr>
            </thead>
            <tbody id="table-body">
            @foreach($withoutEmail as $radnik)
                <tr>
                    <td>{{$radnik->maticni_broj}}</td>
                    <td>{{$radnik->prezime}}</td>
                    <td>{{$radnik->ime}}</td>

                </tr>
            @endforeach
            </tbody>

        </table>

    </div>
    </div>
    </div>


    <!-- /.content-wrapper -->

@endsection



@section('custom-scripts')
@endsection

