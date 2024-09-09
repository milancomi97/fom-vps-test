<!-- resources/views/stanje-zaliha/create.blade.php -->

@extends('obracunzarada::theme.layout.app')

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

                            <div class="form-group">
                                <label for="sifra_materijala">Materijal</label>
                                <select name="sifra_materijala" id="sifra_materijala" class="form-control @error('sifra_materijala') is-invalid @enderror">
                                    <option value="">Odaberi materijal</option>
                                    @foreach($materijali as $materijal)
                                        <option value="{{ $materijal->sifra_materijala }}">{{ $materijal->naziv_materijala }}</option>
                                    @endforeach
                                </select>
                                @error('sifra_materijala')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Add other fields as needed... -->

                            <button type="submit" class="btn btn-primary">Dodaj Stanje Zaliha</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
