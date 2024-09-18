# career_Tech
## generate .env
copy .env.example and rename it .env

# Setting up for artisan cmd
# run project
 php artisan serve 

# for migrate
 php artisan migrate

# for seeding
 php artisan db:seed --class=AdminSeeder

# test api in postman
# api endpoints of companies
 Route::get('companies', [CompanyController::class, 'index']);
 Route::post('companies', [CompanyController::class, 'store']);
 Route::get('companies/{id}', [CompanyController::class, 'show']);
 Route::put('companies/{id}', [CompanyController::class, 'update']);
 Route::delete('companies/{id}', [CompanyController::class, 'destroy']);

# api endpoints of employees
 Route::get('employees', [EmployeeController::class, 'index']);
 Route::post('employees', [EmployeeController::class, 'store']);
 Route::get('employees/{id}', [EmployeeController::class, 'show']);
 Route::put('employees/{id}', [EmployeeController::class, 'update']);
 Route::delete('employees/{id}', [EmployeeController::class, 'destroy']);
