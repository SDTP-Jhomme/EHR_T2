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
Route::get('logout', 'App\Http\Controllers\adminController@adminLogout')->name('adminLogout');

// forms
Route::post('/CBC-store', 'App\Http\Controllers\cbcController@storeCbc')->name('storeCbc');
Route::post('/urinalysis-store', 'App\Http\Controllers\urinalysisController@storeUrinalysis')->name('storeUrinalysis');
Route::post('/fecalysis-store', 'App\Http\Controllers\fecalController@storeFecalysis')->name('storeFecalysis');
Route::post('/xray-store', 'App\Http\Controllers\xrayController@storeXray')->name('storeXray');
Route::post('/antigen-store', 'App\Http\Controllers\antigenController@storeAntigen')->name('storeAntigen');
Route::post('/vaccine-store', 'App\Http\Controllers\vaxxController@storeVaccine')->name('storeVaccine');
Route::post('fetch-student', 'App\Http\Controllers\userController@fetchStudent')->name('fetchStudent');

Route::get('cbc-form', 'App\Http\Controllers\userController@cbcForm')->name('cbcForm');
Route::get('urinalysis-form', 'App\Http\Controllers\userController@urinalysisForm')->name('urinalysisForm');
Route::get('fecalysis-form', 'App\Http\Controllers\userController@fecalysisForm')->name('fecalysisForm');
Route::get('xray-form', 'App\Http\Controllers\userController@xrayForm')->name('xrayForm');
Route::get('antigen-form', 'App\Http\Controllers\userController@antigenForm')->name('antigenForm');
Route::get('vaccine-form', 'App\Http\Controllers\userController@vaccineForm')->name('vaccineForm');