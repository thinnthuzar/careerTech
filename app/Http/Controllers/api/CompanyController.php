<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Intervention\Image\Laravel\Facades\Image;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search=$request->input('search');
       $companies=Company::query();

        //search
        if(!empty($search)){
           $companies->where(function
            ($query) use ($search){
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
       $companies=$companies->paginate(2);
        return response()->json($companies,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
           // 'logo' => 'required|mimes:jpg,png,jpeg|max:10240',
                  'logo' => 'nullable|string|max:255',
            'website' => 'required|string|max:255',
        ]);
        $image = $request->file('logo');
        if (is_null($image) ) {
            return response()->json(['error' => 'No images uploaded'], 400);
        }
        $fileName = uniqid() . '_' . $image->getClientOriginalName();
        $resizedImage = Image::read($image);
        $resizedImage->resize(300, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save("storage/images/".$fileName);
        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->website = $request->website;
        $company->logo = "storage/images/".$fileName;
        $company->save();
        return response()->json($company, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
        $company=Company::find($id);
        if (!$company) {
            throw new NotFoundHttpException('agent is not found');
        }

        return response()->json([
            //'token'=>$company->createToken("API TOKEN")->plainTextToken,
            'status'=>true,
            'message'=>'found',
            'data'=>$company,
        ],200);
    }
    catch (NotFoundHttpException $e) {
        return response()->json(['error' => $e->getMessage()]);//, 404
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
           'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            //'logo' => 'nullable|mimes:jpg,png,jpeg|max:10240',
            'logo'=>'nullable|string|max:255',
            'website' => 'required|string|max:255',
        ]);

        $company->update($validated);
        return response()->json([
            'message' => 'Company updated successfully',
            'company' => $company,
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $company=Company::find($id);
             if(!$company){
                throw new NotFoundHttpException('Company is not found');
             }
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json([
             'message' => 'Company deleted successfully',
           //'data'=>$company,
        ],204);
     }catch (NotFoundHttpException $e){
        return response()->json(['error' => $e->getMessage()], 404);//
    }
    }
}
