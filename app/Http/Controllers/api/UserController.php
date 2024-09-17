<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies=Company::count();
        $employees=Employee::count();
         $company = Company::latest('id')->get();
        return view('admin.dashboard',compact('companies','employees','company'));
    }


}
