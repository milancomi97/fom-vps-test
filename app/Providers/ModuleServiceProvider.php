<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
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
            Log::channel('vps_debug')->debug('DIR:'.$dir);

            $modelClassName = class_basename($dir);
            $path = Str::before($dir, "\\$modelClassName");
            $moduleRouteFile = "$path\\$modelClassName"."\\$modelClassName" . 'Routes.php';

            if (!file_exists($moduleRouteFile)) continue;

            Log::channel('vps_debug')->debug('moduleRouteFile: '.$moduleRouteFile);

            $this->loadRoutesFrom($moduleRouteFile);

            Log::channel('vps_debug')->debug('Views path: '."$path\\".$modelClassName.'\views');

            $this->loadViewsFrom("$path\\".$modelClassName.'\views',Str::lower($modelClassName));

            Log::channel('vps_debug')->debug('ModelClassName: '.$modelClassName);

//            $this->publishes([
//                "$path\\".$modelClassName.'\views' => resource_path('views\vendor\\'.Str::lower($modelClassName)),
//            ]);
        }
    }
}
