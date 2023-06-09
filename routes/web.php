<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// request table and counts
Route::post('fetch-request', 'App\Http\Controllers\requestController@fetchRequest')->name('fetchRequest');
Route::post('count-request', 'App\Http\Controllers\requestController@countRequest')->name('countRequest');
Route::post('request-statusUpdate', 'App\Http\Controllers\actionController@updateStatus')->name('updateStatus');
Route::post('appointment-request', 'App\Http\Controllers\requestController@storeReq')->name('storeReq');
// admin side
Route::post('/login','App\Http\Controllers\adminController@admin_Login')->name('admin-loginPost');
Route::get('/admin/dashboard','App\Http\Controllers\adminController@dashboard')->name('admin-dashboard');
Route::get('/admin/admission','App\Http\Controllers\adminController@admission')->name('admin-admission');
Route::get('/admin/appointments','App\Http\Controllers\adminController@appointments')->name('admin-appointments');
Route::get('/admin/login','App\Http\Controllers\adminController@adminLogin')->name('admin-login');
Route::post('/admin/table','App\Http\Controllers\adminController@printTable')->name('print-table');

Route::post('/admission','App\Http\Controllers\actionController@store')->name('admin-store');
Route::get('fetch', 'App\Http\Controllers\adminController@fetch')->name('fetch');
Route::get('logout', 'App\Http\Controllers\adminController@adminLogout')->name('adminLogout');

// forms stores and fetch
Route::post('/cbc-store', 'App\Http\Controllers\cbcController@storeCbc')->name('storeCbc');
Route::post('/urinalysis-store', 'App\Http\Controllers\urinalysisController@storeUrinalysis')->name('storeUrinalysis');
Route::post('/fecalysis-store', 'App\Http\Controllers\fecalController@storeFecalysis')->name('storeFecalysis');
Route::post('/xray-store', 'App\Http\Controllers\xrayController@storeXray')->name('storeXray');
Route::post('/antigen-store', 'App\Http\Controllers\antigenController@storeAntigen')->name('storeAntigen');
Route::post('/vaccine-store', 'App\Http\Controllers\vaxxController@storeVaccine')->name('storeVaccine');
Route::post('fetch-student', 'App\Http\Controllers\userController@fetchStudent')->name('fetchStudent');

// fetch records
Route::post('fetch-antigen', 'App\Http\Controllers\antigenController@fetchAntigen')->name('fetchAntigen');
Route::post('fetch-cbc', 'App\Http\Controllers\cbcController@fetchCbc')->name('fetchCbc');
Route::post('fetch-urinalysis', 'App\Http\Controllers\urinalysisController@fetchUrinalysis')->name('fetchUrinalysis');
Route::post('fetch-xray', 'App\Http\Controllers\xrayController@fetchXray')->name('fetchXray');
Route::post('fetch-fecalysis', 'App\Http\Controllers\fecalController@fetchFecalysis')->name('fetchFecalysis');
Route::post('fetch-vaccine', 'App\Http\Controllers\vaxxController@fetchVaccine')->name('fetchVaccine');

//admin pages records
Route::get('admin/records/cbc', 'App\Http\Controllers\medController@cbcPage')->name('cbcPage');
Route::get('admin/records/antigen', 'App\Http\Controllers\medController@antigenPage')->name('antigenPage');
Route::get('admin/records/urinalysis', 'App\Http\Controllers\medController@urinalysisPage')->name('urinalysisPage');
Route::get('admin/records/xray', 'App\Http\Controllers\medController@xrayPage')->name('xrayPage');
Route::get('admin/records/fecalysis', 'App\Http\Controllers\medController@fecalysisPage')->name('fecalysisPage');
Route::get('admin/records/vaccine', 'App\Http\Controllers\medController@vaccinePage')->name('vaccinePage');
//nurse pages records
Route::get('nurse/records/cbc', 'App\Http\Controllers\nurseController@cbcPage')->name('cbc_Page');
Route::get('nurse/records/antigen', 'App\Http\Controllers\nurseController@antigenPage')->name('antigen_Page');
Route::get('nurse/records/urinalysis', 'App\Http\Controllers\nurseController@urinalysisPage')->name('urinalysis_Page');
Route::get('nurse/records/xray', 'App\Http\Controllers\nurseController@xrayPage')->name('xray_Page');
Route::get('nurse/records/fecalysis', 'App\Http\Controllers\nurseController@fecalysisPage')->name('fecalysis_Page');
Route::get('nurse/records/vaccine', 'App\Http\Controllers\nurseController@vaccinePage')->name('vaccine_Page');


//nurse login
Route::post('/nurse-login','App\Http\Controllers\nurseController@nurse_login')->name('nurse-loginPost');
Route::get('/nurse/dashboard','App\Http\Controllers\nurseController@dashboard')->name('nurse-dashboard');
Route::get('/nurse/admission','App\Http\Controllers\nurseController@admission')->name('nurse-admission');
Route::get('/nurse/appointments','App\Http\Controllers\nurseController@appointments')->name('nurse-appointments');

Route::get('/nurse/login','App\Http\Controllers\nurseController@nurseLogin')->name('nurse-login');
Route::post('fetch', 'App\Http\Controllers\nurseController@fetch')->name('nurse-fetch');
Route::post('nurse-logout', 'App\Http\Controllers\nurseController@nurseLogout')->name('nurseLogout');
// nurse profile
Route::get('nurse/profile', 'App\Http\Controllers\nurseController@nurseprofile')->name('nurseprofile');
Route::post('/nurse-profile-pass', 'App\Http\Controllers\nurseController@checkPass')->name('checkNursePass');
Route::post('/nurse-update-pass', 'App\Http\Controllers\nurseController@updatePassword')->name('updateNursePassword');

// nurse store,routes,updates and fetch
Route::post('/nurse-fetch', 'App\Http\Controllers\nurseController@fetchNurse')->name('fetchNurse');
Route::post('/nurse-store', 'App\Http\Controllers\nurseController@storeNurse')->name('storeNurse');
Route::post('/nurse-update', 'App\Http\Controllers\nurseController@nurseUpdate')->name('nurseUpdate');
Route::post('/nurse-status', 'App\Http\Controllers\nurseController@nurseStatus')->name('nurseStatus');
Route::get('/nurse', 'App\Http\Controllers\actionController@nurse')->name('nurse');

// teacher store,routes,updates and fetch
Route::post('/teacher-fetch', 'App\Http\Controllers\deptController@teacherFetch')->name('teacherFetch');
Route::post('/teacher-store', 'App\Http\Controllers\deptController@storeTeacher')->name('storeTeacher');
Route::post('/teacher-update', 'App\Http\Controllers\deptController@teacherUpdate')->name('teacherUpdate');
Route::post('/teacher-status', 'App\Http\Controllers\deptController@teacherStatus')->name('teacherStatus');
Route::get('/teacher', 'App\Http\Controllers\actionController@teacher')->name('teacher');
//admin form routes
Route::get('cbc-form', 'App\Http\Controllers\userController@cbcForm')->name('cbcForm');
Route::get('urinalysis-form', 'App\Http\Controllers\userController@urinalysisForm')->name('urinalysisForm');
Route::get('fecalysis-form', 'App\Http\Controllers\userController@fecalysisForm')->name('fecalysisForm');
Route::get('xray-form', 'App\Http\Controllers\userController@xrayForm')->name('xrayForm');
Route::get('antigen-form', 'App\Http\Controllers\userController@antigenForm')->name('antigenForm');
Route::get('vaccine-form', 'App\Http\Controllers\userController@vaccineForm')->name('vaccineForm');

//add and updates users
Route::post('student-add', 'App\Http\Controllers\userController@storeStudent')->name('storeStudent');
Route::post('student-update', 'App\Http\Controllers\actionController@studentUpdate')->name('studentUpdate');
Route::post('student-status', 'App\Http\Controllers\actionController@studentStatus')->name('studentStatus');

// count data records
Route::post('count-cbc', 'App\Http\Controllers\actionController@countCbc')->name('countCbc');
Route::post('count-antigen', 'App\Http\Controllers\actionController@countAntigen')->name('countAntigen');
Route::post('count-xray', 'App\Http\Controllers\actionController@countXray')->name('countXray');
Route::post('count-fecal', 'App\Http\Controllers\actionController@countfecal')->name('countfecal');
Route::post('count-urine', 'App\Http\Controllers\actionController@countUrine')->name('countUrine');
Route::post('count-vaxx', 'App\Http\Controllers\actionController@countVaccine')->name('countVaccine');
Route::get('Chart', 'App\Http\Controllers\actionController@getDataByMonth')->name('getDataByMonth');
Route::get('PieChart', 'App\Http\Controllers\actionController@getChartData')->name('getChartData');

// student login and redirect
Route::post('student/login','App\Http\Controllers\studentController@login')->name('student-loginPost');
Route::get('/dashboard','App\Http\Controllers\studentController@dashboard')->name('student-dashboard');
Route::get('/','App\Http\Controllers\studentController@studentLogin')->name('student-login');
Route::post('student-fetch', 'App\Http\Controllers\studentController@fetch')->name('student-fetch');
Route::post('fetch-avatar', 'App\Http\Controllers\studentController@fetchAvatar')->name('fetchAvatar');
Route::post('student/logout', 'App\Http\Controllers\studentController@studentLogout')->name('studentLogout');
Route::post('student/appointment', 'App\Http\Controllers\fetch_userRecord@fetch_Appointment')->name('fetch_Appointment');
// students fetch records
Route::post('student-cbc', 'App\Http\Controllers\fetch_userRecord@fetch_Cbc')->name('fetch_Cbc');
Route::post('student-antigen', 'App\Http\Controllers\fetch_userRecord@fetch_Antigen')->name('fetch_Antigen');
Route::post('student-urinalysis', 'App\Http\Controllers\fetch_userRecord@fetch_Urinalysis')->name('fetch_Urinalysis');
Route::post('student-xray', 'App\Http\Controllers\fetch_userRecord@fetch_Xray')->name('fetch_Xray');
Route::post('student-fecalysis', 'App\Http\Controllers\fetch_userRecord@fetch_Fecalysis')->name('fetch_Fecalysis');
Route::post('student-vaccine', 'App\Http\Controllers\fetch_userRecord@fetch_Vaccine')->name('fetch_Vaccine');
// student profile
Route::get('student/', 'App\Http\Controllers\studentController@studentProfile')->name('studentprofile');
Route::post('/profile-pass', 'App\Http\Controllers\studentController@checkPass')->name('checkPass');
Route::post('/update-pass', 'App\Http\Controllers\studentController@updatePassword')->name('updatePassword');

// teacher's login
Route::post('department/login','App\Http\Controllers\deptController@deptlogin')->name('department-loginPost');
Route::get('/department/dashboard','App\Http\Controllers\deptController@dashboard')->name('department-dashboard');
Route::get('/department-login','App\Http\Controllers\deptController@teacherLogin')->name('department-login');
Route::post('department-fetch', 'App\Http\Controllers\deptController@fetch')->name('department-fetch');
Route::post('department/logout', 'App\Http\Controllers\deptController@departmentLogout')->name('departmentLogout');
// teacher profile
Route::get('department/', 'App\Http\Controllers\deptController@profile')->name('departmentprofile');
Route::post('department/profile-pass', 'App\Http\Controllers\deptController@checkPass')->name('departmentcheckPass');
Route::post('department/update-pass', 'App\Http\Controllers\deptController@updatePassword')->name('departmentupdatePassword');

// teachers meds records 
Route::get('department/records/cbc', 'App\Http\Controllers\medController@cbcFile')->name('cbcFile');
Route::get('department/records/antigen', 'App\Http\Controllers\medController@antigenFile')->name('antigenFile');
Route::get('department/records/urinalysis', 'App\Http\Controllers\medController@urinalysisFile')->name('urinalysisFile');
Route::get('department/records/xray', 'App\Http\Controllers\medController@xrayFile')->name('xrayFile');
Route::get('department/records/fecalysis', 'App\Http\Controllers\medController@fecalysisFile')->name('fecalysisFile');
Route::get('department/records/vaccine', 'App\Http\Controllers\medController@vaccineFile')->name('vaccineFile');

//appointment
Route::post('appointment-done', 'App\Http\Controllers\requestController@doneReqStatus')->name('doneReqStatus');
Route::post('appointment-approved', 'App\Http\Controllers\requestController@approvedStatus')->name('approvedStatus');
Route::post('appointment-rejected', 'App\Http\Controllers\requestController@rejectedStatus')->name('rejectedStatus');