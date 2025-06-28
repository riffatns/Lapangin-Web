<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing'); // Pastikan file landing.blade.php ada di resources/views/
});

Route::get('/starting-page', function () {
    return view('startingpage');
});
