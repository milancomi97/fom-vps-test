@php use App\Modules\Obracunzarada\Consts\UserRoles; @endphp
@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>

        .disable_top_border td{
            border-top: 0 !important;
            padding: 5px 0px 0px 0px;
        }

        table{
            border-bottom: 5px solid lightblue !important;

        }
        .custom_shadow{
            box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
        }
        .table-bordered td{
            border-left: 0 !important;
            border-right: 0 !important;

        }
    </style>


@endsection

@section('content')
    <!-- Header with Action Buttons -->
    <div class="container custom_shadow mt-5" style="width: 50%!important;">

        <table class="table">
            <tr>
                <td class="text-left">
                    <a href="{{ route('datotekaobracunskihkoeficijenata.show_all_plate', ['month_id' => $zarData->obracunski_koef_id]) }}"
                       class="btn btn-primary btn-lg mt-5">Lista <i class="fa fa-list fa-2xl" aria-hidden="true"></i></a>
                </td>
                <td class="text-center">
                    <form method="POST" class="" action="{{route('datotekaobracunskihkoeficijenata.stampa_radnik_lista')}}">
                        @csrf
                        <input type="hidden" name="radnik_maticni" value="{{$radnik_maticni}}">
                        <input type="hidden" name="month_id" value="{{$month_id}}">
                        <button type="submit" class="btn mt-5 btn-secondary btn-lg" id="print-page">PDF &nbsp;&nbsp;<i
                                class="fa fa-print fa-2xl " aria-hidden="true"></i></button>
                    </form>
                </td>
                <td class="text-right">
                    <form method="POST" action="{{ route('datotekaobracunskihkoeficijenata.email_radnik_lista') }}">
                        @csrf
                        <div class="input-group">
                            <button type="submit" class="btn mt-5 btn-secondary btn-lg" style="width: 200px"
                                    id="print-page">Pošalji email &nbsp;&nbsp;<i class="fa fa-envelope fa-2xl "
                                                                                 aria-hidden="true"></i></button>
                            <input type="hidden" name="radnik_maticni" value="{{$radnik_maticni}}">
                            <input type="hidden" name="month_id" value="{{$month_id}}">
                            <label>
                                <input type="email" class="form-control mt-2" style="width: 200px" name="email_to"
                                       placeholder="Email primaoca">
                            </label>
                        </div>
                    </form>
                </td>
            </tr>
        </table>

        <!-- Company Info Section -->
        <table class="table disable_top_border">
<tr>
    <td>
        <img src="{{URL::asset('/images/company/logo2.jpg')}}" alt="Logo" height="100" width="auto">
    </td>
</tr>
            <tr>
                <td   ><strong>{{ $podaciFirme['skraceni_naziv_firme'] }} </strong>  </td>

                <td class="text-right">Datum štampe: {{ $datumStampe }}</td>
            </tr>
            <tr>

                <td>{{ $podaciFirme['adresa_za_prijem_poste'] }}</td>
                <td></td>
            </tr>
            <tr>

                <td>PIB: {{ $podaciFirme['pib'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td>
                    Maticni broj: {{$podaciFirme['maticni_broj']}}
                </td>
            </tr>
            <tr>

                <td>Banka: {{ $podaciFirme['racuni_u_bankama'] }}</td>
                <td></td>
            </tr>

        </table>

        <!-- Payroll Summary -->
        <table class="table mt-2 disable_top_border">
            <tr>
                <td class="pl-4" ><strong>OBRAČUN ZARADE I NAKNADA ZARADE</strong></td>
                <td></td>
            </tr>
            <tr>
                <td class="pl-4" ><b>ZA MESEC: {{ $datum }}</b></td>
            </tr>
            <tr>
                <td>Troškovi Centar: {{ $troskovnoMesto['sifra_troskovnog_mesta'] }} {{ $troskovnoMesto['naziv_troskovnog_mesta'] }}</td>
            </tr>


            <tr>
                <td>
                   {{$mdrData['MBRD_maticni_broj']}} -<b> {{$userData['prezime']}}  {{$userData['srednje_ime']}}
                    . {{$userData['ime']}}</b>
                </td>
                <td class="text-right">
                    JMBG: {{$mdrPreparedData['LBG_jmbg']}}<br>
                </td>
            </tr>



            <tr>
                <td><b>{{$mdrData['RBIM_isplatno_mesto_id']}} </b>  {{$mdrPreparedData['RBIM_isplatno_mesto_id']}} </td>
                <td class="text-right"> tekuci racun: {{$mdrData['ZRAC_tekuci_racun']}} </td>
            </tr>
            <tr>
                <td>
                    Datum dospelosti: <b> {{\Carbon\Carbon::createFromFormat('Y-m-d', $podaciMesec['period_isplate_do'])->format('d.m.Y')}}</b>
                </td>
            </tr>
        </table>

        <table class="table disable_top_border">
            <tr>
                <td>
                    Strucna sprema: {{$mdrPreparedData['RBPS_priznata_strucna_sprema']}}
                </td>
                <td>
                   Staz kod poslodavca {{$mdrData['GGST_godine_staza']}} god {{$mdrData['MMST_meseci_staza']}} m
                </td>
            </tr>
            <tr>
             <td>   Radno mesto: {{$mdrPreparedData['RBRM_radno_mesto']}}
             </td>
            </tr>
            <tr>
                <td>Osnovna bruto zarada:  {{$mdrData['KOEF_osnovna_zarada']}}</td>
            </tr>
            <tr>
                <td>
                    Prosecna bruto zarada/cas: {{  number_format($mdrData['PRIZ_ukupan_bruto_iznos']/$mdrData['PRCAS_ukupni_sati_za_ukupan_bruto_iznost'], 2, '.', ',')}}
                </td>
                <td>
                    Učinak: {{  number_format($mdrData['PREB_prebacaj'], 2, '.', ',')}}
                </td>
{{--                <td>--}}
{{--                    Korektivni faktor: {{  number_format($mdrData['KFAK_korektivni_faktor'], 2, '.', ',')}}--}}
{{--                </td>--}}
            </tr>
        </table>

        <!-- Income and Deductions Table with Foreach Loop for Radnik Data -->
        <table class="table table-bordered ">
            <thead>
            <tr>
{{--                <th>Vrsta Plaćanja</th>--}}
{{--                <th>Procenat</th>--}}
{{--                <th>Sati</th>--}}
{{--                <th>Iznos</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($radnikData as $radnik)
                @if($radnik['KESC_prihod_rashod_tip'] == 'P')
                    <tr>
                        <td>{{ $radnik['sifra_vrste_placanja'] }} {{ $radnik['naziv_vrste_placanja'] }}</td>
                        <td class="text-center">
                            {{ $radnik['procenat'] !== null ? $radnik['procenat'] . '%' : '' }}
                        </td>
                        <td>{{ $radnik['sati'] !== null && $radnik['procenat'] == null ? $radnik['sati'] : '' }}</td>
                        <td class="text-right">{{ $radnik['iznos'] !== null ? number_format($radnik['iznos'], 2, '.', ',') : '0.00' }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        <!-- Deductions Table for 'R' Type Entries -->
        <table class="table table-bordered">
            <thead>
            <tr>
{{--                <th>Vrsta Plaćanja</th>--}}
{{--                <th>Kreditor</th>--}}
{{--                <th>Saldo</th>--}}
{{--                <th>Partija / Poziv</th>--}}
{{--                <th>Iznos</th>--}}
            </tr>
            </thead>
            <tbody>
            @foreach($radnikData as $radnik)
                @if($radnik['KESC_prihod_rashod_tip'] == 'R')
                    @if($radnik['sifra_vrste_placanja'] == '093')
                        <tr>
                            <td >{{ $radnik['sifra_vrste_placanja'] }} {{ $radnik['naziv_vrste_placanja'] }}</td>
                            <td>kreditor={{ $radnik['kreditorAdditionalData']['imek_naziv_kreditora'] ?? '' }}</td>
                            <td class="small_font">saldo={{ $radnik['kreditAdditionalData']['SALD_saldo'] - $radnik['kreditAdditionalData']['RATA_rata']}}</td>
                            <td >part={{ $radnik['kreditAdditionalData']['PART_partija_poziv_na_broj'] ?? '' }}</td>
                            <td class="text-right">{{ $radnik['iznos'] !== null ? number_format($radnik['iznos'], 2, '.', ',') : '0.00' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $radnik['sifra_vrste_placanja'] }} {{ $radnik['naziv_vrste_placanja'] }}</td>
                            <td></td>
                            <td></td>
                            <td ></td>
                            <td class="text-right">{{ $radnik['iznos'] !== null ? number_format($radnik['iznos'], 2, '.', ',') : '0.00' }}</td>
                        </tr>
                    @endif
                @endif
            @endforeach
            </tbody>
        </table>

        <!-- Bruto and Neto Summary -->
        <table class="table table-bordered ">
            <tr>
                <td><strong>Bruto zarada</strong></td>
                <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td><strong>Poresko oslobođenje</strong></td>
                <td class="text-right">{{ number_format($zarData->POROSL_poresko_oslobodjenje, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td><strong>Oporezivi iznos zarade</strong></td>
                <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->POROSL_poresko_oslobodjenje, 2, '.', ',') }}</td>
            </tr>
        </table>

        <!-- Net Salary and Deductions -->
        <table class="table table-bordered ">
            <tr>
                <td><strong>Neto zarada (1 - 5)</strong></td>
                <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->SIP_ukupni_iznos_poreza - $zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td><strong>Uk. obustave</strong></td>
                <td class="text-right">{{ number_format($zarData->SIOB_ukupni_iznos_obustava + $zarData->ZARKR_ukupni_zbir_kredita, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td><strong>Za isplatu (1 - 5 - 3)</strong></td>
                <td class="text-right">{{ number_format($zarData->NETO_neto_zarada - $zarData->SIOB_ukupni_iznos_obustava - $zarData->ZARKR_ukupni_zbir_kredita, 2, '.', ',') }}</td>
            </tr>
        </table>

        <!-- Contributions Summary -->
        <table class="table table-bordered">
            <tr>
{{--                <td><strong>Ukupni Doprinosi</strong></td>--}}
{{--                <td class="text-right">{{ number_format($zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',') }}</td>--}}
            </tr>
{{--            <tr>--}}
{{--                <td><strong>Porez (10%)</strong></td>--}}
{{--                <td class="text-right">{{ number_format($zarData->SIP_ukupni_iznos_poreza, 2, '.', ',') }}</td>--}}
{{--            </tr>--}}
            <tr>
                <td><strong>Ukupni porezi i doprinosi na teret radnika</strong></td>
                <td class="text-right">{{ number_format($zarData->SIP_ukupni_iznos_poreza + $zarData->SID_ukupni_iznos_doprinosa, 2, '.', ',') }}</td>
            </tr>
        </table>

        <!-- Employer’s Obligations Section -->
        <table class="table table-bordered">
            <tr>
                <td>Zdravstveno osiguranje (p)</td>
                <td class="text-right">5.15%</td>
                <td class="text-right">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, '.', ',') }}</td>
            </tr>
            <tr>
                <td>Penzijsko-invalidsko osiguranje (p)</td>
                <td class="text-right">10.00%</td>
                <td class="text-right">{{ number_format($zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',') }}</td>
            </tr>
         {{--   <tr>
                <td><strong>Ukupni Doprinosi</strong></td>
                <td></td>
                <td class="text-right">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',') }}</td>
            </tr>--}}
            <tr>
                <td><strong>Ukupno potrebna sredstva</strong></td>
                <td></td>
                <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade + $zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, '.', ',') }}</td>
            </tr>
        </table>

        <!-- Additional Sections for Admins -->
        @if(\App\Models\User::with('permission')->find(Auth::id())->permission->role_id == UserRoles::PROGRAMER|| \App\Models\User::with('permission')->find(Auth::id())->permission->role_id == UserRoles::SUPERVIZOR)
            <h1 class="text-center font-weight-bold">Kontrola Tabele</h1>

            <!-- ZARA Table -->
            <h2 class="text-center font-weight-bold mt-5">ZARA</h2>
            <table class="table table-striped table-bordered table-responsive">
                <thead>
                <tr>
                    @foreach ($zarData->toArray() as $key => $value)
                        <th>{{ ucfirst($key) }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    @foreach ($zarData->toArray() as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
                </tbody>
            </table>

            <!-- DKOP Table -->
            <h2 class="text-center font-weight-bold mt-5">DKOP</h2>
            <table class="table table-striped table-bordered table-responsive">
                <thead>
                <tr>
                    @foreach ($dkopData->first()->toArray() as $key => $value)
                        <th>{{ ucfirst($key) }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach ($dkopData as $dkop)
                    <tr>
                        @foreach ($dkop->toArray() as $value)
                            <td class="text-center">{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Krediti Table -->
            @if(count($kreditiData))
                <h2 class="text-center font-weight-bold mt-5">Krediti</h2>
                <table class="table table-striped table-bordered table-responsive">
                    <thead>
                    <tr>
                        @foreach ($kreditiData->first()->toArray() as $key => $value)
                            <th>{{ ucfirst($key) }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($kreditiData as $kredit)
                        <tr>
                            @foreach ($kredit->toArray() as $value)
                                <td>{{ $value }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        @endif
    </div>
@endsection



@section('custom-scripts')

@endsection

