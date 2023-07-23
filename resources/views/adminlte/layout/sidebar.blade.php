<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
        <img src="{{asset('admin_assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

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
                <li class="nav-item menu">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                            Osnovni podaci
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('partner.create')}}" class="nav-link">
                                <i class="fas fa-circle  nav-icon"></i>
                                <p class="small">Poslovni partneri (kreiraj)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('partner.index')}}" class="nav-link">
                                <i class="fas fa-circle  nav-icon"></i>
                                <p class="small">Poslovni partneri (pregled)</p>
                            </a>
                        </li>
                    </ul>
                </li>
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
                            <a href="{{route('materijal.create')}}" class="nav-link">
                                <i class="fas fa-circle  nav-icon"></i>
                                <p class="small">Materijali (kreiraj)</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('materijal.index')}}" class="nav-link">
                                <i class="fas fa-circle  nav-icon"></i>
                                <p class="small">Materijali (pregled)</p>
                            </a>
                        </li>


                    </ul>
                </li>
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
                <li class="nav-item menu">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                            Kadrovska evidencija
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

                <li class="nav-item menu ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon far fa-circle"></i>
                        <p class="small">
                            Obračun zarada i naknada
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
                {{--                <li class="nav-item">--}}
                {{--                    <a href="#" class="nav-link">--}}
                {{--                        <i class="nav-icon far fa-circle"></i>--}}
                {{--                        <p class="small">--}}
                {{--                            BPZ - Program za obračun nakanada prako zavoda--}}
                {{--                        </p>--}}
                {{--                    </a>--}}
                {{--                </li>--}}
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
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
