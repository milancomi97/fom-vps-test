@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .error {
            border: 1px solid red;
        }

        #errorContainer{
            color:red;
            text-align: center;
            font-size: 2em;
            margin-bottom: 2em;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper" style="height: auto">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="content pl-5 pr-5 ">
            <div class="container pl-5 pr-5 border">
                <h2 class="pb-5 pt-2 text-center">Dodaj materijal</h2>
                <div id="errorContainer"></div>

                <form id="create_partner_form">
                    {!! csrf_field() !!}
                    <!--Row 1-->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="name">Naziv</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="Uneti pun naziv">
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="short_name">Skraćeni naziv </label>
                                <input type="text" class="form-control" name="short_name" id="short_name"
                                       placeholder="Uneti skraćen naziv">
                            </div>
                        </div>
                    </div>
                    <!--Row 1 End-->
                    <!--Row 2-->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="internal_sifra">Interna šifra</label>
                                <input type="text" class="form-control" name="internal_sifra" id="internal_sifra"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">

                            <div class="form-group">
                                <label for="pib">PIB</label>
                                <input type="text" class="form-control" id="pib" name="pib" placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 2 End-->
                    <!--Row 3-->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="contact_employee">Kontakt osoba</label>
                                <input type="text" class="form-control" name="contact_employee" id="contact_employee"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="phone">Kontakt telefon</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 3 End-->

                    <!--Row 4-->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="web_site">Web adresa</label>
                                <input type="text" class="form-control" name="web_site" id="web_site" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 4 End-->

                    <!--Row 5-->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="sifra_delatnosti">Šifra delatnosti</label>
                                <input type="text" class="form-control" name="sifra_delatnosti" id="sifra_delatnosti"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
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
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="maticni_broj">Matični broj</label>
                                <input type="text" class="form-control" id="maticni_broj" name="maticni_broj"
                                       placeholder="">
                            </div>
                        </div>
                    </div>
                    <!--Row 6 End-->
                    <!-- Repeat the above row for Text Fields 3-12 -->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="mesto">Grad</label>
                                <select class="form-control" name="mesto" id="mesto">
                                    <option value="1">Izaberi grad</option>
                                    <option value="2">Svilajnac</option>
                                    <option value="3">Smederevska Palanka</option>
                                    <option value="4">Velika Plana</option>
                                    <!-- Add your options here -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="address">Adresa</label>
                                <textarea class="form-control" id="address" name="address" rows="3"
                                          placeholder="Adresa partnera"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="active">Aktivan Partner/Komitent</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="active"
                                           id="active">
                                    <label class="form-check-label" for="checkbox1">
                                        Aktivan
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
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
                            <th>Račun</th>
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
                        <div class="col-md-5">
                            <div class="text-end">
                                <button type="button" class="btn btn-primary">Novi račun</button>
                                <button type="button" class="btn btn-secondary">Izmeni račun</button>
                                <button type="button" class="btn btn-success">Obrisi račun</button>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-5 mb-5">
                        <div class="col-md-12">
                            <div class="float-right">
                                <a href="{{route('radnici.index')}}"> <button type="button" class="btn btn-success">Nazad</button></a>
                                <button type="submit" class="btn btn-primary dodaj_partnera ml-2">Sačuvaj partnera</button>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('custom-scripts')
    <script>
        $(document).ready(function () {
            $('.dodaj_partnera').click(function (e) {
                e.preventDefault(); // Prevent the default form submission


                $('#errorContainer').empty();
                var isValid = true;
                $('#create_partner_form input[type="text"]').each(function () {

                    var fieldValue = $(this).val();
                    var fieldName= $(this).attr("name");
                    var requiredFields = ['name','short_name','internal_sifra'];

                    if (fieldValue === '') {
                        if(requiredFields.includes(fieldName)) {
                            $(this).addClass('error');
                            isValid = false;
                        }
                    }
                });
                if (isValid) {
                    // Perform Ajax request here
                    // Collect the form data
                    var data = $('form').serializeArray();

                    var active = $('#active').is(":checked");
                    var pripada_pdvu = $('#pripada_pdvu').is(":checked");

                    data.push({name: 'pripada_pdvu', value: pripada_pdvu});
                    data.push({name: 'active', value: active});

                    $.ajax({
                        url: '{{ route('radnici.store') }}', // Replace with your server URL
                        type: 'POST', // Use POST method to send data
                        data: $.param(data),
                        success: function (response) {

                            if(response.status===false){
                                var duplicateFieldName = response.duplicateFieldName;
                                var duplicateFieldValue = response.duplicateFieldValue;
                                var duplicateRecordNameValue = response.duplicateRecordNameValue;
                                var duplicateRecordId = response.duplicateRecordId;
                                Swal.fire({
                                    title: 'Duplikat',
                                    text: 'Partner sa '+duplicateFieldName+' : '+duplicateFieldValue+', već postoji kao '+duplicateRecordNameValue,
                                    icon: 'error',
                                    confirmButtonText: 'Izmeni '+duplicateRecordNameValue,
                                    cancelButtonText: 'Odustani',
                                    showCancelButton: true,
                                    showCloseButton: true,
                                    confirmButtonColor: "#198754",
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "{!! url('partner/') !!}" + '/' + duplicateRecordId + '/edit';
                                    }
                                });
                            }else{
                                window.location.href = '{{route('radnici.index')}}'
                            }

                        },
                        error: function (xhr, status, error) {
                            // Handle the error
                            console.log(xhr.responseText);
                        }
                    });


                } else {
                    // Show error message
                    $('#errorContainer').text('Popuni polja.');
                }
            });

            $('#create_partner_form input[type="text"]').on('input', function () {
                $(this).removeClass('error');
            });
        });
    </script>

@endsection

