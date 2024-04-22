@extends('coremodule::adminlte.layout.app')

<div class="container">
    <h1 class="text-center mb-4">Vraćanje podataka</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">

    <form action="{{ route('backup.import') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="file">Izaberite backup:</label>
            <select name="file" id="file" class="form-control">
                @foreach ($files as $file)
                    <option value="{{ $file }}">{{ $file }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Vrati podatke</button>
    </form>
    </div>
    </div>
</div>

