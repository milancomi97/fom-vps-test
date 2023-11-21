@extends('osnovnipodaci::theme.layout.app')

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
            <h1 class="text-center"> Unos novog radnika </h1>
            <div class="container mt-5">
                <form method="POST" action="{{ route('radnici.store') }}" >

                     @csrf

                    <div class="form-group">
                        <label for="interni_maticni_broj">Maticni Broj</label>
                        <input type="number" class="form-control" id="interni_maticni_broj" name="interni_maticni_broj">
                    </div>
                    <!-- String -->
                    <div class="form-group">
                        <label for="prezime">Prezime</label>
                        <input type="text" class="form-control" id="prezime" name="prezime">
                    </div>
                    <!-- String -->
                    <div class="form-group">
                        <label for="srednje_ime">Srednje Ime</label>
                        <input type="text" class="form-control" id="srednje_ime" name="srednje_ime">
                    </div>
                    <!-- String -->
                    <div class="form-group">
                        <label for="ime">Ime</label>
                        <input type="text" class="form-control" id="ime" name="ime">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="slika_zaposlenog">Slika Zaposlenog</label>
                        <input type="text" class="form-control" id="slika_zaposlenog" name="slika_zaposlenog">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="troskovno_mesto">Troškovno Mesto</label>
                        <select id="troskovno_mesto" class="custom-select form-control" name="troskovno_mesto">
                            <option>Izaberi troškovno mesto</option>
                        @foreach($trosMesta as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="jmbg">JMBG</label>
                        <input type="text" class="form-control" id="jmbg" name="jmbg" minlength="10" maxlength="10"
                               value="">
                    </div>
                    <!-- String -->
                    <div class="form-group">
                        <label for="telefon_poslovni">Telefon Poslovni</label>
                        <input type="text" class="form-control" id="telefon_poslovni" name="telefon_poslovni">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="licna_karta_broj_mesto_rodjenja">Lična Karta Broj Mesto Rodjenja</label>
                        <input type="text" class="form-control" id="licna_karta_broj_mesto_rodjenja"
                               name="licna_karta_broj_mesto_rodjenja">
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="adresa_ulica_broj">Adresa Ulica Broj</label>
                        <input type="text" class="form-control" id="adresa_ulica_broj" name="adresa_ulica_broj">
                    </div>

                    <!-- UnsignedBigInteger -->
                    <div class="form-group">
                        <label for="opstina_id">Opstina</label>
                        <select id="opstina_id" class="custom-select form-control" name="opstina_id">
                            <option>Izaberi opštinu</option>
                            @foreach($gradovi as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="drzava_id">Država</label>
                        <select id="drzava_id" class="custom-select form-control" name="drzava_id">
{{--                            <option>Izaberi državu</option>--}}
                            @foreach($drzave as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- UnsignedBigInteger -->
                    <div class="form-group">
                        <label for="status_ugovor_id">Broj ugovora o radu</label>
                        <input type="number" class="form-control" id="status_ugovor_id" name="status_ugovor_id">
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="datum_zasnivanja_radnog_odnosa">Datum Zasnivanja Radnog Odnosa // IZMENITI FORMAT
                            DATUMA</label>
                        <input type="date" class="form-control date" id="datum_zasnivanja_radnog_odnosa"
                               name="datum_zasnivanja_radnog_odnosa">
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="datum_prestanka_radnog_odnosa">Datum Prestanka Radnog Odnosa // IZMENITI FORMAT
                            DATUMA</label>
                        <input type="date" class="form-control date" id="datum_prestanka_radnog_odnosa"
                               name="datum_prestanka_radnog_odnosa">
                    </div>

                    <!-- Boolean -->
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="active" name="active">
                            <label class="form-check-label" for="active">Aktivan</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Sačuvaj</button>
        </form>
        </div>

        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
@endsection

