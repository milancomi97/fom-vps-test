<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .table-container {
            width: 130%; /* Set your desired width */
            overflow-x: auto; /* Enable horizontal scrollbar */
        }
    </style>
@endsection

@section('content')
    <div class="container mb-5">
        <div class="content mb-5" >
            <h1 class="text-center">Arhiva matične datoteke za: <b>{{$archiveDate}}</b></h1>
     </div>
    </div>

    <div class="container">
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->
            <h1 class="text-center"> Matična datoteka radnika </h1>
            <div class="container mt-5">

                <div class="row justify-content-center">
                    <h3 id="error-validator-text" class="text-danger d-none font-weight-bold"></h3>

                    <form id="maticnadatotekaradnika" method="post"
                          action="{{ route('maticnadatotekaradnika.store')}}">
                        @csrf
                        <!-- 1. Maticni broj, Select option -->
                        <input type="hidden" name="user_id" id="user_id">



                       @foreach($arhivaMdr[0]->toArray() as $key=> $value)
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text font-weight-bold"
                                          id="{{$key}}">{{$key}}</span>
                                </div>

                                <input type="text" class="form-control" disabled id="MBRD_maticni_broj"
                                       aria-describedby="{{$key}}"
                                       value="{{$value}}"
                                       name="MBRD_maticni_broj">
                            </div>
                        @endforeach


                        {{--                                <input type="hidden" id="prezime_value">--}}

                        {{--                                <input type="text" class="form-control" id="prezime" aria-describedby="prezime">--}}

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
    <script>

    </script>
@endsection

