<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\CEO;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'firstname'=> 'required|max:55',
            'lastname'=> 'required|max:55',
            'email' => 'email|required|unique:users',
            'password'=> 'required|confirmed',
            'role_name'=>'required|unique:roles',
        ]);
        if($validation->fails()){
           
            return response()->json([ 'Error' => 'invalid data supplied', 'response_code' => 400]);
        }

        $firstName=$request->firstname;
        $lastName=$request->lastname;
        $role=$request->role_name;
        $roleName=strtolower($role);
        $email=$request->email;
        $hashedPassword = Hash::make($request->password);
        $roleId=$this->getTheUserRoleIDFromTheSuppliedRoleName($roleName);
        $uniqueIdRef=$this->getTheGeneratedUniqueIDForTheCurrentUser();
        $user =$this->createUser($uniqueIdRef,$firstName,$lastName,$email,$hashedPassword,$roleId);
        $accessToken = $user->createToken('authToken')->accessToken;
        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }
    private function getTheUserRoleIDFromTheSuppliedRoleName($roleName){
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
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }
}
