<!-- resources/views/stanje-zaliha/edit.blade.php -->

@extends('obracunzarada::theme.layout.app')

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

                            <!-- Add other fields as needed... -->

                            <button type="submit" class="btn btn-primary">Izmeni Stanje Zaliha</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
