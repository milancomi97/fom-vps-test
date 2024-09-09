@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
@endsection

@section('content')
    @if(Session::has('message'))
        <p class="alert alert-remove alert-success text-center">{{ Session::get('message') }}</p>
    @endif

    <div class="content-wrapper" style="min-height: 2080.12px;">
        <section class="content-header">
            <div class="container-fluid pl-5">
                <div class="row mb-2 mt-5">
                    <div class="col-lg-5">
                        <h1 class="title-mobile title-tablet title">Pregled materijala</h1>
                    </div>
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-lg-2 col-sm-2 col-3">
                                <button class="btn btn-primary">
                                    <a class="text-light" target="_blank" href="https://www.apr.gov.rs/početna.3.html">Otvori APR</a>
                                </button>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-3">
                                <button class="btn btn-primary">
                                    <a class="text-light" target="_blank" href="https://www.apr.gov.rs/početna.3.html">Otvori NBS</a>
                                </button>
                            </div>
                            <div class="col-lg-4 offset-lg-4 col-6">
                                <form name="export-pdf-form" id="export-pdf-form" method="post" action="{{ url('/materijals_pdf') }}">
                                    @csrf
                                    <input type="hidden" id="materijal_ids" name="materijal_ids">
                                    <button class="btn btn-secondary" type="submit">Export PDF &nbsp; <i class="fa fa-file-export"></i></button>
                                </form>
                                <a href="{{ route('materijal.create') }}" class="btn btn-success ml-2">Dodaj materijal &nbsp; <i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid pl-5">
                <table id="table_id" class="display" style="width:100%">
                    <form class="delete-form">{!! csrf_field() !!}</form>
                </table>
            </div>
        </section>
    </div>
@endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            var table = $('#table_id').DataTable({
                data: {!! $materijals !!},
                scrollX: true,
                decimal: ",",
                language: {
                    search: '<i class="fas fa-search"></i> Pretraga:',
                    info: "_START_ - _END_ od ukupno _TOTAL_ materijala",
                    lengthMenu: "Prikaži _MENU_ materijala",
                    infoFiltered: "(Filtrirano od _MAX_ materijala)",
                    paginate: {
                        first: "Prvi",
                        previous: "Prošla lista",
                        next: "Sledeća lista",
                        last: "Poslednji"
                    }
                },
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var title = column.header().textContent;
                        if(title !== 'Action') {
                            $('<input type="text" class="form-control"/>').appendTo($(column.header())).on('keyup change', function () {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                        }
                    });
                },
                columns: [
                    { title: 'Kategorija' },
                    { title: 'Sifra materijala' },
                    { title: 'Naziv materijala' },
                    { title: 'Standard' },
                    { title: 'Dimenzija' },
                    { title: 'Tezina' },
                    { title: 'Sifra standarda' },
                    {
                        title: 'Action',
                        render: function (data, type) {
                            var editUrl = "{!! url('materijalno/materijal/') !!}" + '/' + data + '/edit';
                            return `
                                <div class="row">
                                    <div class="col-lg-5 pb-1">
                                        <button type="button" class="btn btn-outline-light remove" data-id="${data}">
                                            <i class="fa fa-trash" style="color: #212529;"></i>
                                        </button>
                                    </div>
                                    <div class="col-lg-5">
                                        <a href="${editUrl}" class="btn btn-outline-light">
                                            <i class="fas fa-edit" style="color: #007BFF;"></i>
                                        </a>
                                    </div>
                                </div>`;
                        }
                    }
                ]
            });

            // Handle row deletion
            $("#table_id").on("click", ".remove", function (e) {
                e.preventDefault();
                var row = $(this).parents('tr');
                var materijalName = row.children().eq(1).text();
                var materijalId = $(this).data('id');

                Swal.fire({
                    title: 'Da li želite da obrišete?',
                    text: materijalName,
                    icon: 'warning',
                    confirmButtonText: 'Obriši',
                    cancelButtonText: 'Odustani',
                    showCancelButton: true,
                    confirmButtonColor: "#cc3f44"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ url('/materijal/') }}/${materijalId}`,
                            type: 'DELETE',
                            data: {
                                '_token': $('form.delete-form').find('input[name=_token]').val(),
                                'materijal_id': materijalId
                            },
                            success: function () {
                                Swal.fire('Podatak je uspešno obrisan!', materijalName, 'success');
                                table.row(row).remove().draw();
                            },
                            error: function () {
                                Swal.fire('Greška prilikom brisanja!', '', 'error');
                            }
                        });
                    }
                });
            });

            // Handle PDF export
            $("#export-pdf-form").submit(function () {
                var filteredDataIds = table.rows({ filter: 'applied' }).data().pluck(7).toArray();
                $("#materijal_ids").val(filteredDataIds);
                return true;
            });

            // Handle alert fading
            if ($('.alert-remove').length) {
                setTimeout(function () {
                    $('.alert-remove').fadeOut(10000, function () {
                        $(this).remove();
                    });
                }, 1000);
            }
        });
    </script>
@endsection
