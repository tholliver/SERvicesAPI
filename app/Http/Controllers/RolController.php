<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

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
        return Rol::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevorol(Request $request)
    {
       if($request->has('rolnom')){
        $rol = Rol::create([
            'rolnom' => $request->get('rolnom'),
            'descrip' => $request->get('descrip'),            
        ]);

       return response()->json(compact('rol'),201);
            
       }

       $returnData = array(
        'status' => 'error',
        'message' => 'An error occurred!'
    );
       return response()->json($returnData, 400);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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
        $rol->delete();
        return response()->json(['message' => 'item eliminado']);
    }
}
