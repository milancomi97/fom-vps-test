<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach (glob(base_path('app\Modules\*')) ?: [] as $dir) {
            $modelClassName = class_basename($dir);
            $path = Str::before($dir, "\\$modelClassName");
            $moduleRouteFile = "$path\\$modelClassName"."\\$modelClassName" . 'Routes.php';

            if (!file_exists($moduleRouteFile)) continue;

            $this->loadRoutesFrom($moduleRouteFile);
            $this->loadViewsFrom("$path\\".$modelClassName.'\views',Str::lower($modelClassName));


//            $this->publishes([
//                "$path\\".$modelClassName.'\views' => resource_path('views\vendor\\'.Str::lower($modelClassName)),
//            ]);
        }
    }
}
