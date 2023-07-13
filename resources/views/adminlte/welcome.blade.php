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
    <div class="content">
        <h3> Treba da osmislimo dokument o planu rada, sta smo uradili, na ovoj stranici ce da budu redirektovani posle registracije ili logovanja</h3>
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection


@section('custom-scripts')
    <script src="{{asset('admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

@endsection

