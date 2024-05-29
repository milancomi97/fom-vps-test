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
        .form-control{
            width: 100%;
        }
        .custom-select{
            display: block;
        }

        .form-custom-checkbox{
            width: 30px;
            height: 30px;
            transform: scale(1.5);
            margin-top:0.5rem;
        }

        .form-check{
            padding-left: 0.5rem!important;
        }

        .button-container {
            display: flex;
            gap: 10px; /* Space between buttons */
            align-items: center; /* Aligns items vertically in the center */
            margin-top: 20px; /* Adjust margin to position the container */
        }

        .button-container .btn {
            margin: 0;
            padding: 10px 20px; /* Adjust padding as needed */
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
            @if(session('error'))
                <div style="color: red;text-align: center">
                    {{ session('error') }}
                </div>
            @endif
            <div class="container mt-5">
                <form method="POST" action="{{ route('radnici.store') }}" >

                     @csrf
                    <div class="form-group">
                        <label for="maticni_broj">Maticni Broj</label>
                        <input type="number" class="form-control" id="maticni_broj"  name="maticni_broj">
                    </div>
                    <!-- String -->
                    <div class="form-group">
                        <label for="prezime">Prezime</label>
                        <input type="text" class="form-control" id="prezime" name="prezime" >
                    </div>
                    <!-- String -->
                    <div class="form-group">
                        <label for="srednje_ime">Srednje Ime</label>
                        <input type="text" class="form-control" id="srednje_ime" name="srednje_ime"  >
                    </div>
                    <!-- String -->
                    <div class="form-group">
                        <label for="ime">Ime</label>
                        <input type="text" class="form-control" id="ime" name="ime" >
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="slika_zaposlenog">Slika Zaposlenog</label>
                        <input type="text" class="form-control" id="slika_zaposlenog" name="slika_zaposlenog" >
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="sifra_mesta_troska_id">Troškovno Mesto</label>
                        <select id="sifra_mesta_troska_id" class="custom-select form-control" name="sifra_mesta_troska_id">
                            <option value="">Izaberi troškovno mesto</option>
                            @foreach($troskMesta as $value => $label)
                                    <option  value="{{ $label['key'] }}">{{ $label['value'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- String -->
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" >
                    </div>

                    <!-- String -->
                    {{--                    <div class="form-group">--}}
                    {{--                        <label for="jmbg">JMBG</label>--}}
                    {{--                        <input type="text" class="form-control" id="jmbg" name="jmbg" minlength="10" maxlength="10"--}}
                    {{--                               value="{{$radnik->jmbg}}">--}}
                    {{--                    </div>--}}
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
                    {{--                    <div class="form-group">--}}
                    {{--                        <label for="adresa_ulica_broj">Adresa Ulica Broj</label>--}}
                    {{--                        <input type="text" class="form-control" id="adresa_ulica_broj" name="adresa_ulica_broj"--}}
                    {{--                               value="{{$radnik->adresa_ulica_broj}}"--}}
                    {{--                        >--}}
                    {{--                    </div>--}}

                    <!-- UnsignedBigInteger -->
                    {{--                    <div class="form-group">--}}
                    {{--                        <label for="opstina_id">Opstina</label>--}}
                    {{--                        <select id="opstina_id" class="custom-select form-control" name="opstina_id">--}}
                    {{--                            @foreach($opstine as $value => $label)--}}
                    {{--                                @if($value ==$radnik->opstina_id)--}}
                    {{--                                    <option selected value="{{ $value }}">{{ $label['value'] }}</option>--}}
                    {{--                                @else--}}
                    {{--                                    <option  value="{{ $value }}">{{ $label['value'] }}</option>--}}
                    {{--                                @endif--}}
                    {{--                            @endforeach--}}
                    {{--                        </select>--}}
                    {{--                    </div>--}}

                    {{--                    <div class="form-group">--}}
                    {{--                        <label for="drzava_id">Država</label>--}}
                    {{--                        <select id="drzava_id" class="custom-select form-control" name="drzava_id">--}}
                    {{--                            @foreach($drzave as $value => $label)--}}
                    {{--                                @if($value ==$radnik->drzava_id)--}}
                    {{--                                    <option selected value="{{ $value }}">{{ $label }}</option>--}}
                    {{--                                @else--}}
                    {{--                                    <option  value="{{ $value }}">{{ $label }}</option>--}}
                    {{--                                @endif--}}
                    {{--                            @endforeach--}}
                    {{--                        </select>--}}
                    {{--                    </div>--}}

                    <!-- UnsignedBigInteger -->
                    <div class="form-group">
                        <label for="status_ugovor_id">Broj ugovora o radu</label>
                        <input type="number" class="form-control" id="status_ugovor_id" name="status_ugovor_id">
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="datum_zasnivanja_radnog_odnosa">Datum Zasnivanja Radnog Odnosa
                        </label>
                        <input type="date" class="form-control date" id="datum_zasnivanja_radnog_odnosa"
                               name="datum_zasnivanja_radnog_odnosa" onkeydown="return false" >
                    </div>

                    <!-- Date -->
                    <div class="form-group">
                        <label for="datum_prestanka_radnog_odnosa">Datum Prestanka Radnog Odnosa
                        </label>
                        <input type="date" class="form-control date " id="datum_prestanka_radnog_odnosa" onkeydown="return false"
                               name="datum_prestanka_radnog_odnosa">
                    </div>


                    <!-- Boolean -->
                    <div class="form-group">
                        <label  for="active">Aktivan</label>
                        <div class="form-check">


                            <input type="checkbox"
                                   checked
                                   class="form-control form-custom-checkbox" id="active" name="active">
                        </div>
                    </div>
                    <div class="button-container mt-5 mb-5">
                        <a href="{{route('radnici.index')}}" class="btn btn-outline-secondary">Tabela radnika</a>
                        <button type="submit" class="btn btn-primary">Sačuvaj</button>

                    </div>
        </form>
        </div>

        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
@endsection

