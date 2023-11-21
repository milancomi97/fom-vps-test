@extends('adminlte.layout.app')

@section('custom-styles')

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
                <h2 class="pb-5 pt-2 text-center">Izmeni poslovnog partnera</h2>
                <form>
                    {!! csrf_field() !!}
                    <!--Row 1-->
                    <input type="hidden" id="partner_id" name="partner_id" value="{{$partner->id}}">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="name">Naziv</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="Uneti pun naziv" value="{{$partner->name}}">
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="short_name">Skraćeni naziv </label>
                                <input type="text" class="form-control" name="short_name" id="short_name"
                                       value="{{$partner->short_name}}"
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
                                <input disabled type="text" class="form-control" name="internal_sifra" id="internal_sifra"
                                       value="{{$partner->internal_sifra}}"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">

                            <div class="form-group">
                                <label for="pib">PIB</label>
                                <input disabled type="text" class="form-control" id="pib" name="pib" placeholder=""
                                       value="{{$partner->pib}}"
                                >
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
                                       value="{{$partner->contact_employee}}"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="phone">Kontakt telefon</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder=""
                                       value="{{$partner->phone}}"
                                >
                            </div>
                        </div>
                    </div>
                    <!--Row 3 End-->

                    <!--Row 4-->
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="web_site">Web adresa</label>
                                <input type="text" class="form-control" name="web_site" id="web_site" placeholder=""
                                       value="{{$partner->web_site}}"
                                >
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder=""
                                       value="{{$partner->email}}"
                                >
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
                                       value="{{$partner->sifra_delatnosti}}"
                                       placeholder="">
                            </div>
                        </div>
                        <div class="col-md-5 offset-md-1">
                            <div class="form-group">
                                <label for="odgovorno_lice">Odgovorno lice</label>
                                <input type="text" class="form-control" name="odgovorno_lice" id="odgovorno_lice"
                                       value="{{$partner->odgovorno_lice}}"
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
                                       value="{{$partner->maticni_broj}}"
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
                                          placeholder="Adresa partnera">{{$partner->address}}</textarea>

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="active">Aktivan Partner/Komitent</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="active"
                                     @if($partner->active) checked @endif
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
                                           @if($partner->pripada_pdvu) checked @endif
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
                                <button type="submit" class="btn btn-primary izmeni_partnera ml-2">Sačuvaj izmene</button>
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
        $(document).ready(function () {
            $('.izmeni_partnera').click(function (e) {
                e.preventDefault(); // Prevent the default form submission

                var partnerId =  $('#partner_id').val();
                // Collect the form data
                var data = $('form').serializeArray();
                var active = $('#active').is(":checked");
                var pripada_pdvu = $('#pripada_pdvu').is(":checked");

                console.log(active);
                data.push({name: 'active', value: active});
                data.push({name: 'pripada_pdvu', value: pripada_pdvu});

                $.ajax({
                    url: '{{ url('partner') }}'+'/'+partnerId, // Replace with your server URL
                    type: 'PATCH', // Use POST method to send data
                    data: $.param(data),
                    success: function (response) {
                        window.location.href = '{{route('radnici.index')}}'
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>

@endsection

