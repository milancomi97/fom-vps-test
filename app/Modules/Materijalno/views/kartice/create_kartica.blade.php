<!-- resources/views/materijal/create.blade.php -->

@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
{{--    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">--}}
<style>
    .materijal-group {
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #material-search-results .list-group-item {
        cursor: pointer;
    }
</style>
@endsection
    @section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
{{--            <div class="col-md-12">--}}
{{--                <div class="row">--}}
{{--                    <!-- Leva strana - Forma za unos materijala -->--}}
{{--                    <div class="col-md-6">--}}
{{--                        <form action="{{ route('materijalno.kartice.index') }}" method="POST">--}}
{{--                            @csrf--}}

{{--                            <div id="materijali-fields">--}}
{{--                                <!-- Dinamički dodati materijali će se ovde pojavljivati -->--}}
{{--                            </div>--}}

{{--                            <button type="submit" class="btn btn-primary">Sačuvaj karticu</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}

{{--                    <!-- Desna strana - Pretraga materijala iz StanjeZaliha -->--}}
{{--                    <div class="col-md-6">--}}
{{--                        <h3>Pretraga Materijala</h3>--}}
{{--                        <input type="text" id="search-material" class="form-control" placeholder="Pretraga po nazivu materijala">--}}

{{--                        <ul id="material-search-results" class="list-group mt-3">--}}
{{--                            <!-- Rezultati pretrage će se ovde prikazivati -->--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <form action="{{ route('materijalno.kartice.index') }}" method="POST">--}}
{{--                    @csrf--}}
{{--                 --}}
{{--                    <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--                </form>--}}

{{--            </div>--}}
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="row">
                        <form action="{{ route('materijalno.kartice.index') }}" method="POST">
                            @csrf
                        <div class="row">
                                <!-- sd -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sd">Šifra Dokumenta (SD):</label>
                                        <input type="text" name="sd" class="form-control" required>
                                    </div>
                                </div>

                                <!-- idbr -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="idbr">Identifikacioni Broj (IDBR):</label>
                                        <input type="text" name="idbr" class="form-control" required>
                                    </div>
                                </div>

                                <!-- poz -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="poz">Pozicija (POZ):</label>
                                        <input type="text" name="poz" class="form-control" required>
                                    </div>
                                </div>

                                <!-- datum_k -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="datum_k">Datum Knjiženja (DATUM_K):</label>
                                        <input type="date" name="datum_k" class="form-control" required>
                                    </div>
                                </div>

                                <!-- datum_d -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="datum_d">Datum Dokumenta (DATUM_D):</label>
                                        <input type="date" name="datum_d" class="form-control" required>
                                    </div>
                                </div>

                                <!-- konto -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="konto">Konto:</label>
                                        <input type="text" name="konto" class="form-control" required>
                                    </div>
                                </div>

                                <!-- tc -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tc">Troškovno Mesto (TC):</label>
                                        <input type="text" name="tc" class="form-control">
                                    </div>
                                </div>

                                <!-- poru -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="poru">Porudžbina (PORU):</label>
                                        <input type="text" name="poru" class="form-control">
                                    </div>
                                </div>

                                <!-- norma -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="norma">Norma:</label>
                                        <input type="text" name="norma" class="form-control">
                                    </div>
                                </div>

                                <!-- veza -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="veza">Veza sa Dokumentom (VEZA):</label>
                                        <input type="text" name="veza" class="form-control">
                                    </div>
                                </div>

                                <!-- mesec -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mesec">Mesec:</label>
                                        <input type="text" name="mesec" class="form-control">
                                    </div>
                                </div>

                                <!-- nal1 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nal1">Nalog 1 (NAL1):</label>
                                        <input type="text" name="nal1" class="form-control">
                                    </div>
                                </div>

                                <!-- nal2 -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nal2">Nalog 2 (NAL2):</label>
                                        <input type="text" name="nal2" class="form-control">
                                    </div>
                                </div>

                                <!-- gru -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gru">Grupa (GRU):</label>
                                        <input type="text" name="gru" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- Leva strana - Forma za unos materijala -->
<div class="row">
                            <div class="col-md-6">


                                    <div id="materijali-fields">
                                        <!-- Dinamički dodati materijali i njihova stanja zaliha će se ovde pojavljivati -->
                                    </div>

                            </div>
                            <div id="materijali-fields">
                                <!-- Dinamički dodati materijali i njihova stanja zaliha će se ovde pojavljivati -->
                            </div>
                            <!-- Desna strana - Pretraga materijala -->
                            <div class="col-md-6">
                                <h3>Pretraga Materijala</h3>
                                <input type="text" id="search-material" class="form-control" placeholder="Pretraga po nazivu materijala">

                                <ul id="material-search-results" class="list-group mt-3">
                                    <!-- Rezultati pretrage će se ovde prikazivati -->
                                </ul>
                            </div>
</div>

                            <div class="row">
                                <button type="submit" class="btn btn-primary">Sačuvaj karticu</button>

                            </div>
                        </form>

                    </div>


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
            // Aktiviraj pretragu materijala kada korisnik unese 3 ili više karaktera
            $('#search-material').on('input', function() {
                var query = $(this).val();

                if (query.length > 3) { // Pretraga se aktivira posle unosa 3 karaktera
                    $.ajax({
                        url: '{{route('materijalno.karticaSelectOption')}}',
                        method: 'GET',
                        data: { query: query },
                        success: function(data) {
                            var resultsList = $('#material-search-results');
                            resultsList.empty();

                            // Iteriraj kroz sve materijale koji odgovaraju pretrazi
                            $.each(data, function(index, material) {
                                var materialHtml = `
                                    <li class="list-group-item">
                                        ${material.naziv_materijala} (${material.sifra_materijala})
                                `;

                                // Iteriraj kroz stanja zaliha (magacine)
                                debugger;

                                if(material.stanjematerijala.length>0) {


                                    material.stanjematerijala.forEach(function (stanje) {
                                        materialHtml += `
                                        <div class="mt-2">
                                            <p><strong>Magacin ID: ${stanje.magacin_id}</strong></p>
                                            <p>Cena: ${stanje.cena}, Količina: ${stanje.kolicina}, Vrednost: ${stanje.vrednost}, Dimenzije: ${material.dimenzija}</p>
                                            <button class="btn btn-sm btn-success add-magacin-material"
                                                    data-magacin-id="${stanje.magacin_id}"
                                                    data-materijal-id="${material.sifra_materijala}"
                                                    data-naziv="${material.naziv_materijala}"
                                                    data-kolicina="${stanje.kolicina}"
                                                    data-vrednost="${stanje.vrednost}"
                                                    data-cena="${stanje.cena}">
                                                Dodaj
                                            </button>
                                        </div>
                                    `;
                                    });

                                }else{
                                    materialHtml += `
                                        <div class="mt-2">
                                            <p><strong>Magacin ID: Ne postoji</strong></p>
                                            <p>Dimenzija: ${material.dimenzija}</p>
                                            <button class="btn btn-sm btn-success add-magacin-material"
                                                    data-magacin-id=""
                                                    data-materijal-id="${material.sifra_materijala}"
                                                    data-naziv="${material.naziv_materijala}"
                                                    data-kolicina="0"
                                                    data-vrednost="0"
                                                    data-cena="0">
                                                Dodaj
                                            </button>
                                        </div>
                                    `;
                                }
                                materialHtml += '</li>'; // Zatvori listu za materijal
                                resultsList.append(materialHtml);
                            });
                        }
                    });
                }
            });

            // Dodavanje materijala iz specifičnog magacina u formu
            $(document).on('click', '.add-magacin-material', function() {
                var materijalId = $(this).data('materijal-id');
                var materijalNaziv = $(this).data('naziv');
                var magacinId = $(this).data('magacin-id');
                var kolicina = $(this).data('kolicina');
                var vrednost = $(this).data('vrednost');
                var cena = $(this).data('cena');

                var newField = `
    <div class="materijal-group">
        <div class="form-group">
            <label>Materijal: <strong>${materijalNaziv} (${materijalId})</strong> iz Magacina ${magacinId}</label>
            <input type="hidden" name="materijal_id[]" value="${materijalId}">
            <input type="hidden" name="magacin_id[]" value="${magacinId}">
        </div>

        <div class="form-group">
            <label for="kolicina[]">Količina:</label>
            <input type="number" name="kolicina[]" value="${kolicina}" class="form-control" step="0.001">
        </div>

        <div class="form-group">
            <label for="vrednost[]">Vrednost:</label>
            <input type="number" name="vrednost[]" value="${vrednost}" class="form-control" step="0.01">
        </div>

        <div class="form-group">
            <label for="cena[]">Cena:</label>
            <input type="number" name="cena[]" value="${cena}" class="form-control" step="0.01">
        </div>

        <button type="button" class="remove-materijal btn btn-danger mt-2">Ukloni</button>
    </div>
`;


                $('#materijali-fields').append(newField);
            });

            // Uklanjanje materijala iz forme
            $(document).on('click', '.remove-materijal', function() {
                $(this).closest('.materijal-group').remove();
            });
        });
    </script>
@endsection
