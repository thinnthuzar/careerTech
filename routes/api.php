<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CompanyController;
use App\Http\Controllers\api\EmployeeController;

 Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
     Route::middleware('AdminMiddleware')->group(function () {

        Route::apiResource('companies',CompanyController::class);
        Route::apiResource('employees',EmployeeController::class);
        // Route::get('companies', [CompanyController::class, 'index']);
        // Route::post('companies', [CompanyController::class, 'store']);
        // Route::get('companies/{id}', [CompanyController::class, 'show']);
        // Route::put('companies/{id}', [CompanyController::class, 'update']);
        // Route::delete('companies/{id}', [CompanyController::class, 'destroy']);
     });
 });

