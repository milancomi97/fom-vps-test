@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>

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
            <h1 class="text-center"> Pregled matične datoteke radnika</h1>
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
                data: {!! $maticnadatotekaradnika !!},
                scrollX: true,
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

                            if(title!=='Action'){

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
                    {
                        title: 'Ime'
                    },
                    {
                        title: 'Aktivan',
                        render: function (data, type) {
                            return data ?  '<i class="fa fa-circle" style="color: #28A745; font-size: 2em; margin-left: 13%;"><i class="d-none">' + data + '</i></i>' :
                                '<i class="fas fa-circle fa-xl" style="color: #ff0000; font-size: 2em; margin-left: 13%;"><i class="d-none">' + data + '</i></i>' ;
                        }
                    },
                    {
                        title: 'Action',
                        render: function (data, type) {
                            var editUrl = "{!! url('obracunzarada/maticnadatotekaradnika/edit?radnik_id=')!!}"+ data;

                            return '<a href="' + editUrl + '"><div class="col-lg-5"><button type="button" class="btn btn-outline-light"><i class="fas fa-edit edit" data-id="' + data + '" style="font-size: 1em; color: #0000CO;"  aria-hidden="true"></i></button></div></div></a>'
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
