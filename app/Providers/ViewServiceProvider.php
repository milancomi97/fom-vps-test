<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ViewServiceProvider extends ServiceProvider
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
//     Windows   foreach (glob(base_path('app\Modules\*')) ?: [] as $dir) {
//      LINUX      foreach (glob(base_path('app/Modules/*')) ?: [] as $dir) {
        foreach (glob(base_path('app/Modules/*')) ?: [] as $dir) {
            $modelClassName = class_basename($dir);
            $path = Str::before($dir, "\\$modelClassName");

//            Log::channel('vps_debug')->debug('$path:'.$path);

           // LINUX            $this->loadViewsFrom($path.'/views',Str::lower($modelClassName));
// WINDOWS            $this->loadViewsFrom("$path\\".$modelClassName.'\views',Str::lower($modelClassName));
//            Log::channel('vps_debug')->debug('$viewPath:'.$path.'/views');

            $this->loadViewsFrom($path.'/views',Str::lower($modelClassName));

//            if(Auth::user()){
//            view()->composer('*', function ($view) {
//                $view->with('permissions',
//                    Auth::user()->load(['permission'])->permission);
//            });
//            }

//            $this->publishes([
//                "$path\\".$modelClassName.'\views' => resource_path('views\vendor\\'.Str::lower($modelClassName)),
//            ]);
        }
    }
}
