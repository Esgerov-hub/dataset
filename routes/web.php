<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataSetController;


Route::get('',[DataSetController::class,'index'])->name('dashboard.index');
Route::get('/export',[DataSetController::class,'export'])->name('dashboard.export');
Route::post('/store',[DataSetController::class,'store'])->name('dashboard.store');
