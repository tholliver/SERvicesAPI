<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use DB;
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
          // return User::all();
                   $user = DB::table('users')
                   ->select('name','lastname','rol','email','cellphone','unidaddegasto','id')
                   ->where('visible','=','1')->get();
                   return response()->json($user ,201);
        }
        public function getusers2()
        {
            #response()->json(compact('token')
          // return User::all();
                   $user = DB::table('users')
                   ->select('name','lastname','rol','email','cellphone','unidaddegasto','id')
                   ->where('visible','=','0')->get();
                   return response()->json($user ,201);
        }
      /*  public function getusersNew()
        {
          $items = DB::table('unidadasignacionitems')
          ->select('periodo')->distinct()
          ->orderBy('periodo', 'asc')
          ->where('unidad_id',$idUni)->get();
          return response()->json($items ,201);
        }*/

        public function verificar($nombre, $apellido)
        {
            $items = DB::table('users')
            ->where('name',$nombre)
            ->where('lastname',$apellido)
             ->where('visible','=','1' )->get();
            return response()->json($items ,201);
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
                'visible'=>'integer'
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
            $user->unidad_id = $unidadId;
            $user->visible ='1';
            $user->save();

            $token = JWTAuth::fromUser($user);

            $userdetails = auth()->user();
            $requestIP = request()->ip();
            //error_log($requestID);
           if($user){
                // Add activity logs
                activity('usuario')
                ->performedOn($user)
                ->causedBy($userdetails)
                ->withProperties(['ip' => $requestIP,
                                  'user'=> $userdetails])
                ->log('created');
           }

            return response()->json(compact('user','token'),201);
        }

    public function update(Request $request)
    {
        $unidadName = $request->get('unidaddegasto');
        $unidadId = Unidad::where('nombre',$unidadName)->first()->id;

        $user = User::find($request->id);

        $capOld = $user;
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->cellphone = $request->cellphone;
        $user->rol = $request->rol;
        $user->unidaddegasto = $request->unidaddegasto;
        $user->unidad_id = $unidadId;
        $user->visible ='1';
        $userChanged = $user->getDirty();
        $result = $user->save();

        $userdeta = auth()->user();
        $requestIP = request()->ip();

        if($result){
            // Add activity logs
            activity('usuario')
            ->performedOn($user)
            ->causedBy($userdeta)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $userdeta,
                              'nuevo' => $userChanged,
                              'anterior' => $capOld])
            ->log('updated');

            return ["result"=>"Success, data is updated"];
        } else {
            return ["result"=>"Error, data didnt update"];
        }
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

                    return response()->json($user);
            }
    public function destroy($id)
    {
        User::where('id','=',$id)->update(['visible' => '0']);
        $user = User::find($id);
        $userdel = $user;
        $nombreCompleto = $user->name.' '.$user->lastname;
        $unidad=$user->unidad_id;
        $updateDetails=[
            'visible' =>'0'
        ];
        DB::table('solicituds')
        ->where('responsable',$nombreCompleto)
        ->where('unidad_id',$unidad)
        ->update($updateDetails);
        //  $user->delete();
        //  $id  = $request->get('id');

       $userdetails = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($user){
            // Add activity logs
            activity('usuario')
            ->performedOn($user)
            ->causedBy($userdetails)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $userdetails,
                              'anterior'=>$userdel])
            ->log('deleted');
       }
      return response()->json(['message' => 'usuarios eliminado']);
    }
    public function restauracion($id)
    {
        User::where('id','=',$id)->update(['visible' => '1']);
        $user = User::find($id);
        $userdel = $user;
        $nombreCompleto = $user->name.' '.$user->lastname;
        $unidad=$user->unidad_id;
        $updateDetails=[
            'visible' =>'1'
        ];
        DB::table('solicituds')
        ->where('responsable',$nombreCompleto)
        ->where('unidad_id',$unidad)
        ->update($updateDetails);

      return response()->json(['message' => 'usuario recuperado']);
    }
}
