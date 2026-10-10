<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecureImplementPreparationController;


/*
|--------------------------------------------------------------------------
| Secure Implement Preparation
|--------------------------------------------------------------------------
*/

/*
| Download Template Excel
*/
Route::get(
    '/secure-implement-preparation/template/download',
    [SecureImplementPreparationController::class, 'downloadTemplate']
)->name('secure-implement-preparation.template');


/*
| Import Excel / CSV
*/
Route::post(
    '/secure-implement-preparation/import',
    [SecureImplementPreparationController::class, 'import']
)->name('secure-implement-preparation.import');


/*
| CRUD Secure Implement Preparation
*/
Route::resource(
    'secure-implement-preparation',
    SecureImplementPreparationController::class
);