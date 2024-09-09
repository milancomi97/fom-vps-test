@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>
        .error {
            border: 1px solid red;
        }

        .infoAcc {
            margin-bottom: 0;
        }

        #errorContainer {
            color: red;
            text-align: center;
            font-size: 2em;
            margin-bottom: 2em;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->
            <h1 class="text-center"> Pregled podataka o firmi </h1>
            <div class="container mt-5">
                <form>
                    <!-- String -->
                    <div class="form-group">
                        <label for="naziv_firme">Naziv Firme</label>
                        <input type="text" class="form-control" id="naziv_firme" name="naziv_firme">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="poslovno_ime">Poslovno Ime</label>
                        <input type="text" class="form-control" id="poslovno_ime" name="poslovno_ime">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="skraceni_naziv_firme">Skraceni Naziv Firme</label>
                        <input type="text" class="form-control" id="skraceni_naziv_firme" name="skraceni_naziv_firme">
                    </div>

                    <!-- Boolean -->
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="status" name="status">
                            <label class="form-check-label" for="status">Status</label>
                        </div>
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="pravna_forma">Pravna Forma</label>
                        <input type="text" class="form-control" id="pravna_forma" name="pravna_forma">
                    </div>

                    <!-- Integer -->
                    <div class="form-group">
                        <label for="maticni_broj">Maticni Broj</label>
                        <input type="number" class="form-control" id="maticni_broj" name="maticni_broj">
                    </div>

                    <!-- Integer -->
                    <div class="form-group">
                        <label for="pib">PIB</label>
                        <input type="number" class="form-control" id="pib" name="pib">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="naziv_delatnosti">Naziv Delatnosti</label>
                        <input type="text" class="form-control" id="naziv_delatnosti" name="naziv_delatnosti">
                    </div>

                    <!-- Integer -->
                    <div class="form-group">
                        <label for="sifra_delatnosti">Sifra Delatnosti</label>
                        <input type="number" class="form-control" id="sifra_delatnosti" name="sifra_delatnosti">
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="datum_osnivanja">Datum Osnivanja</label>
                        <input type="date" class="form-control" id="datum_osnivanja" name="datum_osnivanja">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="adresa_sedista">Adresa Sedista</label>
                        <input type="text" class="form-control" id="adresa_sedista" name="adresa_sedista">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="naziv_opstine">Naziv Opstine</label>
                        <input type="text" class="form-control" id="naziv_opstine" name="naziv_opstine">
                    </div>

                    <!-- Integer -->
                    <div class="form-group">
                        <label for="sifra_opstine">Sifra Opstine</label>
                        <input type="number" class="form-control" id="sifra_opstine" name="sifra_opstine">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="ulica_broj_slovo">Ulica i Broj</label>
                        <input type="text" class="form-control" id="ulica_broj_slovo" name="ulica_broj_slovo">
                    </div>

                    <!-- Integer -->
                    <div class="form-group">
                        <label for="broj_poste">Broj Poste</label>
                        <input type="number" class="form-control" id="broj_poste" name="broj_poste">
                    </div>


                    <!-- String -->
                    <div class="form-group">
                        <label for="racuni_u_bankama">Računi u Bankama</label>
                        <input type="text" class="form-control" id="racuni_u_bankama" name="racuni_u_bankama">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="adresa_za_prijem_poste">Adresa za Prijem Pošte</label>
                        <input type="text" class="form-control" id="adresa_za_prijem_poste" name="adresa_za_prijem_poste">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="adresa_za_prijem_elektronske_poste">Adresa za Prijem Elektronske Pošte</label>
                        <input type="text" class="form-control" id="adresa_za_prijem_elektronske_poste" name="adresa_za_prijem_elektronske_poste">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="telefon">Telefon</label>
                        <input type="text" class="form-control" id="telefon" name="telefon">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="internet_adresa">Internet Adresa</label>
                        <input type="text" class="form-control" id="internet_adresa" name="internet_adresa">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="zakonski_zastupnik_ime_prezime">Zakonski Zastupnik</label>
                        <input type="text" class="form-control" id="zakonski_zastupnik_ime_prezime" name="zakonski_zastupnik_ime_prezime">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="zakonski_zastupnik_funkcija">Zakonski Zastupnik - Funkcija</label>
                        <input type="text" class="form-control" id="zakonski_zastupnik_funkcija" name="zakonski_zastupnik_funkcija">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="zakonski_zastupnik_jmbg">Zakonski Zastupnik - JMBG</label>
                        <input type="text" class="form-control" id="zakonski_zastupnik_jmbg" name="zakonski_zastupnik_jmbg">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="obaveznik_revizije" name="obaveznik_revizije">
                        <label class="form-check-label" for="obaveznik_revizije">Obaveznik Revizije</label>

                        </div>
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="velicina_po_razvrstavanju">Veličina Po Razvrstavanju</label>
                        <input type="text" class="form-control" id="velicina_po_razvrstavanju" name="velicina_po_razvrstavanju">
                    </div>
                    <div class="row">
                        <div class="col-12 text-center mt-2">
                            <button class="btn btn-success"><a class="text-light" href="{{route('firmapodaci.edit')}}">Izmeni</a></button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
@endsection

