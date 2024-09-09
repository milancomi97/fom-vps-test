<!-- resources/views/materijal/create.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
{{--    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">--}}

@endsection
    @section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dodaj novi Materijal</div>

                    <div class="card-body">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif

                        <form action="{{ route('materijal.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="category_id">Kategorija</label>
                                <!-- Add class 'select2' to enable Select2 on this element -->
                                <select name="category_id" id="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                                    <option value="">Odaberi kategoriju</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sifra_materijala">Sifra materijala</label>
                                <input type="text" name="sifra_materijala" id="sifra_materijala" class="form-control @error('sifra_materijala') is-invalid @enderror">
                                @error('sifra_materijala')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="naziv_materijala">Naziv materijala</label>
                                <input type="text" name="naziv_materijala" id="naziv_materijala" class="form-control @error('naziv_materijala') is-invalid @enderror">
                                @error('naziv_materijala')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="standard">Standard</label>
                                <input type="text" name="standard" id="standard" class="form-control @error('standard') is-invalid @enderror">
                                @error('standard')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="dimenzija">Dimenzija</label>
                                <input type="text" name="dimenzija" id="dimenzija" class="form-control @error('dimenzija') is-invalid @enderror">
                                @error('dimenzija')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="kvalitet">Kvalitet</label>
                                <input type="text" name="kvalitet" id="kvalitet" class="form-control @error('kvalitet') is-invalid @enderror">
                                @error('kvalitet')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="jedinica_mere">Jedinica mere</label>
                                <input type="text" name="jedinica_mere" id="jedinica_mere" class="form-control @error('jedinica_mere') is-invalid @enderror">
                                @error('jedinica_mere')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tezina">Težina</label>
                                <input type="number" step="0.01" name="tezina" id="tezina" class="form-control @error('tezina') is-invalid @enderror">
                                @error('tezina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="sifra_standarda">Sifra standarda</label>
                                <input type="text" name="sifra_standarda" id="sifra_standarda" class="form-control @error('sifra_standarda') is-invalid @enderror">
                                @error('sifra_standarda')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="napomena">Napomena</label>
                                <textarea name="napomena" id="napomena" class="form-control @error('napomena') is-invalid @enderror"></textarea>
                                @error('napomena')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Dodaj Materijal</button>

                            <a href="{{route('materijal.index')}}" class="btn btn-success">Pregled materijala</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-scripts')
    <!-- Include jQuery -->
    <script src="{{asset('admin_assets/plugins/select2/js/select2.full.min.js')}}"></script>

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
