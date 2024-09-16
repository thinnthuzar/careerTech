<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search=$request->input('search');
        $employees=Employee::query();

        //search
        if(!empty($search)){
            $employees->where(function
            ($query) use ($search){
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        $employees=$employees->paginate(5);
        return response()->json([
            'data'=>$employees,
            'message'=>'yes',
        ],201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'profile' => 'nullable|mimes:jpg,png,jpeg|max:10240',

        ]);
        $image = $request->file('profile');
        if (is_null($image) ) {
            return response()->json(['error' => 'No images uploaded'], 400);
        }
       $fileName = uniqid() . '_' . $image->getClientOriginalName();
       $resizedImage = Image::read($image);
       $resizedImage->resize(300, 300, function ($constraint) {
           $constraint->aspectRatio();
       })->save("storage/images/".$fileName);
       $employee = new Employee();
       $employee->company_id = $request->company_id;
       $employee->name = $request->name;
       $employee->email = $request->email;
       $employee->phone = $request->phone;
       $employee->profile = "storage/images/".$fileName;
       $employee->save();
        return response()->json([
            'message' => 'Employee created successfully',
            'data' =>$employee
        ], 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
       $employee=Employee::find($id);
        if (!$employee) {
            throw new NotFoundHttpException('Employee is not found');
        }

        return response()->json([
           // 'token'=>$employee->createToken("API TOKEN")->plainTextToken,
            'status'=>true,
            'message'=>'found',
            'data'=>$employee,
        ],200);
    }
    catch (NotFoundHttpException $e) {
        return response()->json(['error' => $e->getMessage()], 404);
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'profile' => 'nullable|mimes:jpg,png,jpeg|max:10240',
        ]);

        $employee->update($validated);
        return response()->json([
            'message' => 'Employee updated successfully',
            'company' => $employee]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $employee=Employee::find($id);
            if(!$employee){
                throw new NotFoundHttpException('employee is not found');
            }
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json([
            'message' => 'Employee deleted successfully',
            'data'=>$employee,
        ],200);
    }catch (NotFoundHttpException $e){
        return response()->json(['error' => $e->getMessage()], 404);
    }
    }
}
