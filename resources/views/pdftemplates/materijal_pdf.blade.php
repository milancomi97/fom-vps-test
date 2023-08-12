<!DOCTYPE html>
<html>
<head>
    <title>Laravel Blade Table Example</title>
</head>
<body>

<style>
    .page-break {
        page-break-after: always;
    }
    table, th, td {
        border: 1px solid;
    }
    .title{
        text-align: center;
    }
</style>
{{--<div class="page-break"></div>--}}
<div class="container">
    <h1 class="title">Konacan izveštaj materijala</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Naziv Materijala</th>
            <th>Šifra</th>
            <th>Identifikacini broj</th>
            <th>Dimenzija</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $materijal)
            <tr>
                <td>{{ $materijal['naziv_materijala'] }}</td>
                <td>{{ $materijal['sifra_materijala'] }}</td>
                <td>{{ $materijal['id'] }}</td>
                <td>{{ $materijal['dimenzija'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>

</html>
