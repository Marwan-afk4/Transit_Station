<?php

use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('landing_page');
});
