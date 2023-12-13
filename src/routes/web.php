<?php

use ikepu_tp\SecureAuth\app\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get("__tfa", [WebController::class, "create"])->name("__tfa.create");
    Route::post("__tfa", [WebController::class, "store"])->name("__tfa.store");
});