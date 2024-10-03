<!-- resources/views/stanje-zaliha/index.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')

@endsection

@section('content')
    <div class="container">
        <h1>Prikaz materijala po magacinima</h1>

        <form method="POST" action="{{ route('materijal.pregled_diagram') }}">
            @csrf
            <div class="form-group">
{{--                <label for="sifra_materijala">Odaberite šifru materijala:</label>--}}
                <input type="hidden" name="sifra_materijala" id="sifra_materijala" class="form-control" value="{{ $selectedSifraMaterijala }}">
            </div>

            <div class="form-group">
                <label for="chartType">Odaberite tip grafikona:</label>
                <select name="chartType" id="chartType" class="form-control">
                    <option value="bar" {{ $selectedChartType == 'bar' ? 'selected' : '' }}>Bar Chart</option>
                    <option value="line" {{ $selectedChartType == 'line' ? 'selected' : '' }}>Line Chart</option>
                    <option value="pie" {{ $selectedChartType == 'pie' ? 'selected' : '' }}>Pie Chart</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Prikaži</button>
        </form>

        <div class="mt-5">
            <canvas id="materijalChart"></canvas>
        </div>

        <!-- Tabelarni prikaz materijala sa istom šifrom -->
        <div class="mt-5">
            <h2>Materijali sa šifrom: {{ $selectedSifraMaterijala }}</h2>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Naziv materijala</th>
                    <th>Šifra materijala</th>
                    <th>Magacin</th>
                    <th>Standard</th>
                    <th>Dimenzija</th>
                    <th>Količina</th>
                    <th>Vrednost</th>
                </tr>
                </thead>
                <tbody>
                @foreach($materijali as $stanje)
                    <tr>
                        <td>{{ $stanje->materijal->id }}</td>
                        <td>{{ $stanje->materijal->naziv_materijala }}</td>
                        <td>{{ $stanje->sifra_materijala }}</td>
                        <td>{{ $stanje->magacin->naziv ?? 'N/A' }}</td>
                        <td>{{ $stanje->materijal->standard }}</td>
                        <td>{{ $stanje->materijal->dimenzija }}</td>
                        <td>{{ $stanje->kolicina }}</td>
                        <td>{{ $stanje->vrednost }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>    </div>



@endsection

@section('custom-scripts')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('materijalChart').getContext('2d');

            var chartData = {!! json_encode($chartData) !!};

            var labels = Object.keys(chartData);
            var data = labels.map(function (key) {
                return chartData[key].kolicina; // or vrednost
            });

            var chartType = '{{ $selectedChartType }}';

            new Chart(ctx, {
                type: chartType,
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Količina po magacinima',
                        data: data,
                        backgroundColor: '#4CAF50',
                        borderColor: '#388E3C',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endsection
