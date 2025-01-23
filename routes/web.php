<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')
     ->middleware('api')
     ->group(base_path('routes/api.php'));

Route::get('/token', function () {
    return csrf_token();
});
