<?xml version="1.0" encoding="UTF-8" ?>
<PodaciPoreskeDeklaracije>
<PodaciOPrijavi>
<VrstaPrijave>1</VrstaPrijave>
<ObracunskiPeriod>{!!  $obracunski_period_year !!}-{!! $obracunski_period_month  !!}</ObracunskiPeriod>
<OznakaZaKonacnu>{!! $konacno !!}</OznakaZaKonacnu>
<DatumPlacanja>{!! $datum_placanja !!}</DatumPlacanja>
<NajnizaOsnovica></NajnizaOsnovica>
</PodaciOPrijavi>
<PodaciOIsplatiocu>
<TipIsplatioca>{!! $preduzece_budzet !!}</TipIsplatioca>
<PoreskiIdentifikacioniBroj>{!! $podaciOFirmi->pib !!}</PoreskiIdentifikacioniBroj>
<BrojZaposlenih>{!! $radnikData->count() !!}</BrojZaposlenih>
<MaticniBrojIsplatioca>{!! $podaciOFirmi->maticni_broj !!}</MaticniBrojIsplatioca>
<NazivPrezimeIme>{{$podaciOFirmi->naziv_firme}}</NazivPrezimeIme>
<SedistePrebivaliste>093</SedistePrebivaliste>
<Telefon>{!! $podaciOFirmi->telefon !!}</Telefon>
<UlicaIBroj>{!! $podaciOFirmi->adresa_sedista !!}</UlicaIBroj>
<eMail>{!! $podaciOFirmi->adresa_za_prijem_elektronske_poste !!}</eMail>
</PodaciOIsplatiocu>
<DeklarisaniPrihodi><?php $brojac = 1; ?>
@foreach($radnikData as $radnik )
<PodaciOPrihodima>
<RedniBroj>{!! $brojac !!}</RedniBroj>
<VrstaIdentifikatoraPrimaoca>1</VrstaIdentifikatoraPrimaoca>
<IdentifikatorPrimaoca>{!! $radnik->LBG_jmbg !!}</IdentifikatorPrimaoca>
<Prezime>{!! $radnik->prezime !!}</Prezime>
<Ime>{!! $radnik->ime !!}</Ime>
<OznakaPrebivalista>{!! (strlen($radnik->maticnadatotekaradnika->opstina_id) === 4) ? substr($radnik->maticnadatotekaradnika->opstina_id, 1) : $radnik->maticnadatotekaradnika->opstina_id  !!}</OznakaPrebivalista>
<SVP>101101000</SVP>
<BrojKalendarskihDana>{!! $radnik->maticnadatotekaradnika->DANI_kalendarski_dani !!}</BrojKalendarskihDana>
<BrojEfektivnihSati>{!! $radnik->SSZNE_suma_sati_zarade !!}</BrojEfektivnihSati>
<MesecniFondSati>{!!$podaciMesec->kalendarski_broj_dana!!}</MesecniFondSati>
<Bruto>{!! $radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade !!}</Bruto>
<OsnovicaPorez>{!! $radnik->IZNETO_zbir_ukupni_iznos_naknade_i_naknade -$radnik->POROSL_poresko_oslobodjenje !!}</OsnovicaPorez>
<Porez>{!! $radnik->SIP_ukupni_iznos_poreza !!}</Porez>
<OsnovicaDoprinosi>{!! $radnik->BROSN_osnovica_za_doprinose !!}</OsnovicaDoprinosi>
<PIO>{!! $radnik->PIOR_penzijsko_osiguranje_na_teret_radnika + $radnik->PIOP_penzijsko_osiguranje_na_teret_poslodavca !!}</PIO>
<ZDR>{!! $radnik->ZDRR_zdravstveno_osiguranje_na_teret_radnika + $radnik->ZDRP_zdravstveno_osiguranje_na_teret_poslodavca !!}</ZDR>
<NEZ>{!! $radnik->ONEZR_osiguranje_od_nezaposlenosti_teret_radnika !!}</NEZ>
<PIOBen>0.00</PIOBen>
<DeklarisaniMFP>
<MFP>
<Oznaka>MFP.1</Oznaka>
<Vrednost>0.00</Vrednost>
</MFP>
<MFP>
<Oznaka>MFP.2</Oznaka>
<Vrednost>0.00</Vrednost>
</MFP>
<MFP>
<Oznaka>MFP.4</Oznaka>
<Vrednost>0.00</Vrednost>
</MFP>
<MFP>
<Oznaka>MFP.11</Oznaka>
<Vrednost>0.00</Vrednost>
</MFP>
<MFP>
<Oznaka>MFP.12</Oznaka>
<Vrednost>0.00</Vrednost>
</MFP>
</DeklarisaniMFP>
</PodaciOPrihodima>
<?php $brojac++; ?>@endforeach
</DeklarisaniPrihodi>
</PodaciPoreskeDeklaracije>
