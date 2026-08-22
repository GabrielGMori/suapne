<?php

use App\Http\Controllers\DisciplinaController;

Route::resource('disciplinas', DisciplinaController::class)->except('show');
