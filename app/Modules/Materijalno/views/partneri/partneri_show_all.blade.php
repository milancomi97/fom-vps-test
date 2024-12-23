@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
@endsection

@section('content')
    @if(Session::has('message'))
        <p class="alert alert-remove alert-success text-center">{{ Session::get('message') }}</p>
    @endif

    <style>

        .custom-select {
            width: 4em !important;
        }
        @media only screen and (max-width: 768px) {

            .title-mobile {
                text-align: center;
                margin-bottom: 30px !important;
                font-size: 30px !important;
            }
            .button-margin-mobile{

            }
        }

        @media only screen and (max-width: 992px) {

            .title-tablet {

                margin-bottom:30px !important
            }

        }

    </style>
    <div class="content-wrapper" style="min-height: 2080.12px;">
        <section class="content-header">
            <div class="container-fluid pl-5">
                <div class="row mb-2 mt-5">
                    <div class="col-lg-12 mb-5">
                        <h1 class="title-mobile title-tablet title text-center ">Pregled poslovnih partnera</h1>
                    </div>
                    <div class="col-lg-12 ">
                        <div class="row">
                            <div class="col-lg-2 col-sm-2 col-3" style=" display: flex; justify-content: flex-start;">
                                <button class="btn btn-primary"><a class="text-light" target="_blank"
                                                                   href="https://www.apr.gov.rs/%d0%bf%d0%be%d1%87%d0%b5%d1%82%d0%bd%d0%b0.3.html">Otvori
                                        APR</a>
                                </button>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-3" style=" display: flex; justify-content: flex-start;">

                                <button class="btn btn-primary"><a class="text-light" target="_blank"
                                                                   href="https://www.apr.gov.rs/%d0%bf%d0%be%d1%87%d0%b5%d1%82%d0%bd%d0%b0.3.html">Otvori
                                        NBS</a>
                                </button>
                            </div>
                            <div class="col-lg-4 offset-lg-4 offset-sm-0 offset-md-0 col-6 offset-0" style=" display: flex; justify-content: flex-end;">
                                <button class="btn btn-success"><a class="text-light"
                                                                   href="{{route('partner.create')}}">Dodaj novog
                                        &nbsp; &nbsp; <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>

                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content ">
            <div class="container-fluid pl-5">
                <table id="table_id" class="display" style="width:100%">
                    <form class="delete-form">{!! csrf_field() !!}</form>
                </table>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->
@endsection


@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {


            var table = $('#table_id').DataTable({
                data: {!! $partners !!},
                scrollX: true,
                decimal: ",",
                language: {
                    search: '<i class="fas fa-search"></i>&nbsp;&nbsp;&nbsp;&nbsp;Pretraga&nbsp;:',
                    info: "_START_ - _END_ od ukupno _TOTAL_ poslovnih partnera",
                    lengthMenu: "Prikaži &nbsp;&nbsp; _MENU_ ",
                    infoFiltered: "(Filtrirano od _MAX_ ukupno poslovnih partnera)",
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
                        title: 'Interna sifra '
                    },
                    {
                        title: 'Naziv'
                    },
                    {title: 'Skraćeni naziv'},
                    {title: 'Pib'},
                    {
                        title: 'Aktivan',
                        render: function (data, type) {
                            return data ?  '<i class="fa fa-circle" style="color: #28A745; font-size: 2em; margin-left: 13%;"><i class="d-none">' + data + '</i></i>' :
                                '<i class="fas fa-circle fa-xl" style="color: #ff0000; font-size: 2em; margin-left: 13%;"><i class="d-none">' + data + '</i></i>' ;
                        }
                    },
                    {
                        title: 'Email',
                        render: function (data, type) {
                            return '<i class="fa fa-envelope" aria-hidden="true"><a class="text-secondary" href = "mailto: ' + data + '">&nbsp;' + data + ' </a></i>'
                        }
                    },
                    {
                        title: 'Website',
                        render: function (data, type) {
                            return '<a href="' + data + '">' + data + '</a>'
                        }
                    },
                    {
                        title: 'Action',
                        render: function (data, type) {
                            var partnerUrl = "{!! url('partner/') !!}" + '/' + data + '/edit';
                            return '<div class="row"><div class="col-lg-5 pb-1"><button type="button" class="btn btn-outline-light remove" data-id="' + data + '" ><i class="fa fa-trash"  data-id="' + data + '"   style="font-size: 1em; color: #212529;"  aria-hidden="true"></i></button></div>' +
                                '<a href="' + partnerUrl + '"><div class="col-lg-5"><button type="button" class="btn btn-outline-light"><i class="fas fa-edit edit" data-id="' + data + '" style="font-size: 1em; color: #007BFF;"  aria-hidden="true"></i></button></div></div></a>'
                        }
                    }
                ],
            });


            $("#table_id").on("click", ".remove", function (e) {

                e.preventDefault();
                e.stopImmediatePropagation();
                var self = e;
                var tr = $(this).parents('tr')[0];
                var partnerName = $(tr).children().eq(1).text()

                Swal.fire({
                    title: 'Da li želite da obrišete?',
                    text: partnerName,
                    icon: 'warning',
                    confirmButtonText: 'Obriši',
                    cancelButtonText: 'Odustani',
                    showCancelButton: true,
                    showCloseButton: true,
                    confirmButtonColor: "#cc3f44",

                }).then((result) => {
                    if (result.isConfirmed) {
                        var partner_id = $(self.target).data('id')
                        var token = $('.delete-form').serializeArray()[0];

                        $.ajax({
                            url: '{{url('/partner/')}}/' + partner_id, // Replace with your server URL
                            type: 'DELETE',
                            data: {
                                '_token': token.value,
                                'partner_id': partner_id
                            },
                            success: function (response) {
                                Swal.fire('Podatak je uspešno obrisan obrisan!', partnerName, 'success')
                            },
                            error: function (xhr, status, error) {
                                console.log(xhr.responseText);
                            }
                        });

                        table.row($(this).parents('tr'))
                            .remove()
                            .draw();
                        // end ajax

                    }
                })
            });

            if ($('.alert-remove').length) {

                $('.alert-remove').on('click', function () {
                    setTimeout(() => {
                        $(this).fadeOut(10000, function () {
                            $(this).remove()
                        })
                    });
                });

                $('.alert-remove').click();
            }
            table.draw();
        });

    </script>
@endsection
