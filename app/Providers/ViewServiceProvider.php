<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
            $this->loadViewsFrom("$path\\".$modelClassName.'\views',Str::lower($modelClassName));

            view()->composer('*', function ($view) {
                $view->with('permissions',
                    Auth::user()->load(['permission'])->permission);
            });

//            $this->publishes([
//                "$path\\".$modelClassName.'\views' => resource_path('views\vendor\\'.Str::lower($modelClassName)),
//            ]);
        }
    }
}
