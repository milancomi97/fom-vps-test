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
        <div class="content pl-5 pr-5 ">
            <div class="container pl-5 pr-5 border">

                <h2 class="pb-5 pt-2 text-center">Partneri</h2>
                <form>
                    <!--Row 1-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Naziv</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="short_name">Skraceni naziv</label>
                                <input type="text" class="form-control" name="short_name" id="short_name"
                                       placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 1 End-->

                    <!--Row 2-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="adress">Adresa</label>
                                <input type="text" class="form-control" name="adress" id="adress" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_employee">Kontakt osoba</label>
                                <input type="text" class="form-control" name="contact_employee" id="contact_employee"
                                       placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 2 End-->

                    <!--Row 3-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pib">Pib</label>
                                <input type="text" class="form-control" id="pib" name="pib" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Telefoni</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 3 End-->


                    <!--Row 4-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="web_site">Web adresa</label>
                                <input type="text" class="form-control" name="web_site" id="web_site" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 4 End-->


                    <!--Row 5-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sifra_delatnosti">Sifra delatnosti</label>
                                <input type="text" class="form-control" name="sifra_delatnosti" id="sifra_delatnosti"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="odgovorno_lice">Odgovorno lice</label>
                                <input type="text" class="form-control" name="odgovorno_lice" id="odgovorno_lice"
                                       placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 5 End-->

                    <!--Row 6-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="maticni_broj">Maticni broj</label>
                                <input type="text" class="form-control" id="maticni_broj" name="maticni_broj"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="registarski_broj">Registarski broj</label>
                                <input type="text" class="form-control" name="registarski_broj" id="registarski_broj"
                                       placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 6 End-->


                    <!-- Repeat the above row for Text Fields 3-12 -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mesto">Mesto</label>
                                <select class="form-control" name="mesto" id="mesto">
                                    <option value="">Izaberi grad</option>
                                    <option value="">Svilajnac</option>
                                    <option value="">Smederevska Palanka</option>
                                    <option value="">Velika Plana</option>
                                    <!-- Add your options here -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pripada_pdvu">Komitent je u sistemu PDV-a</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pripada_pdvu"
                                           id="pripada_pdvu">
                                    <label class="form-check-label" for="checkbox1">
                                        Komitent je u sistemu PDV-a
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th>Racun</th>
                            <th>Naziv banke</th>
                            <th>Sediste banke</th>
                            <th>Prioriteti</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                            <td>Data 4</td>
                        </tr>
                        <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-end">
                                <button type="button" class="btn btn-primary">Novi racun</button>
                                <button type="button" class="btn btn-secondary">Izmeni racun</button>
                                <button type="button" class="btn btn-success">Obrisi racun</button>
                            </div>
                        </div>
                    </div>

                    <div class="row pt-5">
                        <div class="col-md-12">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary dodaj_partnera">Potvrdi</button>
                                <button type="submit" class="btn btn-danger">Odustani</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section('custom-scripts')
    <script>
        $(document).ready(function() {
            $('.dodaj_partnera').click(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Collect the form data
                var formData = $('form').serialize();

                $.ajax({
                    url: '{{ route('dodaj.partnera') }}', // Replace with your server URL
                    type: 'POST', // Use POST method to send data
                    data: formData,
                    success: function(response) {
                        // Handle the success response
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle the error
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
    <script src="{{asset('admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

@endsection

