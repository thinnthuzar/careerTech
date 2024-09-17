<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        if($validatedData->fails()){
                    return response()->json([
                        'status' => false,
                        'message'=> 'validation error',
                        'errors' => $validatedData->errors()
                    ],422);
                }

         $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password)
         ]);
       
        return response()->json([
            'status' => true,
            'message'=> 'success',
            'token'=>$user->createToken("API TOKEN")->plainTextToken
        ],200);

    }
    public function login(Request $request){
        $request->validate([
            'email'=> 'required|email|exists:users,email',
            'password'=>'required'
        ]);
        $user=User::where('email',$request->email)->first();
        if(!$user || !Hash::check( $request->password,$user->password)){
            return response()->json([
                'message'=>"The provided credentials are incorrect"
            ]);
        }
        $token=$user->createToken($user->name);
        return response()->json([
            'message'=>"Login successfully",
            'user'=>$user,
            'token'=>$token->plainTextToken,
        ]);
    }


}
