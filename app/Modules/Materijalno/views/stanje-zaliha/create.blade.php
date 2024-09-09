<!-- resources/views/stanje-zaliha/create.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <!-- Include Select2 CSS for searchable dropdowns -->
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dodaj Stanje Zaliha</div>

                    <div class="card-body">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif

                        <form action="{{ route('stanje-zaliha.store') }}" method="POST">
                            @csrf

                            <!-- Materijal selection -->
                            <div class="form-group">
                                <label for="sifra_materijala">Materijal</label>
                                <select name="sifra_materijala" id="sifra_materijala" class="form-control select2 @error('sifra_materijala') is-invalid @enderror">
                                    <option value="">Odaberi materijal</option>
                                    @foreach($materijali as $materijal)
                                        <option value="{{ $materijal->sifra_materijala }}" {{ old('sifra_materijala') == $materijal->sifra_materijala ? 'selected' : '' }}>
                                            {{ $materijal->naziv_materijala }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sifra_materijala')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Magacin selection -->
                            <div class="form-group">
                                <label for="magacin_id">Magacin</label>
                                <select name="magacin_id" id="magacin_id" class="form-control select2 @error('magacin_id') is-invalid @enderror">
                                    <option value="">Odaberi magacin</option>
                                    @foreach($magacini as $magacin)
                                        <option value="{{ $magacin->id }}" {{ old('magacin_id') == $magacin->id ? 'selected' : '' }}>
                                            {{ $magacin->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('magacin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Other fields -->
                            <div class="form-group">
                                <label for="naziv_materijala">Naziv materijala</label>
                                <input type="text" name="naziv_materijala" class="form-control @error('naziv_materijala') is-invalid @enderror" value="{{ old('naziv_materijala') }}">
                                @error('naziv_materijala')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Repeat similar structure for all other fields -->
                            <!-- Standard -->
                            <div class="form-group">
                                <label for="standard">Standard</label>
                                <input type="text" name="standard" class="form-control @error('standard') is-invalid @enderror" value="{{ old('standard') }}">
                                @error('standard')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Dimenzija -->
                            <div class="form-group">
                                <label for="dimenzija">Dimenzija</label>
                                <input type="text" name="dimenzija" class="form-control @error('dimenzija') is-invalid @enderror" value="{{ old('dimenzija') }}">
                                @error('dimenzija')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kvalitet -->
                            <div class="form-group">
                                <label for="kvalitet">Kvalitet</label>
                                <input type="text" name="kvalitet" class="form-control @error('kvalitet') is-invalid @enderror" value="{{ old('kvalitet') }}">
                                @error('kvalitet')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jedinica mere -->
                            <div class="form-group">
                                <label for="jedinica_mere">Jedinica mere</label>
                                <input type="text" name="jedinica_mere" class="form-control @error('jedinica_mere') is-invalid @enderror" value="{{ old('jedinica_mere') }}">
                                @error('jedinica_mere')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Konto -->
                            <div class="form-group">
                                <label for="konto">Konto</label>
                                <input type="text" name="konto" class="form-control @error('konto') is-invalid @enderror" value="{{ old('konto') }}">
                                @error('konto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Numeric fields -->
                            <!-- pocst_kolicina -->
                            <div class="form-group">
                                <label for="pocst_kolicina">Početna količina</label>
                                <input type="number" step="0.01" name="pocst_kolicina" class="form-control @error('pocst_kolicina') is-invalid @enderror" value="{{ old('pocst_kolicina') }}">
                                @error('pocst_kolicina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- pocst_vrednost -->
                            <div class="form-group">
                                <label for="pocst_vrednost">Početna vrednost</label>
                                <input type="number" step="0.01" name="pocst_vrednost" class="form-control @error('pocst_vrednost') is-invalid @enderror" value="{{ old('pocst_vrednost') }}">
                                @error('pocst_vrednost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ulaz_kolicina -->
                            <div class="form-group">
                                <label for="ulaz_kolicina">Ulaz količina</label>
                                <input type="number" step="0.01" name="ulaz_kolicina" class="form-control @error('ulaz_kolicina') is-invalid @enderror" value="{{ old('ulaz_kolicina') }}">
                                @error('ulaz_kolicina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ulaz_vrednost -->
                            <div class="form-group">
                                <label for="ulaz_vrednost">Ulaz vrednost</label>
                                <input type="number" step="0.01" name="ulaz_vrednost" class="form-control @error('ulaz_vrednost') is-invalid @enderror" value="{{ old('ulaz_vrednost') }}">
                                @error('ulaz_vrednost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- izlaz_kolicina -->
                            <div class="form-group">
                                <label for="izlaz_kolicina">Izlaz količina</label>
                                <input type="number" step="0.01" name="izlaz_kolicina" class="form-control @error('izlaz_kolicina') is-invalid @enderror" value="{{ old('izlaz_kolicina') }}">
                                @error('izlaz_kolicina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- izlaz_vrednost -->
                            <div class="form-group">
                                <label for="izlaz_vrednost">Izlaz vrednost</label>
                                <input type="number" step="0.01" name="izlaz_vrednost" class="form-control @error('izlaz_vrednost') is-invalid @enderror" value="{{ old('izlaz_vrednost') }}">
                                @error('izlaz_vrednost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- stanje_kolicina -->
                            <div class="form-group">
                                <label for="stanje_kolicina">Stanje količina</label>
                                <input type="number" step="0.01" name="stanje_kolicina" class="form-control @error('stanje_kolicina') is-invalid @enderror" value="{{ old('stanje_kolicina') }}">
                                @error('stanje_kolicina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- stanje_vrednost -->
                            <div class="form-group">
                                <label for="stanje_vrednost">Stanje vrednost</label>
                                <input type="number" step="0.01" name="stanje_vrednost" class="form-control @error('stanje_vrednost') is-invalid @enderror" value="{{ old('stanje_vrednost') }}">
                                @error('stanje_vrednost')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- cena -->
                            <div class="form-group">
                                <label for="cena">Cena</label>
                                <input type="number" step="0.01" name="cena" class="form-control @error('cena') is-invalid @enderror" value="{{ old('cena') }}">
                                @error('cena')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary">Dodaj Stanje Zaliha</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <!-- Include jQuery and Select2 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 on the dropdowns
            $('.select2').select2({
                placeholder: 'Odaberi opciju',
                allowClear: true
            });
        });
    </script>
@endsection
