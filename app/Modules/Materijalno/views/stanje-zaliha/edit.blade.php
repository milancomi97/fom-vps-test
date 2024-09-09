<!-- resources/views/stanje-zaliha/edit.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <!-- Include Select2 CSS for searchable dropdowns -->
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
@endsection
<!-- resources/views/stanje-zaliha/edit.blade.php -->

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Izmeni Stanje Zaliha</div>

                    <div class="card-body">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif

                        <form action="{{ route('stanje-zaliha.update', $stanjeZaliha->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="sifra_materijala">Materijal</label>
                                <select name="sifra_materijala" id="sifra_materijala" class="form-control @error('sifra_materijala') is-invalid @enderror">
                                    @foreach($materijali as $materijal)
                                        <option value="{{ $materijal->sifra_materijala }}" {{ $stanjeZaliha->sifra_materijala == $materijal->sifra_materijala ? 'selected' : '' }}>
                                            {{ $materijal->naziv_materijala }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sifra_materijala')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="naziv_materijala">Naziv Materijala</label>
                                <input type="text" name="naziv_materijala" class="form-control @error('naziv_materijala') is-invalid @enderror" value="{{ old('naziv_materijala', $stanjeZaliha->naziv_materijala) }}">
                                @error('naziv_materijala')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="magacin_id">Magacin</label>
                                <select name="magacin_id" id="magacin_id" class="form-control @error('magacin_id') is-invalid @enderror">
                                    @foreach($magacini as $magacin)
                                        <option value="{{ $magacin->id }}" {{ $stanjeZaliha->magacin_id == $magacin->id ? 'selected' : '' }}>
                                            {{ $magacin->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('magacin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="standard">Standard</label>
                                <input type="text" name="standard" class="form-control @error('standard') is-invalid @enderror" value="{{ old('standard', $stanjeZaliha->standard) }}">
                                @error('standard')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="dimenzija">Dimenzija</label>
                                <input type="text" name="dimenzija" class="form-control @error('dimenzija') is-invalid @enderror" value="{{ old('dimenzija', $stanjeZaliha->dimenzija) }}">
                                @error('dimenzija')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kvalitet">Kvalitet</label>
                                <input type="text" name="kvalitet" class="form-control @error('kvalitet') is-invalid @enderror" value="{{ old('kvalitet', $stanjeZaliha->kvalitet) }}">
                                @error('kvalitet')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jedinica_mere">Jedinica Mere</label>
                                <input type="text" name="jedinica_mere" class="form-control @error('jedinica_mere') is-invalid @enderror" value="{{ old('jedinica_mere', $stanjeZaliha->jedinica_mere) }}">
                                @error('jedinica_mere')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="konto">Konto</label>
                                <input type="text" name="konto" class="form-control @error('konto') is-invalid @enderror" value="{{ old('konto', $stanjeZaliha->konto) }}">
                                @error('konto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="pocst_kolicina">Početna Količina</label>
                                <input type="number" step="0.01" name="pocst_kolicina" class="form-control @error('pocst_kolicina') is-invalid @enderror" value="{{ old('pocst_kolicina', $stanjeZaliha->pocst_kolicina) }}">
                                @error('pocst_kolicina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="pocst_vrednost">Početna Vrednost</label>
                                <input type="number" step="0.01" name="pocst_vrednost" class="form-control @error('pocst_vrednost') is-invalid @enderror" value="{{ old('pocst_vrednost', $stanjeZaliha->pocst_vrednost) }}">
                                @error('pocst_vrednost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="ulaz_kolicina">Ulaz Količina</label>
                                <input type="number" step="0.01" name="ulaz_kolicina" class="form-control @error('ulaz_kolicina') is-invalid @enderror" value="{{ old('ulaz_kolicina', $stanjeZaliha->ulaz_kolicina) }}">
                                @error('ulaz_kolicina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="ulaz_vrednost">Ulaz Vrednost</label>
                                <input type="number" step="0.01" name="ulaz_vrednost" class="form-control @error('ulaz_vrednost') is-invalid @enderror" value="{{ old('ulaz_vrednost', $stanjeZaliha->ulaz_vrednost) }}">
                                @error('ulaz_vrednost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="izlaz_kolicina">Izlaz Količina</label>
                                <input type="number" step="0.01" name="izlaz_kolicina" class="form-control @error('izlaz_kolicina') is-invalid @enderror" value="{{ old('izlaz_kolicina', $stanjeZaliha->izlaz_kolicina) }}">
                                @error('izlaz_kolicina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="izlaz_vrednost">Izlaz Vrednost</label>
                                <input type="number" step="0.01" name="izlaz_vrednost" class="form-control @error('izlaz_vrednost') is-invalid @enderror" value="{{ old('izlaz_vrednost', $stanjeZaliha->izlaz_vrednost) }}">
                                @error('izlaz_vrednost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="stanje_kolicina">Stanje Količina</label>
                                <input type="number" step="0.01" name="stanje_kolicina" class="form-control @error('stanje_kolicina') is-invalid @enderror" value="{{ old('stanje_kolicina', $stanjeZaliha->stanje_kolicina) }}">
                                @error('stanje_kolicina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="stanje_vrednost">Stanje Vrednost</label>
                                <input type="number" step="0.01" name="stanje_vrednost" class="form-control @error('stanje_vrednost') is-invalid @enderror" value="{{ old('stanje_vrednost', $stanjeZaliha->stanje_vrednost) }}">
                                @error('stanje_vrednost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="cena">Cena</label>
                                <input type="number" step="0.01" name="cena" class="form-control @error('cena') is-invalid @enderror" value="{{ old('cena', $stanjeZaliha->cena) }}">
                                @error('cena')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Izmeni Stanje Zaliha</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
