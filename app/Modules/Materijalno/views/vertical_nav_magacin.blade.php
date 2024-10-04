<style>
    div.dataTables_length select{
        width: 40% !important;
        text-align: center !important;
    }

    .container-fluid{
        width: 80%!important;
    }

    .nav-item {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .nav-link {
        margin-left: 10px !important; /* Adjust spacing between icon and text if needed */
    }

    .nav-title-pp{
        margin-top: 1rem !important;

    }

    .fas{
        font-size: 25px !important;
        margin-left: 25% !important;
        margin-right: 50% !important;
    }
</style>
    <div class="container-fluid">

        <!-- Tabovi za različite entitete -->
        <ul class="nav nav-tabs self-center justify-content-center  mb-5 ">
            <ul class="nav nav-tabs justify-content-center ">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.materijali.index') }}">
                        <i class="text-secondary fas fa-tools"></i>
                        <p class="nav-title-pp">Materijali</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.stanje-materijala.index') }}">
                        <i class="text-info fas fa-tools"></i>
                        <p class="nav-title-pp">Stanje Zaliha</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.stanje-magacina.index') }}">
                        <i class="text-secondary fas fa-warehouse"></i>
                        <p class="nav-title-pp">Magacin</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.kartice.index') }}">
                        <i class="text-secondary fas fa-copy"></i>
                        <p class="nav-title-pp">Kartice</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.porudzbine.index') }}">
                        <i class="text-secondary fas fa-file-invoice"></i>
                        <p class="nav-title-pp">Porudžbine</p></a>
                </li>

                <li class="nav-item d-flex align-items-center justify-content-center">
                    <a class="nav-link" href="{{ route('materijalno.partneri.index') }}">
                        <i class="text-secondary fas fa-user-friends"></i>
                        <p class="nav-title-pp">Partneri/Komitenti</p>
                    </a>

                </li>

                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.konta.index') }}">
                        <i class="text-secondary fas fa-file-invoice-dollar"></i>
                        <p class="nav-title-pp">Konta</p></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('materijalno.porudzbine.index') }}">
                        <i class="text-secondary fas fa-book"></i>
                        <p class="nav-title-pp">Izveštaji</p></a>
                </li>
            </ul>
        </ul>
    </div>
