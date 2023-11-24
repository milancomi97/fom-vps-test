<?php

namespace App\Providers;

use App\Modules\FirstModule\Repository\FirstModuleRepository;
use App\Modules\FirstModule\Repository\FirstModuleRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepository;
use App\Modules\Kadrovskaevidencija\Repository\RadnamestaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepository;
use App\Modules\Kadrovskaevidencija\Repository\StrucnakvalifikacijaRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\VrstaradasifarnikRepository;
use App\Modules\Kadrovskaevidencija\Repository\VrstaradasifarnikRepositoryInterface;
use App\Modules\Kadrovskaevidencija\Repository\ZanimanjasifarnikRepository;
use App\Modules\Kadrovskaevidencija\Repository\ZanimanjasifarnikRepositoryInterface;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepository;
use App\Modules\Obracunzarada\Repository\IsplatnamestaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\KreditoriRepository;
use App\Modules\Obracunzarada\Repository\KreditoriRepositoryInterface;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepository;
use App\Modules\Obracunzarada\Repository\MinimalnebrutoosnoviceRepositoryInterface;
use App\Modules\Obracunzarada\Repository\OblikradaRepositoryInterface;
use App\Modules\Obracunzarada\Repository\PorezdoprinosiRepository;
use App\Modules\Obracunzarada\Repository\PorezdoprinosiRepositoryInterface;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepository;
use App\Modules\Obracunzarada\Repository\VrsteplacanjaRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\DrzaveRepository;
use App\Modules\Osnovnipodaci\Repository\DrzaveRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OpstineRepository;
use App\Modules\Osnovnipodaci\Repository\OpstineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepository;
use App\Modules\Osnovnipodaci\Repository\OrganizacionecelineRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepository;
use App\Modules\Osnovnipodaci\Repository\PodaciofirmiRepositoryInterface;
use App\Modules\Osnovnipodaci\Repository\RadniciRepository;
use App\Modules\Osnovnipodaci\Repository\RadniciRepositoryInterface;
use App\Repository\BaseRepository;
use App\Repository\BaseRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(FirstModuleRepositoryInterface::class, FirstModuleRepository::class);

        // Osnovni podaci
        $this->app->bind(DrzaveRepositoryInterface::class, DrzaveRepository::class);
        $this->app->bind(OpstineRepositoryInterface::class, OpstineRepository::class);
        $this->app->bind(OrganizacionecelineRepositoryInterface::class, OrganizacionecelineRepository::class);
        $this->app->bind(PodaciofirmiRepositoryInterface::class, PodaciofirmiRepository::class);
        $this->app->bind(RadniciRepositoryInterface::class, RadniciRepository::class);

        // Kadrovska Evidencija Modul
        $this->app->bind(RadnamestaRepositoryInterface::class, RadnamestaRepository::class);
        $this->app->bind(StrucnakvalifikacijaRepositoryInterface::class, StrucnakvalifikacijaRepository::class);
        $this->app->bind(VrstaradasifarnikRepositoryInterface::class, VrstaradasifarnikRepository::class);
        $this->app->bind(ZanimanjasifarnikRepositoryInterface::class, ZanimanjasifarnikRepository::class);

        // Obracun zarada Modul
        $this->app->bind(PorezdoprinosiRepositoryInterface::class, PorezdoprinosiRepository::class);
        $this->app->bind(VrsteplacanjaRepositoryInterface::class, VrsteplacanjaRepository::class);
        $this->app->bind(IsplatnamestaRepositoryInterface::class, IsplatnamestaRepository::class);
        $this->app->bind(KreditoriRepositoryInterface::class, KreditoriRepository::class);
        $this->app->bind(MinimalnebrutoosnoviceRepositoryInterface::class, MinimalnebrutoosnoviceRepository::class);
        $this->app->bind(OblikradaRepositoryInterface::class,\App\Modules\Obracunzarada\Repository\OblikradaRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
