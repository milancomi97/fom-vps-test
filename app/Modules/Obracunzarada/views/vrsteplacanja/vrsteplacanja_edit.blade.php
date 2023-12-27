@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
@endsection

@section('content')
    <div class="container">
        <div class="content">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <!-- /.content -->
            <h1 class="text-center">Izmena vrste plaćanja</h1>
            <div class="container pb-5 mb-5">
                <form action="{{ route('vrsteplacanja.update', ['id' => $data->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="naziv_naziv_vrste_placanja">Naziv vrste plaćanja:</label>
                        <input type="text" class="form-control" id="naziv_naziv_vrste_placanja"
                               name="naziv_naziv_vrste_placanja" value="{{ $data->naziv_naziv_vrste_placanja }}">
                    </div>

                    <div class="form-group">
                        <label for="rbvp_sifra_vrste_placanja">Sifra vrste plaćanja:</label>
                        <input type="text" class="form-control" id="rbvp_sifra_vrste_placanja"
                               name="rbvp_sifra_vrste_placanja" value="{{ $data->rbvp_sifra_vrste_placanja }}">
                    </div>

                    <div class="form-group">
                        <label for="formula_formula_za_obracun">Formula:</label>
                        <input type="text" class="form-control" id="formula_formula_za_obracun"
                               name="formula_formula_za_obracun" value="{{ $data->formula_formula_za_obracun }}">
                    </div>


                    <div class="form-group">
                        <label for="redosled_poentaza_zaglavlje">Redosled poentaze zaglavlja POEN:</label>
                        <input type="text" class="form-control" id="redosled_poentaza_zaglavlje"
                               name="redosled_poentaza_zaglavlje" value="{{ $data->redosled_poentaza_zaglavlje }}">
                    </div>



                    <div class="form-group">
                        <label for="redosled_poentaza_opis">Redosled poentaze opis RIK:</label>
                        <input type="text" class="form-control" id="redosled_poentaza_opis"
                               name="redosled_poentaza_opis" value="{{ $data->redosled_poentaza_opis }}">
                    </div>


                    <div class="form-group">
                        <label for="SLOV_grupe_vrsta_placanja">Grupe vrsta placanja SLOV:</label>
                        <input type="text" class="form-control" id="SLOV_grupe_vrsta_placanja"
                               name="SLOV_grupe_vrsta_placanja" value="{{ $data->SLOV_grupe_vrsta_placanja }}">
                    </div>




                    <div class="form-group">
                        <label for="POK1_grupisanje_sati_novca">Grupisanje sati, novca POK1:</label>
                        <input type="text" class="form-control" id="POK1_grupisanje_sati_novca"
                               name="POK1_grupisanje_sati_novca" value="{{ $data->POK1_grupisanje_sati_novca }}">
                    </div>


                    <div class="form-group">
                        <label for="POK2_obracun_minulog_rada">Obračun minulog rada POK2:</label>
                        <input type="text" class="form-control" id="POK2_obracun_minulog_rada"
                               name="POK2_obracun_minulog_rada" value="{{ $data->POK2_obracun_minulog_rada }}">
                    </div>



                    <div class="form-group">
                        <label for="POK3_prikaz_kroz_unos">Prikaz kroz unos POK3:</label>
                        <input type="text" class="form-control" id="POK3_prikaz_kroz_unos"
                               name="POK3_prikaz_kroz_unos" value="{{ $data->POK3_prikaz_kroz_unos }}">
                    </div>


                    <div class="form-group">
                        <label for="KESC_prihod_rashod_tip">Prihod rashod tip KESC:</label>
                        <input type="text" class="form-control" id="KESC_prihod_rashod_tip"
                               name="KESC_prihod_rashod_tip" value="{{ $data->KESC_prihod_rashod_tip }}">
                    </div>

                    <div class="form-group">
                        <label for="EFSA_efektivni_sati">Efektivni sati EFSA:</label>
                        <input type="text" class="form-control" id="EFSA_efektivni_sati"
                               name="EFSA_efektivni_sati" value="{{ $data->EFSA_efektivni_sati }}">
                    </div>

                    <div class="form-group">
                        <label for="PRKV_prosek_po_kvalifikacijama">Prosek po kvalifikacijama PRKV:</label>
                        <input type="text" class="form-control" id="PRKV_prosek_po_kvalifikacijama"
                               name="PRKV_prosek_po_kvalifikacijama" value="{{ $data->PRKV_prosek_po_kvalifikacijama }}">
                    </div>


                    <div class="form-group">
                        <label for="OGRAN_ogranicenje_za_minimalac">Ograničenje za minimalac OGRAN:</label>
                        <input type="text" class="form-control" id="OGRAN_ogranicenje_za_minimalac"
                               name="OGRAN_ogranicenje_za_minimalac" value="{{ $data->OGRAN_ogranicenje_za_minimalac }}">
                    </div>

                    <div class="form-group">
                        <label for="PROSEK_prosecni_obracun">Prosečni obračun PROSEK:</label>
                        <input type="text" class="form-control" id="PROSEK_prosecni_obracun"
                               name="PROSEK_prosecni_obracun" value="{{ $data->PROSEK_prosecni_obracun }}">
                    </div>

                    <div class="form-group">
                        <label for="VARI_minuli_rad">Minuli rad varijabla VARI:</label>
                        <input type="text" class="form-control" id="VARI_minuli_rad"
                               name="VARI_minuli_rad" value="{{ $data->VARI_minuli_rad }}">
                    </div>


                    <div class="form-group">
                        <label for="DOVP_tip_vrste_placanja">Tip vrste plaćanja DOVP:</label>
                        <input type="text" class="form-control" id="DOVP_tip_vrste_placanja"
                               name="DOVP_tip_vrste_placanja" value="{{ $data->DOVP_tip_vrste_placanja }}">
                    </div>


                    <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
                </form>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
@endsection

