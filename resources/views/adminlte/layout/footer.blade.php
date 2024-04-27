
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Podešavnja</h5>
        <p></p>
        <p></p>
        <a href="{{ url('/forgot-password-cust/123455')}}"><p><i class="fa fa-key" aria-hidden="true"></i>&nbsp;Izmena šifre</p></a>
        <a href="{{ route('backup.index') }}"><p><i class="fa fa-database" aria-hidden="true"></i>&nbsp;&nbsp;Backup baze</p></a>
        <a href="{{ url('/user/permissions_config') }}"><p><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;Podešavanje pristupa</p></a>
        <a href="{{ url('/user/index') }}"><p><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;Podešavanje pristupa radnika</p></a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                                       onclick="event.preventDefault();
                                        this.closest('form').submit();" style="padding-left:0 !important;">
                    <i class="fa fa-sign-out-alt" aria-hidden="true"></i>

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
