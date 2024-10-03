<!-- resources/views/stanje-zaliha/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css"/>
    <style>
        div.dataTables_length select{
            width: 40% !important;
            text-align: center !important;
        }

        .container-fluid{
            width: 80%!important;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <form>
            @csrf
        </form>


        @include('materijalno::vertical_nav_magacin')

        <!-- Dinamičko učitavanje sadržaja taba -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="kartice" role="tabpanel" aria-labelledby="kartice-tab">
                <h3 class="text-center mt-4">Kartice</h3>
                <table id="karticeTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Id Broj</th>
                        <th>Ukupna vrednost</th>
                        <th>Pregled dokumenta</th>
                    </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>


@endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        function postMaterijalno(idbr) {
            // Example data to send in POST request
            const data = { idbr: idbr };

            var _token = $('input[name="_token"]').val();


            $.ajax({
                url: '/materijalno/kartica/id', // Replace with your server URL
                type: 'POST', // Use POST method to send data
                data:{
                    idbr: idbr,
                    _token: _token
                },
                success: function (response) {
                    window.location.href = `/materijalno/kartica/${response.id}/pregled`; // Navigate after success

                },
            });
        }

        $(document).ready(function () {

            $('#karticeTable').DataTable({
                ajax: '{{ route('kartice.data') }}',
                columns: [
                    { data: 'idbr' },
                    { data: 'sum_total_vrednost' },
                    {
                        data: 'idbr',
                        title: 'Link',
                        render: function (data, type, row) {
                            // Prikaz linka koji vodi na stranicu sa detaljima kartice


                            return `<button class="btn btn-link" onclick="postMaterijalno('${row.idbr}')">${data}</button>`;
                        }
                    },
                ]
            });

        });
    </script>
@endsection
