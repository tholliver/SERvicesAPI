<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');

            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }

            return response()->json(compact('token'));
        }
        public function getusers()
        {           
            #response()->json(compact('token')
           return User::all();
        }

        public function register(Request $request)
        {                        
                $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'cellphone' => 'required|string|max:20',
                'rol' => 'required|string|max:50',
                'unidaddegasto' => 'required|string|max:100',
                'facultad' => 'required|string|max:100',
            ]);

            if($validator->fails()){
                
               # $validator->errors()->toJson(), 400;
                return response()->json($validator->errors()->toJson(), 400);
            }
            //So before insert get the UD, belongs the user
            
            $unidadName = $request->get('unidaddegasto');
            $unidadId = Unidad::where('nombre',$unidadName)->first()->id;
            //Aqui quiza verificar si no pertenece a ninguna unidad
         /*
            $user = User::create([
                'name' => $request->get('name'),
                'lastname' => $request->get('lastname'),                
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'cellphone' => $request->get('cellphone'),
                'rol' => $request->get('rol'),
                'unidaddegasto' => $request->get('unidaddegasto'),
                'facultad' => $request->get('facultad'),
                'unidad_id' => $unidadId->id,
            ]);
*/
            $user = new User;
            $user->name = $request->name;
            $user->lastname = $request->lastname; 
            $user->email = $request->email;   
            $user->password = Hash::make($request->password);
            $user->cellphone = $request->cellphone;             
            $user->rol = $request->rol;
            $user->unidaddegasto = $request->unidaddegasto;  
            $user->facultad = $request->facultad;  
            $user->unidad_id = $unidadId; 
            $user->save();
            
            
            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'),201);
        }

        public function getAuthenticatedUser()
            {
                    try {
                         if (! $user = JWTAuth::parseToken()->authenticate()) {
                                    return response()->json(['user_not_found'], 404);
                            }

                    } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

                            return response()->json(['token_expired'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

                            return response()->json(['token_invalid'], $e->getStatusCode());

                    } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

                            return response()->json(['token_absent'], $e->getStatusCode());

                    }

                    return response()->json(compact('user'));
            }
}
