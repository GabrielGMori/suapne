<?php

use App\Http\Controllers\PlanoFlexibilizacaoCurricularController;

Route::resource('planos-flexibilizacao', PlanoFlexibilizacaoCurricularController::class)->parameter('planos-flexibilizacao', 'plano-flexibilizacao');
