<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
   public function login(Request $request)
   {
       $credentials = $request->only('email', 'password');

       try {
           if(! $token = JWTAuth::attempt($credentials)){
               return response()->json([
                    'Error' => 'invalid_credentials'
               ], 400);
           }
       } catch (JWTException $e) {
           return response()->json([
                'error' => 'could_not_create_token'
           ], 500);
       }

       return response()->json(compact('token'));
   }

   public function register(Request $request)
   {
       $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' =>  'required|string|max:255',
            'nik' => 'required|numeric|'
       ]);

       if($validator->fails()){
            return response()->json($validator->errors(), 400);
       };

       $user = new User;
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = bcrypt($request->password);
       $user->phone = $request->phone;
       $user->nik = $request->nik;
       $user->save();

       $token = JWTAuth::fromUser($user);

       return response()->json(compact('user', 'token'),201);
   }

   public function getAuthenticatedUser()
   {
       try {
           if (! $user = JWTAuth::parseToken()->authenticate()){
               return response()->json([
                    'user_not_found'
               ], 404);
           }
       } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()->json([
                    'token_expired'
                ], $e->getStatusCode());
       } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return response()->json([
                    'token_invalid'
                ], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                return response()->json([
                    'token_absent'
                ], $e->getStatusCode());
        }
            return response()->json(compact('user'));
   }

}
