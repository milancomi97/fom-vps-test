<PodaciPoreskeDeklaracije>
    <PodaciOPrijavi>
        <VrstaPrijave>1</VrstaPrijave>
        <ObracunskiPeriod>2024-10</ObracunskiPeriod>
        <OznakaZaKonacnu>K</OznakaZaKonacnu>
        <DatumPlacanja>2024-11-30</DatumPlacanja>
        <NajnizaOsnovica></NajnizaOsnovica>
    </PodaciOPrijavi>
    <PodaciOIsplatiocu>
        <TipIsplatioca>1</TipIsplatioca>
        <PoreskiIdentifikacioniBroj>112290841</PoreskiIdentifikacioniBroj>
        <BrojZaposlenih>1</BrojZaposlenih>
        <MaticniBrojIsplatioca>66004384</MaticniBrojIsplatioca>
        <NazivPrezimeIme>ANALIZA PLUS</NazivPrezimeIme>
        <SedistePrebivaliste>093</SedistePrebivaliste>
        <Telefon>064/321-6945</Telefon>
        <UlicaIBroj>SULEJICEVA 233</UlicaIBroj>
        <eMail>snezat@gmail.com</eMail>
    </PodaciOIsplatiocu>
    <DeklarisaniPrihodi><?php $brojac = 1; ?>
        @foreach($radnikData as $radnik )

            <PodaciOPrihodima>
                <RedniBroj>{!! $brojac !!}</RedniBroj>
                <VrstaIdentifikatoraPrimaoca>1</VrstaIdentifikatoraPrimaoca>
                <IdentifikatorPrimaoca>1501997761033</IdentifikatorPrimaoca>
                <Prezime>{!! $radnik->prezime !!}</Prezime>
                <Ime>{!! $radnik->ime !!}</Ime>
                <OznakaPrebivalista>158</OznakaPrebivalista>
                <SVP>101101000</SVP>
                <BrojKalendarskihDana>31</BrojKalendarskihDana>
                <BrojEfektivnihSati>{!! $radnik->EFSATI_ukupni_iznos_efektivnih_sati !!}</BrojEfektivnihSati>
                <MesecniFondSati>{!! $radnik->SSZNE_suma_sati_zarade !!}</MesecniFondSati>
                <Bruto>143021.35</Bruto>
                <OsnovicaPorez>118021.35</OsnovicaPorez>
                <Porez>11802.14</Porez>
                <OsnovicaDoprinosi>143021.35</OsnovicaDoprinosi>
                <PIO>34325.13</PIO>
                <ZDR>{!! $radnik->ZDRR_zdravstveno_osiguranje_na_teret_radnika !!}</ZDR>
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
            </PodaciOPrihodima>             <?php $brojac++; ?>
        @endforeach
    </DeklarisaniPrihodi>
</PodaciPoreskeDeklaracije>
