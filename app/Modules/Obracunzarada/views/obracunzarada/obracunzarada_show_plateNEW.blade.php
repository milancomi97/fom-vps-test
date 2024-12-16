@php use App\Modules\Obracunzarada\Consts\UserRoles; @endphp
@extends('obracunzarada::theme.layout.app')

@section('custom-styles')
    <style>

    </style>


@endsection

@section('content')
    <!-- Header with Action Buttons -->
    <div class="container" style="width: 30%!important;">

        <table class="table mb-5">
            <tr>
                <td class="text-left">
                    <a href="{{ route('datotekaobracunskihkoeficijenata.show_all_plate', ['month_id' => $zarData->obracunski_koef_id]) }}"
                       class="btn btn-primary btn-lg mt-5">Lista <i class="fa fa-list fa-2xl" aria-hidden="true"></i></a>
                </td>
                <td class="text-center">
                    <form method="POST" action="{{ route('datotekaobracunskihkoeficijenata.stampa_radnik_lista') }}">
                        @csrf
                        <button type="submit" class="btn mt-5 btn-secondary btn-lg">PDF <i class="fa fa-print fa-2xl"></i></button>
                    </form>
                </td>
                <td class="text-right">
                    <form method="POST" action="{{ route('datotekaobracunskihkoeficijenata.email_radnik_lista') }}">
                        @csrf
                        <button type="submit" class="btn mt-5 btn-secondary btn-lg">Email <i class="fa fa-envelope fa-2xl"></i></button>
                        <input type="email" name="email_to" class="form-control mt-2" placeholder="Email primaoca">
                    </form>
                </td>
            </tr>
        </table>

        <!-- Company Info Section -->
        <table class="table mt-5">
            <tr>
                <td><strong>{{ $podaciFirme['skraceni_naziv_firme'] }}</strong></td>
                <td class="text-right">Datum štampe: {{ $datumStampe }}</td>
            </tr>
            <tr>
                <td>{{ $podaciFirme['adresa_za_prijem_poste'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td>PIB: {{ $podaciFirme['pib'] }}</td>
                <td>Banke: {{ $podaciFirme['racuni_u_bankama'] }}</td>
            </tr>
        </table>

        <!-- Payroll Summary -->
        <table class="table mt-5">
            <tr>
                <td><strong>OBRAČUN ZARADE I NAKNADA ZARADE</strong></td>
                <td>ZA MESEC: {{ $datum }}</td>
            </tr>
            <tr>
                <td>Troškovi Centar: {{ $troskovnoMesto['sifra_troskovnog_mesta'] }} {{ $troskovnoMesto['naziv_troskovnog_mesta'] }}</td>
                <td>Matični broj: {{ $mdrData['MBRD_maticni_broj'] }}</td>
            </tr>
        </table>

        <!-- Income and Deductions Table with Foreach Loop for Radnik Data -->
        <table class="table table-bordered mt-5">
            <thead>
            <tr>
                <th>Vrsta Plaćanja</th>
                <th>Sati / Procenat</th>
                <th>Iznos</th>
            </tr>
            </thead>
            <tbody>
            @foreach($radnikData as $radnik)
                @if($radnik['KESC_prihod_rashod_tip'] == 'P')
                    <tr>
                        <td>{{ $radnik['sifra_vrste_placanja'] }} {{ $radnik['naziv_vrste_placanja'] }}</td>
                        <td class="text-center">
                            {{ $radnik['sati'] !== null && $radnik['procenat'] == null ? $radnik['sati'] : '' }}
                            {{ $radnik['procenat'] !== null ? $radnik['procenat'] . '%' : '' }}
                        </td>
                        <td class="text-right">{{ $radnik['iznos'] !== null ? number_format($radnik['iznos'], 2, ',', '.') : '0.00' }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>

        <!-- Deductions Table for 'R' Type Entries -->
        <table class="table table-bordered mt-5">
            <thead>
            <tr>
                <th>Vrsta Plaćanja</th>
                <th>Kreditor</th>
                <th>Saldo</th>
                <th>Partija / Poziv</th>
                <th>Iznos</th>
            </tr>
            </thead>
            <tbody>
            @foreach($radnikData as $radnik)
                @if($radnik['KESC_prihod_rashod_tip'] == 'R')
                    @if($radnik['sifra_vrste_placanja'] == '093')
                        <tr>
                            <td>{{ $radnik['sifra_vrste_placanja'] }} {{ $radnik['naziv_vrste_placanja'] }}</td>
                            <td>{{ $radnik['kreditorAdditionalData']['imek_naziv_kreditora'] ?? '' }}</td>
                            <td>saldo: {{ $radnik['kreditAdditionalData']['SALD_saldo'] ?? '' }}</td>
                            <td class="text-right">{{ $radnik['kreditAdditionalData']['PART_partija_poziv_na_broj'] ?? '' }}</td>
                            <td class="text-right">{{ $radnik['iznos'] !== null ? number_format($radnik['iznos'], 2, ',', '.') : '0.00' }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $radnik['sifra_vrste_placanja'] }} {{ $radnik['naziv_vrste_placanja'] }}</td>
                            <td></td>
                            <td></td>
                            <td class="text-center">{{ $radnik['sati'] !== null ? $radnik['sati'] : '0' }}</td>
                            <td class="text-right">{{ $radnik['iznos'] !== null ? number_format($radnik['iznos'], 2, ',', '.') : '0.00' }}</td>
                        </tr>
                    @endif
                @endif
            @endforeach
            </tbody>
        </table>

        <!-- Bruto and Neto Summary -->
        <table class="table table-bordered mt-5">
            <tr>
                <td><strong>Bruto Zarada</strong></td>
                <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Poresko Oslobođenje</strong></td>
                <td class="text-right">{{ number_format($zarData->POROSL_poresko_oslobodjenje, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Oporezivi Iznos Zarade</strong></td>
                <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->POROSL_poresko_oslobodjenje, 2, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Net Salary and Deductions -->
        <table class="table table-bordered mt-5">
            <tr>
                <td><strong>Neto Zarada (1 - 5)</strong></td>
                <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade - $zarData->SIP_ukupni_iznos_poreza - $zarData->SID_ukupni_iznos_doprinosa, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Uk. Obustave</strong></td>
                <td class="text-right">{{ number_format($zarData->SIOB_ukupni_iznos_obustava + $zarData->ZARKR_ukupni_zbir_kredita, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Za Isplatu (1 - 5 - 3)</strong></td>
                <td class="text-right">{{ number_format($zarData->NETO_neto_zarada - $zarData->SIOB_ukupni_iznos_obustava - $zarData->ZARKR_ukupni_zbir_kredita, 2, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Contributions Summary -->
        <table class="table table-bordered mt-5">
            <tr>
                <td><strong>Ukupni Doprinosi</strong></td>
                <td class="text-right">{{ number_format($zarData->SID_ukupni_iznos_doprinosa, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Porez (10%)</strong></td>
                <td class="text-right">{{ number_format($zarData->SIP_ukupni_iznos_poreza, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Ukupni Porezi i Doprinosi</strong></td>
                <td class="text-right">{{ number_format($zarData->SIP_ukupni_iznos_poreza + $zarData->SID_ukupni_iznos_doprinosa, 2, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Employer’s Obligations Section -->
        <table class="table table-bordered mt-5">
            <tr>
                <td>Zdravstveno Osiguranje (p)</td>
                <td class="text-right">5.15%</td>
                <td class="text-right">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Penzijsko-invalidsko Osig.(p)</td>
                <td class="text-right">10.00%</td>
                <td class="text-right">{{ number_format($zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Ukupni Doprinosi</strong></td>
                <td></td>
                <td class="text-right">{{ number_format($zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Ukupna Bruto Zarada</strong></td>
                <td></td>
                <td class="text-right">{{ number_format($zarData->IZNETO_zbir_ukupni_iznos_naknade_i_naknade + $zarData->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca + $zarData->PIOP_penzijsko_osiguranje_na_teret_poslodavca, 2, ',', '.') }}</td>
            </tr>
        </table>

        <!-- Additional Sections for Admins -->
        @if(\App\Models\User::with('permission')->find(Auth::id())->permission->role_id == UserRoles::PROGRAMER)
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

