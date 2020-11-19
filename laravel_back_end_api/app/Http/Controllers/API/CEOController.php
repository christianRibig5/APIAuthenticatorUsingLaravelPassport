<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CEO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CEOResource;
use App\APIResponseModels\SysAPIResponse;
use App\Http\Resources\CEOCollection;

class CEOController extends Controller
{
   

    public function index()
    {
        $ceos = CEO::all();
        $response=new SysAPIResponse(SysAPIResponse::$SUCCESS,'Retrieved Successfully!',new CEOCollection($ceos));
        return response()->json($response);
    }

   
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required|max:255|exists:users,id',
            'year' => 'required|max:255',
            'company_headquarters' => 'required|max:255',
            'what_company_does' => 'required',
            'company_name'=>'required',
        ]);

        if($validator->fails()){
            $response= new SysAPIResponse(SysAPIResponse::$ERROR,'Invalid Credentials  Supplied',$validation->errors());
            return response()->json($response);
        }

        $ceo = CEO::create($data);

        $response=new SysAPIResponse(SysAPIResponse::$SUCCESS,'Retrieved Successfully!',new CEOResource($ceo));
        return response()->json($response);
    }

    
    public function show(CEO $ceo)
    {
        $response=new SysAPIResponse(SysAPIResponse::$SUCCESS,'Retrieved Successfully!',new CEOResource($ceo));
        return response()->json($response);

    }

    
    public function update(Request $request, CEO $ceo)
    {

        $ceo->update($request->all());

        $response=new SysAPIResponse(SysAPIResponse::$SUCCESS,'Retrieved Successfully!',new CEOResource($ceo));
        return response()->json($response);
    }

    
    public function destroy(CEO $ceo)
    {
        $ceo->delete();

        return response(['message' => 'Deleted']);
    }
}
