@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
@endsection

@section('content')
    <div class="container mb-5">
        <div id="statusMessage"></div>
        <h1>Datoteka obracunskih koeficijenata test</h1>


        <div>
            <table class="table table-striped">
                <thead>
                <tr>
                    @foreach($mesecnaTabelaPoentaza[0] as $key => $value)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($mesecnaTabelaPoentaza as $poentaza)
                    <tr>
                        @foreach($poentaza as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    </div>
@endsection



@section('custom-scripts')

@endsection

