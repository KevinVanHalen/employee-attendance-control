<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('employees', 'EmployeeController@index');
Route::post('employee/store', 'EmployeeController@store');
Route::post('employee/update', 'EmployeeController@update');

Route::get('employee/{id}/working-days', 'WorkingDayController@getEmployeeWorkingDays');
Route::post('employee/working-days/store', 'WorkingDayController@store');
Route::post('employee/working-days/update', 'WorkingDayController@updateEmployeeWorkingDays');

Route::get('employee/{id}/get-all-attendances', 'AttendanceController@getAttendancesEmployee');
Route::post('attendance/check-in-out', 'AttendanceController@checkInOut');
Route::post('employee/attendance/update', 'AttendanceController@updateCheckInOut');
Route::get('employee/attendance/{id}/delete', 'AttendanceController@delete');

Route::get('employee/{id}/get-all-non-attendances', 'NonAttendanceController@getNonAttendacesEmployee');
Route::post('employee/non-attendance/store', 'NonAttendanceController@store');
Route::post('employee/non-attendance/update', 'NonAttendanceController@updateNonAttendance');
Route::get('employee/non-attendance/{id}/delete', 'NonAttendanceController@delete');