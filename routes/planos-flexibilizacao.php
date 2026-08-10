<?php

use App\Http\Controllers\PlanoFlexibilizacaoCurricularController;
use Illuminate\Support\Facades\Route;

Route::resource('planos-flexibilizacao', PlanoFlexibilizacaoCurricularController::class);