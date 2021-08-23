<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
 
use App\Models\User;

use Validator;

use Auth;

use Illuminate\Http\Request;

class ApiPassportAuthController extends Controller
{
    /**
     * Registration Req
     */
    //Funcao Registro
    public function registro(Request $request){
        $validator = Validator::make($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        ]);

        if($validator->fails()){
        return response()->json([
        'success' => false,
        'message' => $validator->errors(),
        ], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('appToken')->accessToken;


        return response()->json([
        'success' => true,
        'token' => $success,
        'user' => $user
        ]);
    }
   
    /**
     * Login Req
     */
    //funcao de login
    public function login(){
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
    $user = Auth::user();
    $success['token'] = $user->createToken('appToken')->accessToken;
    return response()->json([
        'success' => true,
        'token' => $success,
        'user' => $user,
    ]);
    } else{
    return response()->json([
        'success' => false,
        'message' => 'Email ou senha ivalido',
    ], 401);
    }
    }



    public function logout(Request $request){
        if(Auth::user()){
         $user = Auth::user()->token();
         $user->revoke();
      return response()->json([
          'success' => true,
          'message' => 'Logout com sucesso',
         ]);
        } else{
         return response()->json([
          'success' => false,
          'message' => 'Não foi possivel realizar o Logout',
         ]);
        }
       }
}
