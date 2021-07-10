<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Users::all();
        $user = DB::table('rols')
        ->select('id','rolnom','descrip')
        ->where('visible','=','1')->get();
        return response()->json($user ,201);
    }
    public function index2()
    {
        //return Users::all();
        $user = DB::table('rols')
        ->select('id','rolnom','descrip')
        ->where('visible','=','1')
        ->where('rolnom','!=','Administrador del sistema')->get();
        return response()->json($user ,201);
    }
    public function verificar($nombre)
    {
        $items = DB::table('rols')
        ->where('rolnom',$nombre)
         ->where('visible','=','1' )->get();
        return response()->json($items ,201);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevorol(Request $request)
    {
      /* if($request->has('rolnom')){
        $rol = Rol::create([
            'rolnom' ,'=','JoelCar',
            'descrip' => $request->get('descrip'),
            'visible','=','1',
        ]);*/

        $rol = new Rol;
        $rol->rolnom = $request->rolnom;
        $rol->descrip = $request->descrip;
        $rol->visible ='1';
        $rol->save();



        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($rol){
            // Add activity logs
            activity('rol')
            ->performedOn($rol)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user])
            ->log('created');
       }

       return response()->json(compact('rol'),201);


/*
       $returnData = array(
        'status' => 'error',
        'message' => 'An error occurred!'
    );
       return response()->json($returnData, 400);*/
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  /*  public function store(Request $request)
    {
        //
    }*/

    /**
     * Display the specified resource.
     *
     * @param  \App\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function show(Rol $rol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function edit(Rol $rol)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rol = Rol::find($request->id);
        $rol->rolnom = $request->rolnom;
        $rol->descrip = $request->descrip;
        $result = $rol->save();
        if($result){
            $user = auth()->user();
            $requestIP = request()->ip();
            //error_log($requestID);
           if($rol){
                // Add activity logs
                activity('rol')
                ->performedOn($rol)
                ->causedBy($user)
                ->withProperties(['ip' => $requestIP,
                                  'user'=> $user,
                                  'data' => $rol])
                ->log('updated');
           }
            return ["result"=>"Success, data is updated"];
        } else {
            return ["result"=>"Error, data didnt update"];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rol = Rol::find($id);
        //$rol->delete();
        Rol::where('id','=',$id)->update(['visible' => '0']);


        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($rol){
            // Add activity logs
            activity('rol')
            ->performedOn($rol)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user])
            ->log('deleted');
       }

        return response()->json(['message' => 'item eliminado']);
    }
}
