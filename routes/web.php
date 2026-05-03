<?php

use Illuminate\Support\Facades\Route;

Route::view('/temp', 'components-temp');
Route::view('/', 'temp');
