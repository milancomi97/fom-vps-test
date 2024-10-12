<style>
    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: white;
        list-style: none;
        padding: 10px;
        margin: 0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        z-index: 1000;
        min-width: 200px; /* Minimum width za podmeni */
    }

    /* Prikaz podmenija na hover */
    .nav-item:hover .dropdown-menu {
        display: block;
    }

    /* Stilizacija stavki podmenija sa fleksibilnim rasporedom */
    /* Stilizacija stavki podmenija sa fleksibilnim rasporedom */
    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 8px 16px;
        text-decoration: none;
        color: #333;
        white-space: nowrap; /* Sprečava prelazak u novi red */
        width: 100%; /* Osigurava da ikonica i tekst ostanu u istom redu */
    }

    .dropdown-item i {
        margin-left: 15px !important;
        margin-right: 15px !important;
        font-size: 16px;
        flex-shrink: 0; /* Sprečava ikonice da se smanje */
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #007bff;
    }

    /* Stilizacija glavnih stavki menija */
    .nav-link {
        font-weight: bold;
        color: #333;
        padding: 10px;
    }

    .nav-link:hover {
        color: #007bff;
        background-color: #f8f9fa;
    }
</style>
    <div class="container-fluid">

        <!-- Tabovi za različite entitete -->
        <ul class="nav nav-tabs self-center justify-content-center mb-5">
            <!-- 1. Azuriranje -->
            <li class="nav-item my-nav-item dropdown">
                <a class="nav-link my-nav-link" href="#">
                    <i class="fas fa-sync-alt"></i> Ažuriranje
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-balance-scale"></i> Jedinice Mera</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cube"></i> Materijali</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-alt"></i> Dokumenti</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-warehouse"></i> Magacini</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-layer-group"></i> Grupe</a></li>
                </ul>
            </li>

            <!-- 2. Unos -->
            <li class="nav-item my-nav-item dropdown">
                <a class="nav-link my-nav-link" href="#">
                    <i class="fas fa-edit"></i> Unos
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-book"></i> Knjizenje</a></li>
                </ul>
            </li>

            <!-- 3. Izveštaji -->
            <li class="nav-item my-nav-item dropdown">
                <a class="nav-link my-nav-link" href="#">
                    <i class="fas fa-chart-line"></i> Izveštaji
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-receipt"></i> Po porudžbini</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-id-card"></i> Za jednu šifru (Kartica)</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-invoice"></i> Po Dokumentu</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-signature"></i> Po Nalogu</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-layer-group"></i> Po Grupi Materijala</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-book"></i> Po Kontu</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-warehouse"></i> Po Magacinu</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-link"></i> Nalog - Konto</a></li>
                </ul>
            </li>

            <!-- 4. Listanje -->
            <li class="nav-item my-nav-item dropdown">
                <a class="nav-link my-nav-link" href="#">
                    <i class="fas fa-list-ul"></i> Listanje
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-barcode"></i> Po Šifri</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-university"></i> Po Kontu i Magacinima</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-receipt"></i> Po porudžbini</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cubes"></i> Zalihe</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-signature"></i> Po Nalozima</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-wrench"></i> Alat po Klasama</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-alt"></i> Matični bez prometa</a></li>
                </ul>
            </li>

            <!-- 5. Razno -->
            <li class="nav-item my-nav-item dropdown">
                <a class="nav-link my-nav-link" href="#">
                    <i class="fas fa-ellipsis-h"></i> Razno
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-calendar-alt"></i> Početno Stanje</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-tools"></i> Održavanje</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-clipboard-list"></i> Popis</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-bug"></i> Protokol Grešaka</a></li>
                </ul>
            </li>
        </ul>
    </div>
