
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Podešavnje</h5>
        <p></p>
        <p></p>
        <a href="{{ url('/user/permissions_config') }}"><p>Podešavanje pristupa</p></a>
        <a href="{{ url('/user/index') }}"> <p>Podešavanje pristupa radnika</p></a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                                       onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    {{ __('Odjavi se') }}
                </x-responsive-nav-link>
            </form>


    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('admin_assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin_assets/dist/js/adminlte.min.js')}}"></script>

@yield('custom-scripts')
