<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    logger('test aja');
    return view('welcome');
});
