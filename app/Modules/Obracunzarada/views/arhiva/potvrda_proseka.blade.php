<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>

    </style>
@endsection

@section('content')
    <div class="container" style="margin:0 10%">
        <div class="content mt-5">
            <div class="row mt-5">
                <div class="col-md-6">
                    <h1 class="text-center">Potvrda proseka</h1>
                    <h2 class="text-center">{{$radnikData->maticni_broj}} {{ $radnikData->prezime}}  {{ $radnikData->ime_oca}}. {{ $radnikData->ime}}</h2>
                    <h2 class="text-center"><b> {{ $datumOd}} - {{$datumDo}} </b></h2>
                </div>
            <div class="col-md-6">
                <div class="col">
                    <form method="POST"  action="{{ route('arhiva.stampaPotvrdaProseka') }}">
                        @csrf
                        <input type="hidden" name="maticniBroj" value="{{ $maticniBroj }}">
                        <input type="hidden" name="datumOd" value="{{ $datumOd }}">
                        <input type="hidden" name="datumDo" value="{{ $datumDo }}">
                        <div class="form-group">

                            <label for="exampleFormControlSelect2">Svrha potvrde:</label>
                            <textarea class=" form-control" name="opis" id="exampleFormControlSelect2"></textarea>
                        </div>
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
                        <td>{{number_format( $data['IZNETO'], 2, ',', '.')}}</td>
{{--                        resultData--}}
{{--                        radnikData--}}
{{--                    </tr>--}}
                    @endif

                @endforeach
                    <td>{{number_format($resultData['izneto'], 2, ',', '.')}}</td>
                    <td><b>{{number_format($resultData['izneto']/$counter, 2, ',', '.')}}</b></td>

                </tr>
                <tr>
                    <td><b>Neto:</b></td>

                @foreach($resultData as $data)
                    @if(is_array($data))
                        <td>{{number_format( $data['NETO'], 2, ',', '.')}}</td>

                            {{--                        resultData--}}
                        {{--                        radnikData--}}
                        {{--                    </tr>--}}
                    @endif
                @endforeach
                    <td>{{number_format($resultData['neto'], 2, ',', '.')}}</td>
                    <td><b>{{number_format($resultData['neto']/$counter, 2, ',', '.')}}</b></td>
                </tr>
{{--                {{number_format($vrstaPlacanja->iznos, 2, ',', '.')}}--}}
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

