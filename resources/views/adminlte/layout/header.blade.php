<nav class="main-header navbar navbar-expand navbar-white navbar-light">
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

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item" style="margin-right: 50em">
            <a class="nav-link " href="{{route('datotekaobracunskihkoeficijenata.create')}}" role="button">
                <b>Poentaža</b>  <i class="fas fa-file"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" style="font-size: 20px" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                {{Auth::user()->ime}} &nbsp; {{Auth::user()->prezime}} &nbsp;&nbsp;
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
