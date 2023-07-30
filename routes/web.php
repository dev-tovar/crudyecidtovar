<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TypeIdentificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('crudAccount', AccountController::class);
Route::post('updateAccount/{id}', [AccountController::class, 'update']);
Route::get('getTypeIdentifications', [TypeIdentificationController::class, 'getTypeIdentifications']);

Route::get('{any?}', function () {
    return view('home');
})->where('any', '.*');






