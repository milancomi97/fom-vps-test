@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<style>
   .select2-selection__choice{
       background-color:#007bff!important;
       border-color: #006fe6 !important;
   }
</style>
@endsection

@section('content')

    <form>
        @csrf
    </form>
    <div class="content">
        <!-- Content Header (Page header) -->
        <div class="content-header">
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <!-- /.content -->
        <h1 class="text-center">Izveštaji (banka)</h1>
        <div class="row mb-5 mt-5 justify-content-center ">
            <div class="col-sm-3 card form-container p-5">
                    <form method="POST" action="{{ route('datotekaobracunskihkoeficijenata.priprema_banke_radnik') }}">
                        @csrf
                        <input type="hidden" name="prikazi_sve" value="0"/>
                        <div class="form-group">
                            <label for="banke_ids">Izaberi banku</label>
                            <div class="input-group" data-target-input="nearest">
                                <select required class="form-control custom-select banke_ids" id="banke_ids" name="banke_ids[]" multiple="multiple"
                                        aria-describedby="banke_ids">
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Prikaži odabrane</button>
                        </div>
                    </form>
                </div>
            <div class="col-sm-1  mt-5 form-container">
                <form method="POST" action="{{ route('datotekaobracunskihkoeficijenata.priprema_banke_radnik') }}">
                    @csrf
                    <input type="hidden" name="prikazi_sve" value="1"/>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-success">Prikaži sve banke</button>
                    </div>
                </form>

            </div>
            <div class="col-sm-1  mt-5 form-container">
                <form method="POST" action="{{ route('datotekaobracunskihkoeficijenata.priprema_banke_radnik_rekapitulacija') }}">
                    @csrf
                    <input type="hidden" name="prikazi_sve" value="1"/>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-warning">Rekapitulacija</button>
                    </div>
                </form>

            </div>
        </div>

        <div class="row justify-content-center border-top pt-5 mt-5 ">
            <div class="col-sm-3 card form-container  p-5">
                <form method="POST" action="{{ route('datotekaobracunskihkoeficijenata.priprema_banke_krediti') }}">
                    @csrf
                    <input type="hidden" name="prikazi_sve" value="0"/>
                    <div class="form-group">
                        <label for="kreditori_ids">Izaberi kreditora</label>
                        <div class="input-group" data-target-input="nearest">
                            <select required class="form-control custom-select kreditori_ids" id="kreditori_ids" name="kreditori_ids[]" multiple="multiple"
                                    aria-describedby="kreditori_ids">
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Prikaži odabrane</button>
                    </div>
                </form>
            </div>

            <div class="col-sm-1  mt-5 form-container">
                <form method="POST" action="{{ route('datotekaobracunskihkoeficijenata.priprema_banke_krediti') }}">
                    @csrf
                    <input type="hidden" name="prikazi_sve" value="1"/>
                    <div class="form-group text-center">
                        <button type="submit"  class="btn btn-success">Prikaži sve kredite</button>
                    </div>
                </form>

            </div>
            <div class="col-sm-1 mt-5 form-container">
                <form method="POST" action="{{ route('datotekaobracunskihkoeficijenata.priprema_banke_krediti_rekapitulacija') }}">
                    @csrf
                    <input type="hidden" name="prikazi_sve" value="1"/>
                    <div class="form-group text-center">
                        <button type="submit"  class="btn btn-warning">Rekapitulacija</button>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <!-- /.content-wrapper -->

@endsection



@section('custom-scripts')
            <script src="{{asset('admin_assets/plugins/select2/js/select2.full.min.js')}}"></script>

            <script>


        $(document).ready(function () {
            var data ={!! json_encode($bankeData) !!};

            $(".banke_ids").select2({
                data: data,
                // width: 'resolve'
            })

            var data2 ={!! json_encode($kreditoriData) !!};

            $(".kreditori_ids").select2({
                data: data2,
                // width: 'resolve'
            })
        })


    </script>
@endsection

