<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\User;
class UserController extends Controller
{
    public function signup(Request $request){

                $this->validate($request,[
                    'name'=>'required',
                    'cedula'=>'required',
                    'email'=>'required|email|unique:users',
                    'password'=>'required'
                ]);

                $user = new User([
                        'name'=>$request->input('name'),
                        'email'=>$request->input('email'),
                        'cedula'=>$request->input('cedula'),
                        'password'=> bcrypt($request->input('password')),
                ]);

                $user->save();
                return response()->json([
                    'msg'=>'OK'
                    
                    ],201);
    }
    public function signin(Request $request){
        
                $credentials = $request->only('email','password');
                try{
                    if(!$token = JWTAuth::attempt($credentials)){
                        return  response()->json(['msg'=>'Credenciales Invalidos'],401);

                    }

                }catch(JWTException $e){

                    return response()->json(['msg'=>'No se pudo crear token'],500) ; 
                }
            
            return response()->json([
                'token'=>$token
            ],200);


    }
   
}
