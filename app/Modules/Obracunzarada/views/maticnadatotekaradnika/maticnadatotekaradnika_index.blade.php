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
            <h1 class="text-center"> Maticna datoteka radnika sve forme su samo generisane po skracenim nazivima za pocetak </h1>

            <div class="container mt-5 mb-5">
                <h1>Matična datoteka radnika - MDR</h1>
                <form>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="mbrd">MBRD</label>
                            <input type="text" class="form-control" id="mbrd" placeholder="Enter MBRD (7 characters)" maxlength="7">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="rbrm">RBRM</label>
                            <input type="text" class="form-control" id="rbrm" placeholder="Enter RBRM (3 characters)" maxlength="3">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="rbim">RBIM</label>
                            <input type="text" class="form-control" id="rbim" placeholder="Enter RBIM (3 characters)" maxlength="3">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="zrac">ZRAC</label>
                            <input type="text" class="form-control" id="zrac" placeholder="Enter ZRAC (20 characters)" maxlength="20">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="p_r">P_R</label>
                            <input type="text" class="form-control" id="p_r" placeholder="Enter P_R (1 character)" maxlength="1">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="brcl">BRCL</label>
                            <input type="text" class="form-control" id="brcl" placeholder="Enter BRCL (4 characters)" maxlength="4">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="mrad">MRAD</label>
                            <input type="text" class="form-control" id="mrad" placeholder="Enter MRAD (1 character)" maxlength="1">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ggst">GGST</label>
                            <input type="number" class="form-control" id="ggst" placeholder="Enter GGST (2 digits)" min="0" max="99">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="mmst">MMST</label>
                            <input type="number" class="form-control" id="mmst" placeholder="Enter MMST (2 digits)" min="0" max="99">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="koef">KOEF</label>
                            <input type="number" class="form-control" id="koef" placeholder="Enter KOEF (12 digits)" min="0" max="999999999999">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="koef1">KOEF1</label>
                            <input type="number" class="form-control" id="koef1" placeholder="Enter KOEF1 (12 digits)" min="0" max="999999999999">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="rbss">RBSS</label>
                            <input type="text" class="form-control" id="rbss" placeholder="Enter RBSS (2 characters)" maxlength="2">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="rbps">RBPS</label>
                            <input type="text" class="form-control" id="rbps" placeholder="Enter RBPS (2 characters)" maxlength="2">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="rbop">RBOP</label>
                            <input type="text" class="form-control" id="rbop" placeholder="Enter RBOP (3 characters)" maxlength="3">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="jmbg">JMBG</label>
                            <input type="text" class="form-control" id="jmbg" placeholder="Enter JMBG (13 characters)" maxlength="13">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="preb">PREB</label>
                            <input type="number" class="form-control" id="preb" placeholder="Enter PREB (5,3)" step="0.001" min="0" max="99999.999">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="rbtc">RBTC</label>
                            <input type="text" class="form-control" id="rbtc" placeholder="Enter RBTC (8 characters)" maxlength="8">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="prpb">PRPB</label>
                            <input type="number" class="form-control" id="prpb" placeholder="Enter PRPB (5,3)" step="0.001" min="0" max="99999.999">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="pol">POL</label>
                            <input type="text" class="form-control" id="pol" placeholder="Enter POL (1 character)" maxlength="1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="rj">RJ</label>
                            <input type="text" class="form-control" id="rj" placeholder="Enter RJ (3 characters)" maxlength="3">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="brig">BRIG</label>
                            <input type="text" class="form-control" id="brig" placeholder="Enter BRIG (5 characters)" maxlength="5">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="ulica">ULICA</label>
                            <input type="text" class="form-control" id="ulica" placeholder="Enter ULICA (20 characters)" maxlength="20">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="opstina">OPSTINA</label>
                            <input type="text" class="form-control" id="opstina" placeholder="Enter OPSTINA (3 characters)" maxlength="3">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="drzava">DRŽAVA</label>
                            <input type="text" class="form-control" id="drzava" placeholder="Enter DRŽAVA (5 characters)" maxlength="5">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="prosecni_iznos">Prosečni iznos</label>
                            <input type="number" class="form-control" id="prosecni_iznos" placeholder="Enter Prosečni iznos" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="prosecni_sati">Prosečni sati</label>
                            <input type="number" class="form-control" id="prosecni_sati" placeholder="Enter Prosečni sati" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="dani">DANI</label>
                            <input type="number" class="form-control" id="dani" placeholder="Enter DANI (3 digits)" min="0" max="999">
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Sačuvaj podatke</button>
                </form>
            </div>

            <div class="container mt-5 mb-5">
                <h1> PRVA ISPLATA i kumulirane druga, treća, </h1>
                <form>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="izneto1">IZNETO1</label>
                            <input type="number" class="form-control" id="izneto1" placeholder="Enter IZNETO1 (12,2)" step="0.01" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="porosl1">POROSL1</label>
                            <input type="number" class="form-control" id="porosl1" placeholder="Enter POROSL1 (12,2)" step="0.01" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="sip1">SIP1</label>
                            <input type="number" class="form-control" id="sip1" placeholder="Enter SIP1 (12,2)" step="0.01" min="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="brosn1">BROSN1</label>
                            <input type="number" class="form-control" id="brosn1" placeholder="Enter BROSN1 (12,2)" step="0.01" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pior1">PIOR1</label>
                            <input type="number" class="form-control" id="pior1" placeholder="Enter PIOR1 (12,2)" step="0.01" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="piop1">PIOP1</label>
                            <input type="number" class="form-control" id="piop1" placeholder="Enter PIOP1 (12,2)" step="0.01" min="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="zdrr1">ZDRR1</label>
                            <input type="number" class="form-control" id="zdrr1" placeholder="Enter ZDRR1 (12,2)" step="0.01" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="zdrp1">ZDRP1</label>
                            <input type="number" class="form-control" id="zdrp1" placeholder="Enter ZDRP1 (12,2)" step="0.01" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="onezr1">ONEZR1</label>
                            <input type="number" class="form-control" id="onezr1" placeholder="Enter ONEZR1 (12,2)" step="0.01" min="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="onezp1">ONEZP1</label>
                            <input type="number" class="form-control" id="onezp1" placeholder="Enter ONEZP1 (12,2)" step="0.01" min="0">
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Sačuvaj podatke</button>
                </form>
            </div>
            <div class="container mt-5">
                <h1>Konačna isplata</h1>
                <form>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="izneto">IZNETO</label>
                            <input type="number" class="form-control" id="izneto" placeholder="Enter IZNETO (12)" step="1" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="porosl">POROSL</label>
                            <input type="number" class="form-control" id="porosl" placeholder="Enter POROSL (12)" step="1" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="sip">SIP</label>
                            <input type="number" class="form-control" id="sip" placeholder="Enter SIP (12,2)" step="0.01" min="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="brosn">BROSN</label>
                            <input type="number" class="form-control" id="brosn" placeholder="Enter BROSN (12)" step="1" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pior">PIOR</label>
                            <input type="number" class="form-control" id="pior" placeholder="Enter PIOR (12)" step="1" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="piop">PIOP</label>
                            <input type="number" class="form-control" id="piop" placeholder="Enter PIOP (12)" step="1" min="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="zdrr">ZDRR</label>
                            <input type="number" class="form-control" id="zdrr" placeholder="Enter ZDRR (12)" step="1" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="zdrp">ZDRP</label>
                            <input type="number" class="form-control" id="zdrp" placeholder="Enter ZDRP (12)" step="1" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="onezr">ONEZR</label>
                            <input type="number" class="form-control" id="onezr" placeholder="Enter ONEZR (12)" step="1" min="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="onezp">ONEZP</label>
                            <input type="number" class="form-control" id="onezp" placeholder="Enter ONEZP (12)" step="1" min="0">
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Sačuvaj podatke</button>
                </form>
            </div>
        </div>
        <!-- /.content-wrapper -->
    </div>
@endsection



@section('custom-scripts')
@endsection

