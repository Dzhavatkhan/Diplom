<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/{any}', function () {
    return view('welcome');
});
Route::get('/aboba', function () {
    return view('aboba');
});
Route::post('/dfd', [AuthController::class, 'store'])->name("contact.us.store");
Route::get('/{patchMatch}', function(){
    return view('welcome');
})->where('patchMatch', '.*');
