<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>

    </style>
@endsection

@section('content')
    <div class="container" style="margin:0 10%">
        <div class="content">
            <h1 class="text-center mt-5">Potvrda proseka</h1>
            <h2 class="text-center mt-5">{{$radnikData->maticni_broj}} {{ $radnikData->prezime}} {{ $radnikData->ime}}</h2>
            <h2 class="text-center mt-5"><b> {{ $datumOd}} - {{$datumDo}} </b></h2>
            <div class="row">
                <div class="col d-flex justify-content-end">
                    <form method="POST"  action="{{ route('arhiva.stampaPotvrdaProseka') }}">
                        @csrf
                        <input type="hidden" name="maticniBroj" value="{{ $maticniBroj }}">
                        <input type="hidden" name="datumOd" value="{{ $datumOd }}">
                        <input type="hidden" name="datumDo" value="{{ $datumDo }}">

                        <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">
                            PDF &nbsp;&nbsp;<i class="fa fa-print fa-2xl" aria-hidden="true"></i>
                        </button>
                    </form>

                </div>
            </div>
            <table class="table text-center table-striped table-bordered mt-5 mb-5 mt-3">
                <thead>
                <tr><th>#</th>
                    <?php
                        $counter=1;
                            ?>
                    @foreach($resultData as $key =>$data)
                        @if(is_array($data))
                          <th class="text-center">{{$counter++}}</th>
                        @endif
                        @endforeach

                </tr>

                <tr>
                    <th>Datum:</th>
                    @foreach($resultData as $data)
                        @if(is_array($data))
                        <th>{{\Carbon\Carbon::createFromFormat('Y-m-d', $data['datum'])->startOfMonth()->format('m.Y') }}</th>
                        @endif
                    @endforeach
                    <th>Ukupno:</th>
                    <th>Prosek:</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><b>Izneto:</b></td>
                @foreach($resultData as $data)
                    @if(is_array($data))
                        <td>{{number_format( $data['IZNETO'], 2, '.', ',')}}</td>
{{--                        resultData--}}
{{--                        radnikData--}}
{{--                    </tr>--}}
                    @endif

                @endforeach
                    <td>{{number_format($resultData['izneto'], 2, '.', ',')}}</td>
                    <td><b>{{number_format($resultData['izneto']/$counter, 2, '.', ',')}}</b></td>

                </tr>
                <tr>
                    <td><b>Neto:</b></td>

                @foreach($resultData as $data)
                    @if(is_array($data))
                        <td>{{number_format( $data['NETO'], 2, '.', ',')}}</td>

                            {{--                        resultData--}}
                        {{--                        radnikData--}}
                        {{--                    </tr>--}}
                    @endif
                @endforeach
                    <td>{{number_format($resultData['neto'], 2, '.', ',')}}</td>
                    <td><b>{{number_format($resultData['neto']/$counter, 2, '.', ',')}}</b></td>
                </tr>
{{--                {{number_format($vrstaPlacanja->iznos, 2, '.', ',')}}--}}
                </tbody>
            </table>
        </div>

        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
    <script>

    </script>
@endsection

