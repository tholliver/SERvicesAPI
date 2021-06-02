<?php

namespace App\Http\Controllers;

use App\Models\PresupuestoUnidad;
use App\Models\Unidad;
use Illuminate\Http\Request;
use DB;

class PresupuestoUnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PresupuestoUnidad::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
           /* $presupuestoUnidad = PresupuestoUnidad::create([
                'id_unidad' => $request->get('id_unidad'),
                'presupuesto' => $request->get('presupuesto'),
                'gestion' => $request->get('gestion'),
            ]);
    
           return response()->json(compact('presupuestoUnidad'),201);
                
    
           $returnData = array(
            'status' => 'error',
            'message' => 'An error occurred!'
        );
           return response()->json($returnData, 400);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevoPresupuesto(Request $request)
    {
        if (Unidad::where('id', '=', $request->get('id_unidad'))->exists()) {
            // user found
            if($request->has('presupuesto')){
                 $pres = PresupuestoUnidad::create([
                     'id_unidad' => $request->get('id_unidad'),
                     'presupuesto' => $request->get('presupuesto'),
                     'gestion' => $request->get('gestion'),                   
                 ]);
                 return response()->json(compact('pres'),201);            
            }            
         } else {
             $returnData = array(
                  'status' => 'error',
                  'message' => 'Unidad no encontrada',
                  'code' => '404'
              );
             return response()->json($returnData, 404);
         }
    }

    public function presupuestoId($id){
       // $id = $request->input('id');
        $presupuesto = DB::table('presupuesto_unidads')
                ->where('id_unidad', '=', $id)
                ->get();
        return response()->json($presupuesto);
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
     * @param  \App\Models\PresupuestoUnidad  $presupuestoUnidad
     * @return \Illuminate\Http\Response
     */
    public function show(PresupuestoUnidad $presupuestoUnidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PresupuestoUnidad  $presupuestoUnidad
     * @return \Illuminate\Http\Response
     */
    public function edit(PresupuestoUnidad $presupuestoUnidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PresupuestoUnidad  $presupuestoUnidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {     
        $pres = PresupuestoUnidad::find($request->id);
        $pres->presupuesto = $request->presupuesto;
        $result =$pres->save();
        if($result){
            return ["result"=>"Success, data is updated"];
        } else {
            return ["result"=>"Error, data didnt update"];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PresupuestoUnidad  $presupuestoUnidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(PresupuestoUnidad $presupuestoUnidad)
    {
        //
    }
}
