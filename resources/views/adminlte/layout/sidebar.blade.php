<!-- Main Sidebar Container -->
@php

    $userData=Auth::user()->load(['permission']);
    $permissions = $userData->permission;
@endphp
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    {{--    <a href="{{route('dashboard')}}" class="brand-link">--}}
    {{--        <img src="{{asset('admin_assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"--}}
    {{--             class="brand-image img-circle elevation-3" style="opacity: .8">--}}
    {{--        <span class="brand-text font-weight-light">AdminLTE 3</span>--}}
    {{--    </a>--}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel pb-3 pt-3 mb-3 d-flex ">
            <div class="image">
                {{--                <img src="{{asset('images/company/logo-200x200.png')}}" class="img-circle elevation-2" style="width: 4rem" alt="User Image">--}}
                <img src="{{asset('images/company/logo2.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('dashboard')}}" style="font-size: 1.2rem" class="d-block">Goša FOM</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        {{--        <div class="form-inline">--}}
        {{--            <div class="input-group" data-widget="sidebar-search">--}}
        {{--                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">--}}
        {{--                <div class="input-group-append">--}}
        {{--                    <button class="btn btn-sidebar">--}}
        {{--                        <i class="fas fa-search fa-fw"></i>--}}
        {{--                    </button>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @if($permissions->osnovni_podaci)
                    <li class="nav-item menu">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-circle"></i>
                            <p>
                                Osnovni podaci
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('firmapodaci.view')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p>Podaci o firmi</p>
                                </a>
                            </li>
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Poslovni partneri

                            </li>

                            <li class="nav-item">
                                <a href="{{route('partner.create')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Unos poslovnog partnera</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('partner.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled poslovnih partnera</p>
                                </a>
                            </li>

                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Radnici

                            </li>
                            <li class="nav-item">
                                <a href="{{route('radnici.create')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Unos radnika</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('radnici.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled radnika</p>
                                </a>
                            </li>
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Organizacione Celine

                            </li>
                            <li class="nav-item">
                                <a href="{{route('organizacioneceline.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled troškovnih mesta</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
                @if($permissions->finansijsko_k)
                    <li class="nav-item menu">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon far fa-circle"></i>
                            <p class="small">
                                Finansijsko knjigovodstvo
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p>Komitenti - Partneri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if($permissions->materijalno_k)
                    <li class="nav-item menu">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon far fa-circle"></i>
                            <p class="small">
                                Materijalno knjigovodstvo
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{route('materijal.create')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Materijali (kreiraj)</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('materijal.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Materijali (pregled)</p>
                                </a>
                            </li>


                        </ul>
                    </li>
                @endif
                @if($permissions->magacini)
                    <li class="nav-item menu">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon far fa-circle"></i>
                            <p>
                                Magacini
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p>Komitenti - Partneri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if($permissions->pogonsko)
                    <li class="nav-item menu">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon far fa-circle"></i>
                            <p class="small">
                                Pogonsko knjigovodstvo
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p>Komitenti - Partneri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if($permissions->osnovna_sredstva)
                    <li class="nav-item menu">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon far fa-circle"></i>
                            <p>
                                Osnovna sredstva
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p>Komitenti - Partneri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if($permissions->kadrovska_evidencija)
                    <li class="nav-item menu">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-circle"></i>
                            <p>
                                Kadrovska evidencija
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Zanimanja
                            </li>
                            <li class="nav-item">
                                <a href="{{route('zanimanjasifarnik.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled šifarnika zanimanja</p>
                                </a>
                            </li>
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Radna mesta
                            </li>
                            <li class="nav-item">
                                <a href="{{route('radnamesta.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled šifarnika radnih mesta</p>
                                </a>
                            </li>
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Stručna kvalifikacija
                            </li>
                            <li class="nav-item">
                                <a href="{{route('strucnakvalifikacija.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled šifarnika stručnih kvalifikacija</p>
                                </a>
                            </li>
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Vrsta rada
                            </li>
                            <li class="nav-item">
                                <a href="{{route('vrstaradasifarnik.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled šifarnika vrste rada</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if($permissions->obracun_zarada)
                    <li class="nav-item menu ">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-circle"></i>
                            <p class="small">
                                Obračun zarada i naknada
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Oblik rada
                            </li>
                            <li class="nav-item">
                                <a href="{{route('oblikrada.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled oblika rada</p>
                                </a>
                            </li>
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Vrste plaćanja
                            </li>
                            <li class="nav-item">
                                <a href="{{route('vrsteplacanja.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled vrste plaćanja</p>
                                </a>
                            </li>
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Kreditori
                            </li>
                            <li class="nav-item">
                                <a href="{{route('kreditori.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled kreditora</p>
                                </a>
                            </li>
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Minimalne bruto osnovice
                            </li>
                            <li class="nav-item">
                                <a href="{{route('minimalnebrutoosnovice.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled MBO</p>
                                </a>
                            </li>
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Porez i doprinosi
                            </li>
                            <li class="nav-item">
                                <a href="{{route('porezdoprinosi.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p class="small">Pregled poreza i doprinosa</p>
                                </a>
                            </li>
{{--                            <li class="nav-header">--}}
{{--                                <i class="nav-icon fas fa-file"></i>--}}
{{--                                Matična datoteka radnika--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('maticnadatotekaradnika.index')}}" class="ml-3 nav-link">--}}
{{--                                    <i class="fas fa-circle  nav-icon"></i>--}}
{{--                                    <p class="small">Prikaz MDR</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('maticnadatotekaradnika.create')}}" class="ml-3 nav-link">--}}
{{--                                    <i class="fas fa-circle  nav-icon"></i>--}}
{{--                                    <p class="small">Kreiraj MDR</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                            <li class="nav-header">
                                <i class="nav-icon fas fa-file"></i>
                                Poentaža
                            </li>
                            <li class="nav-item">
                                <a href="{{route('datotekaobracunskihkoeficijenata.create')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle nav-icon "></i>
                                    <p class="small">Datoteka obračunskih koeficienata</p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{route('arhiva.index')}}" class="ml-3 nav-link">
                                    <i class="fas fa-circle nav-icon "></i>
                                    <p class="small">Pregled arhive</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    {{--                    <li class="nav-item">--}}
                    {{--                        <a href="#" class="nav-link">--}}
                    {{--                            <i class="nav-icon fas fa-circle"></i>--}}
                    {{--                            <p>--}}
                    {{--                                Primer sa tri nivoa--}}
                    {{--                                <i class="right fas fa-angle-left"></i>--}}
                    {{--                            </p>--}}
                    {{--                        </a>--}}
                    {{--                        <ul class="nav nav-treeview" style="display: none;">--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="{{route('datotekaobracunskihkoeficijenata.create')}}" class="nav-link">--}}
                    {{--                                    <i class="far fa-circle nav-icon "></i>--}}
                    {{--                                    <p class="small">Datoteka obračunskih koeficienata</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="#" class="nav-link">--}}
                    {{--                                    <i class="far fa-circle nav-icon"></i>--}}
                    {{--                                    <p>--}}
                    {{--                                        Primer sa tri nivoa--}}
                    {{--                                        <i class="right fas fa-angle-left"></i>--}}
                    {{--                                    </p>--}}
                    {{--                                </a>--}}
                    {{--                                <ul class="nav nav-treeview" style="display: none;">--}}
                    {{--                                    <li class="nav-item">--}}
                    {{--                                        <a href="#" class="nav-link">--}}
                    {{--                                            <i class="far fa-dot-circle nav-icon"></i>--}}
                    {{--                                            <p>Level 3</p>--}}
                    {{--                                        </a>--}}
                    {{--                                    </li>--}}
                    {{--                                    <li class="nav-item">--}}
                    {{--                                        <a href="#" class="nav-link">--}}
                    {{--                                            <i class="far fa-dot-circle nav-icon"></i>--}}
                    {{--                                            <p>Level 3</p>--}}
                    {{--                                        </a>--}}
                    {{--                                    </li>--}}
                    {{--                                    <li class="nav-item">--}}
                    {{--                                        <a href="#" class="nav-link">--}}
                    {{--                                            <i class="far fa-dot-circle nav-icon"></i>--}}
                    {{--                                            <p>Level 3</p>--}}
                    {{--                                        </a>--}}
                    {{--                                    </li>--}}
                    {{--                                </ul>--}}
                    {{--                            </li>--}}
                    {{--                            <li class="nav-item">--}}
                    {{--                                <a href="#" class="nav-link">--}}
                    {{--                                    <i class="far fa-circle nav-icon"></i>--}}
                    {{--                                    <p>Level 2</p>--}}
                    {{--                                </a>--}}
                    {{--                            </li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                @endif
                @if($permissions->tehnologija)
                    <li class="nav-item menu">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon far fa-circle"></i>
                            <p>
                                Tehnologija
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p>Komitenti - Partneri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if($permissions->proizvodnja)
                    <li class="nav-item menu">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon far fa-circle"></i>
                            <p>
                                Proizvodnja
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-circle  nav-icon"></i>
                                    <p>Komitenti - Partneri</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
