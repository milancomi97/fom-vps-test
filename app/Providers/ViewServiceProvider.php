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
        foreach (glob(base_path('app/Modules/*')) ?: [] as $dir) {
            $modelClassName = class_basename($dir);
            $path = Str::before($dir, "\\$modelClassName");
            $this->loadViewsFrom($path.'/views',Str::lower($modelClassName));

//            $this->publishes([
//                "$path\\".$modelClassName.'\views' => resource_path('views\vendor\\'.Str::lower($modelClassName)),
//            ]);
        }
    }
}
