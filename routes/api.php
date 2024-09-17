<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\EmployeeController;
use App\Http\Controllers\api\UserController;
use App\Models\User;

 Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
     Route::middleware('admin')->group(function () {

        Route::apiResource('companies',CompanyController::class);
        Route::apiResource('employees',EmployeeController::class);
        Route::post('login', [UserController::class, 'login']);
        // Route::get('companies', [CompanyController::class, 'index']);
        // Route::post('companies', [CompanyController::class, 'store']);
        // Route::get('companies/{id}', [CompanyController::class, 'show']);
        // Route::put('companies/{id}', [CompanyController::class, 'update']);
        // Route::delete('companies/{id}', [CompanyController::class, 'destroy']);
     });
     Route::post('register', [UserController::class, 'register']);
    
 });
 

