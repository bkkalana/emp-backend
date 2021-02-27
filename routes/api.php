<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;

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



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    Route::get('/users',[AuthController::class,'index']);
    Route::get('/users/filter', [AuthController::class,'search']);
    Route::post('/users/register', [AuthController::class,'create']);
    Route::get('/users/{id}',[AuthController::class,'show']);
    Route::get('/users/{id}/edit',[AuthController::class,'edit']);
    Route::put('/users/{id}',[AuthController::class,'update']);
    Route::put('/users/{id}/reset-password',[AuthController::class,'updatePassword']);
    Route::delete('/users/{id}',[AuthController::class,'destroy']);
});

Route::get('/countries',[CountryController::class,'index']);
Route::get('/countries/filter', [CountryController::class,'search']);
Route::get('/countries/all', [CountryController::class,'all']);
Route::post('/countries/create', [CountryController::class,'create']);
Route::get('/countries/{id}',[CountryController::class,'show']);
Route::get('/countries/{id}/edit',[CountryController::class,'edit']);
Route::put('/countries/{id}',[CountryController::class,'update']);
Route::delete('/countries/{id}',[CountryController::class,'destroy']);


Route::get('/states',[StateController::class,'index']);
Route::get('/states/filter', [StateController::class,'search']);
Route::get('/states/{id}/all', [StateController::class,'all']);
Route::post('/states/create', [StateController::class,'create']);
Route::get('/states/{id}',[StateController::class,'show']);
Route::get('/states/{id}/edit',[StateController::class,'edit']);
Route::put('/states/{id}',[StateController::class,'update']);
Route::delete('/states/{id}',[StateController::class,'destroy']);


Route::get('/cities',[CityController::class,'index']);
Route::get('/cities/filter', [CityController::class,'search']);
Route::get('/cities/{id}/all', [CityController::class,'all']);
Route::post('/cities/create', [CityController::class,'create']);
Route::get('/cities/{id}',[CityController::class,'show']);
Route::get('/cities/{id}/edit',[CityController::class,'edit']);
Route::put('/cities/{id}',[CityController::class,'update']);
Route::delete('/cities/{id}',[CityController::class,'destroy']);


Route::get('/departments',[DepartmentController::class,'index']);
Route::get('/departments/filter', [DepartmentController::class,'search']);
Route::get('/departments/all', [DepartmentController::class,'all']);
Route::post('/departments/create', [DepartmentController::class,'create']);
Route::get('/departments/{id}',[DepartmentController::class,'show']);
Route::get('/departments/{id}/edit',[DepartmentController::class,'edit']);
Route::put('/departments/{id}',[DepartmentController::class,'update']);
Route::delete('/departments/{id}',[DepartmentController::class,'destroy']);


Route::get('/employees',[EmployeeController::class,'index']);
Route::get('/employees/filter', [EmployeeController::class,'search']);
Route::post('/employees/create', [EmployeeController::class,'create']);
Route::get('/employees/{id}',[EmployeeController::class,'show']);
Route::get('/employees/{id}/edit',[EmployeeController::class,'edit']);
Route::put('/employees/{id}',[EmployeeController::class,'update']);
Route::delete('/employees/{id}',[EmployeeController::class,'destroy']);
