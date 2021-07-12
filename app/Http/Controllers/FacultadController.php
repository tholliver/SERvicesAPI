<?php

namespace App\Http\Controllers;
use App\Models\Facultad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use DB;
class FacultadController extends Controller
{
        public function getFacultades()
        {
                   $user = DB::table('facultad')
                   ->select('nombre','decano','telefono','direccion','correo','id')
                   ->where('visible','=','1')->get();
                   return response()->json($user ,201);
        }
        public function verificar($nombre)
        {
            $items = DB::table('facultad')
            ->where('nombre',$nombre)
             ->where('visible','=','1' )->get();
            return response()->json($items ,201);
        }

        public function register(Request $request)
        {
            $facultad = new Facultad;
            $facultad->nombre = $request->nombre;
            $facultad->decano = $request->decano;
            $facultad->telefono = $request->telefono;
            $facultad->direccion = $request->direccion;
            $facultad->correo = $request->correo;
            $facultad->visible ='1';
            $facultad->save();
            return response()->json($facultad,201);
        }

    public function update(Request $request)
    {
        //$unidadName = $request->get('unidaddegasto');
        //$unidadId = Unidad::where('nombre',$unidadName)->first()->id;

        $facultad= Facultad::find($request->id);
        $facultad->nombre = $request->nombre;
        $facultad->decano = $request->decano;
        $facultad->telefono = $request->telefono;
        $facultad->direccion = $request->direccion;
        $facultad->correo= $request->correo;
        $facultad->visible ='1';

        /////
        $result = $facultad->save();

        $userdeta = auth()->user();
        $requestIP = request()->ip();
      /*
        if($result){
            // Add activity logs
            activity('facultad')
            ->performedOn($facultad)
            ->causedBy($userdeta)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $userdeta])
            ->log('updated');

            return ["result"=>"Success, data is updated"];
        } else {
            return ["result"=>"Error, data didnt update"];
        }*/
        return ["result"=>"Success, data is updated"];
    }


    public function destroy($id)
    {
        $facultad = Facultad::find($id);
        Facultad::where('id','=',$id)->update(['visible' => '0']);
    /////////////////////////
        $userdetails = auth()->user();
        $requestIP = request()->ip();
        error_log($requestID);
       if($facultad){
            // Add activity logs
            activity('facultad')
            ->performedOn($facultad)
            ->causedBy($userdetails)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $userdetails])
            ->log('deleted');
       }
        return response()->json(['message' => 'facultad eliminada']);
    }
    public function show($id){
      $facultad = Facultad::find($id);
      return response()->json($facultad);
    }
}
