<!-- resources/views/materijal/edit.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <!-- Include Select2 CSS for searchable category select -->
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Izmeni Materijal</div>

                    <div class="card-body">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif

                        <form action="{{ route('materijal.update', $materijal->id) }}" method="POST">
                            @csrf
                            @method('PUT')  <!-- We need to use the PUT method for updating -->

                            <div class="form-group">
                                <label for="category_id">Kategorija</label>
                                <select name="category_id" id="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                                    <option value="">Odaberi kategoriju</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $materijal->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sifra_materijala">Sifra materijala</label>
                                <input type="text" name="sifra_materijala" id="sifra_materijala" value="{{ old('sifra_materijala', $materijal->sifra_materijala) }}" class="form-control @error('sifra_materijala') is-invalid @enderror">
                                @error('sifra_materijala')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="naziv_materijala">Naziv materijala</label>
                                <input type="text" name="naziv_materijala" id="naziv_materijala" value="{{ old('naziv_materijala', $materijal->naziv_materijala) }}" class="form-control @error('naziv_materijala') is-invalid @enderror">
                                @error('naziv_materijala')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="standard">Standard</label>
                                <input type="text" name="standard" id="standard" value="{{ old('standard', $materijal->standard) }}" class="form-control @error('standard') is-invalid @enderror">
                                @error('standard')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="dimenzija">Dimenzija</label>
                                <input type="text" name="dimenzija" id="dimenzija" value="{{ old('dimenzija', $materijal->dimenzija) }}" class="form-control @error('dimenzija') is-invalid @enderror">
                                @error('dimenzija')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kvalitet">Kvalitet</label>
                                <input type="text" name="kvalitet" id="kvalitet" value="{{ old('kvalitet', $materijal->kvalitet) }}" class="form-control @error('kvalitet') is-invalid @enderror">
                                @error('kvalitet')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jedinica_mere">Jedinica mere</label>
                                <input type="text" name="jedinica_mere" id="jedinica_mere" value="{{ old('jedinica_mere', $materijal->jedinica_mere) }}" class="form-control @error('jedinica_mere') is-invalid @enderror">
                                @error('jedinica_mere')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tezina">Težina</label>
                                <input type="number" step="0.01" name="tezina" id="tezina" value="{{ old('tezina', $materijal->tezina) }}" class="form-control @error('tezina') is-invalid @enderror">
                                @error('tezina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sifra_standarda">Sifra standarda</label>
                                <input type="text" name="sifra_standarda" id="sifra_standarda" value="{{ old('sifra_standarda', $materijal->sifra_standarda) }}" class="form-control @error('sifra_standarda') is-invalid @enderror">
                                @error('sifra_standarda')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="napomena">Napomena</label>
                                <textarea name="napomena" id="napomena" class="form-control @error('napomena') is-invalid @enderror">{{ old('napomena', $materijal->napomena) }}</textarea>
                                @error('napomena')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Izmeni Materijal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 on the category dropdown
            $('.select2').select2({
                placeholder: 'Odaberi kategoriju',
                allowClear: true
            });
        });
    </script>
@endsection
