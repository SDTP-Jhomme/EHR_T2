<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
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

Route::get('/', function () {
    return view('welcome');
});
// admin side
Route::post('/login','App\Http\Controllers\adminController@login')->name('admin-loginPost');
Route::get('/dashboard','App\Http\Controllers\adminController@dashboard')->name('admin-dashboard');
Route::get('/admission','App\Http\Controllers\adminController@admission')->name('admin-admission');
Route::get('/login','App\Http\Controllers\adminController@adminLogin')->name('admin-login');

Route::post('/admission','App\Http\Controllers\actionController@store')->name('admin-store');
Route::get('fetch', 'App\Http\Controllers\adminController@fetch')->name('fetch');