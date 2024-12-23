<?php use App\Modules\Obracunzarada\Consts\UserRoles; ?>
@extends('obracunzarada::theme.layout.app')


@section('custom-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
<style>
    div.dataTables_length select{
        width: 40% !important;
        text-align: center !important;
    }


</style>
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
            <h1 class="text-center"> Pregled radnika </h1>
            <div class="container" >
                    <table id="table_id" class="display" style="width:100%">
                        <form class="delete-form">{!! csrf_field() !!}</form>
                    </table>
                </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection


@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {


            var table = $('#table_id').DataTable({
                data: {!! $users !!},
                "order": [[ 4, "desc" ]],
                scrollX: false,
                decimal: ",",
                language: {
                    search: '<i class="fas fa-search"></i>&nbsp;&nbsp;&nbsp;&nbsp;Pretraga&nbsp;:',
                    info: "_START_ - _END_ od ukupno _TOTAL_ radnika",
                    lengthMenu: "Prikaži &nbsp;&nbsp; _MENU_ &nbsp;&nbsp; radnika",
                    infoFiltered: "(Filtrirano od _MAX_ ukupno radnika)",
                    paginate: {
                        first: "Prvi",
                        previous: "Prošla lista",
                        next: "Sledeća lista",
                        last: "Poslednji"
                    },
                },
                initComplete: function () {
                    this.api()
                        .columns()
                        .every(function () {
                            var column = this;
                            var title = column.header().textContent;

                            if(title!=='Izmene'){

                                // Create input element and add event listener
                                $('<input type="text"/>')
                                    .appendTo($(column.header()))
                                    .on('keyup change clear', function () {
                                        if (column.search() !== this.value) {
                                            column.search(this.value).draw();
                                        }
                                    });
                            }

                        });

                },
                columns: [
                    {
                        title: 'Matični broj'
                    },
                    {
                        title: 'Prezime'
                    },
                    {title: 'Ime'},
                    {
                        title: 'Aktivan KADR',
                        className: 'myCustomClass',
                        render: function (data, type) {
                            return data ?  '<i class="fa fa-circle" style="color: #28A745; font-size: 2em; margin-left: 13%;"><i class="d-none">' + data + '</i></i>' :
                                '<i class="fas fa-circle fa-xl" style="color: #ff0000; font-size: 2em; margin-left: 13%;"><i class="d-none">' + data + '</i></i>' ;
                        }
                    },
                    {
                        title: 'Izmene',
                        render: function (data, type) {
                            var userUrl = "{!! url('user/permissions_config_by_user?user_id=')!!}"+ data;
                            var editUrl = "{!! url('osnovnipodaci/radnici/edit_table?user_id=')!!}"+ data;
                            var editMdrUrl = "{!! url('obracunzarada/maticnadatotekaradnika/edit_by_userId?user_id=')!!}"+ data;
                            var permissionSetup ='{!! auth()->user()->permission->role_id===UserRoles::SUPERVIZOR || auth()->user()->permission->role_id===UserRoles::PROGRAMER ? '':'d-none' !!}'
                            return `<div class="d-flex flex-row align-items-start">
                                <a href="${userUrl}" class="${permissionSetup}">
                                    <button type="button" class="btn btn-outline-light mb-2">
                                        <i class="fas fa-lock edit" data-id="' + data + '" style="font-size: 1em; color: #007BFF;" aria-hidden="true"></i>
                                    </button>PRIS</a>
                                <a href="${editUrl}">
                                    <button type="button" class="btn btn-outline-light mb-2">
                                        <i class="fas fa-edit edit" data-id="' + data + '" style="font-size: 1em; color: #007BFF;" aria-hidden="true"></i>
                                    </button>KADR</a>
                                <a href="${editMdrUrl}">
                                    <button type="button" class="btn btn-outline-light mb-2">
                                        <i class="fas fa-edit edit" data-id="' + data + '" style="font-size: 1em; color: #ff0000;" aria-hidden="true"></i>
                                    </button>MDR</a>
                            </div>`
                            {{--''{{ route('radnamesta.edit', ['id' => $item->id]) }}--}}
                        }
                    }
                ],
            });

            table.draw();
            table.columns.adjust().draw()

        });



    </script>
@endsection
