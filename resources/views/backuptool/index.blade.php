
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* Add more styles as needed */
    </style>
</head>
<body>
<div class="container">
    <h1>Vraćanje podataka</h1>

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
</body>
</html>
