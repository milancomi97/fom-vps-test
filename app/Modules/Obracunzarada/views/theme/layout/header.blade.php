<nav
    class="main-header navbar navbar-expand navbar-white navbar-light  {{(env('VPS_ENV') !== null && env('VPS_ENV')=='LOCAL')?'bg-primary':''}}  {{(env('VPS_ENV') !== null && env('VPS_ENV')=='MTS')?'bg-danger':''}} ">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        {{--        <li class="nav-item d-none d-sm-inline-block">--}}
        {{--            <a href="index3.html" class="nav-link">Home</a>--}}
        {{--        </li>--}}
        {{--        <li class="nav-item d-none d-sm-inline-block">--}}
        {{--            <a href="#" class="nav-link">Contact</a>--}}
        {{--        </li>--}}


    </ul>
    <ul class="navbar-nav mr-auto ml-auto">
        <li class="nav-item">
            <a href="{{route('datotekaobracunskihkoeficijenata.create')}}" class="ml-3 nav-link">
                <i class="fas fa-circle  nav-icon text-success" style="font-size: 30px"></i>
                <h4 class="ml-3 d-inline-block">Aktivan mesec</h4>
            </a>

        </li>
        <li class="nav-item">
            <a href="{{route('radnici.index')}}" class="ml-3 nav-link">
                <i class="fas fa-circle  nav-icon text-primary" style="font-size: 30px"></i>
                <h4 class="ml-3 d-inline-block">Pregled radnika</h4>
            </a>
        </li>
        {{--        <li class="nav-item">--}}
        {{--            <a href="{{route('oblikrada.index')}}" class="ml-3 nav-link">--}}
        {{--                <i class="fas fa-circle  nav-icon text-primary" style="font-size: 30px"></i>--}}
        {{--                <h4 class="ml-3 d-inline-block">Materijalno</h4>--}}
        {{--            </a>--}}
        {{--        </li>--}}
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->


        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" style="font-size: 20px" data-widget="control-sidebar" data-slide="true" href="#"
               role="button">
                {{Auth::user()->ime}} &nbsp; {{Auth::user()->prezime}} &nbsp;&nbsp;
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
