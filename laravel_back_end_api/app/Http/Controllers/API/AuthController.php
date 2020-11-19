<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\APIResponseModels\AuthAPIResponse;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'firstname'=> 'required|max:55',
            'lastname'=> 'required|max:55',
            'email' => 'email|required|unique:users',
            'password'=> 'required|confirmed',
            'role_name'=>'required',
        ]);
        if($validator->fails()){
           
            return response()->json([ 'Error' => $validator->errors(), 'response_code' => 400]);
        }

        $firstName=$request->firstname;
        $lastName=$request->lastname;
        $role=$request->role_name;
        $email=$request->email;
        $hashedPassword = Hash::make($request->password);
        $roleId=$this->getTheUserRoleIDFromTheSuppliedRoleName(strtolower($role));
        $uniqueIdRef=$this->getTheGeneratedUniqueIDForTheCurrentUser();
        $user =$this->createUser($uniqueIdRef,$firstName,$lastName,$email,$hashedPassword,$roleId);
        $accessToken = $user->createToken('authToken')->accessToken;

       $response= new AuthAPIResponse(AuthAPIResponse::$SUCCESS,'Success!',new UserResource(auth()->user()),$accessToken);
        return response()->json($response);
    }
    private function getTheUserRoleIDFromTheSuppliedRoleName($name){
        $role=Role::where('role_name',$name)->first();
        return $role->id;
    }
    private function getTheGeneratedUniqueIDForTheCurrentUser(){
        $userID ='LBEA'.random_int(1,10).mt_rand(100000, 999999);
        return $userID;
    }
    private function createUser($uniqueIdRef,$firstName,$lastName,$email,$hashedPassword,$roleId){
            return User::create([
            'user_id_ref'=>$uniqueIdRef,
            'firstname'=>$firstName,
            'lastname'=>$lastName,
            'email'=>$email,
            'password'=>$hashedPassword,
            'role_id'=>$roleId,
            ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            $response= new AuthAPIResponse(CabAPIResponse::$ERROR,'Invalid Credentials  Supplied', null, null);
            return response()->json($response);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        $response= new AuthAPIResponse(AuthAPIResponse::$SUCCESS,'Success!',new UserResource(auth()->user()),$accessToken);
        return response()->json($response);

    }
}
