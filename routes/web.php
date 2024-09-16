<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Company;
use App\Models\Employee;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $companies=Company::count();
    $employees=Employee::count();
    $company = Company::latest('id')->get();
    return view('dashboard',compact('companies','employees','company'));
    //return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
