<?php

namespace App\Http\Controllers;

use App\Models\User;
use Facade\FlareClient\Http\Response;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // $user=new User();

        // $rules=[
        //     "name"=>"required",
        //     "email"=>"required",
        //     "password"=>"required"
        // ];

        // $validation=Validator::make($request->all(),$rules);
        // if($validation->fails()){
        //     return response()->json($validation->errors());
        // }else{
        //     $user->name=$request->name;
        //     $user->email=$request->email;
        //     $user->password=$request->password;
        //     $token=$user->createToken("myapptoken")->plainTextToken;
        //    $result=$user->save();
        //    if($result){
        //        return response()->json(["message"=>"User add Successfully",'user'=>$user,"token"=>$token,'token_type' => 'Bearer',]);
        //    }else{
        //        return response()->json(["message"=>"User Not add Successfully"]);
        //    }
        // }

        $field = $request->validate([
            "name" => "required",
            "email" => "required",
            "password" => "required"
        ]);
        $user = User::create([
            "name" => $field["name"],
            "email" => $field["email"],
            "password" =>Hash::make($field["password"]),
        ]);

        $token = $user->createToken("mytoken")->plainTextToken;
        $response = [
            "user" => $user,
            "token" => $token
        ];

        return response($response, 201);
    }


    public function login(Request $request){
        $field=$request->validate([
            "email"=>"required",
            "password"=>"required"
        ]);

        $user=User::where("email",$field["email"])->first();
        if(!$user || !Hash::check($field["password"], $user->password)){
            return response([
                "message"=>"Invalid email and password"
            ]);
        }

        $token=$user->createToken("mytoken")->plainTextToken;

        $response=[
            'user'=>$user,
            "token"=>$token,
        ];

        return response($response,201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response(["message" => "Logout Successfully"]);
    }
}
