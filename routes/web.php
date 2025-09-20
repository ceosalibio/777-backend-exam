<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any?}', function () {
    return view('welcome'); // single blade mountpoint for Vue
})->where('any', '.*');
