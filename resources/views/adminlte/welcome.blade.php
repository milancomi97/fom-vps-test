@extends('adminlte.layout.app')

@section('custom-styles')


@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content text-center ">
        <h3>Početna stranica</h3>
        <h3></h3>

        {{--        <img  class="img-fluid border" src="{{asset('images/diagrams/poentaza.jpg')}}">--}}

    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection


@section('custom-scripts')
    <script src="{{asset('admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

@endsection

