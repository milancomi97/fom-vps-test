<?php

use Illuminate\Support\Facades\Route;
use Modules\SecondModule\Controllers\SecondModuleController;

Route::resource('secondmodule', SecondModuleController::class);
