@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <style>
        .select2-selection__choice{
            background-color:#007bff!important;
            border-color: #006fe6 !important;
        }
        .myHr {
            margin-top: 30px;
            border: 0;
            height: 2px;
            background: #333;
            background-image: linear-gradient(to right, #ccc, #333, #ccc);
        }
        .border-topp {
            border: 1px solid #2e7abd !important; /* Customize the border color and thickness */
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

        <h1 class="text-center">Lista isplate po isplatnim mestima Rekapitulacija</h1>
        <div class="row mb-5 mt-5 justify-content-center">


            <div class="container mt-5">
                <?php $ukupanBrojac=0;?>
                @foreach($bankeDataZara as $key=> $troskovnoMesto)
                    <?php
                        $iznosPoBanciCounter=0;
                        ?>
                    <h2 class="text-center mt-5 ">{{$key}} - {{$isplatnaMestaSifarnika[$key]['naim_naziv_isplatnog_mesta']}}</h2>
                <table class="table table-bordered mt-2 table-striped">
                    <thead>
                    </thead>
                    <tbody>
                        @foreach($troskovnoMesto as $radnik)
                        <tr>
                            <?php $iznosPoBanciCounter+=$radnik['UKIS_ukupan_iznos_za_izplatu']; ?>
                        @endforeach
                    <tr  class="border-topp">
                        <td colspan="2" class="text-center  border-topp"><h3><b>Ukupno za banku:</b></h3></td>
                        <td class="text-center border-topp"> <h3><b>{{ number_format($iznosPoBanciCounter, 2, ',', '.') }}</b></h3></td>
                    <td  class="text-center border-topp"></td>
                    </tr>
                    </tbody>
                </table>
                    <?php $ukupanBrojac +=$iznosPoBanciCounter; ?>
                @endforeach
                <div class="myHr"></div>

                <h1 class="text-center">UKUPNO: <b>{{ number_format($ukupanBrojac, 2, ',', '.') }}</b></h1>


            </div>
        </div>
    </div>

    <!-- /.content-wrapper -->

@endsection



@section('custom-scripts')
    <script src="{{asset('admin_assets/plugins/select2/js/select2.full.min.js')}}"></script>

    <script>


        $(document).ready(function () {

        })


    </script>
@endsection

