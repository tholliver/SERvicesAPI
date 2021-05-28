<?php

namespace App\Http\Controllers;

use App\Models\Fecha;
use Illuminate\Http\Request;
use DB;

class FechaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Fecha::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('apertura')){
            $rol = Fecha::create([
                'apertura' => $request->get('apertura'),
                'cierre' => $request->get('cierre'),            
            ]);
    
           return response()->json(compact('fecha'),201);                
           }
    
           $returnData = array(
            'status' => 'error',
            'message' => 'An error occurred!'
        );
           return response()->json($returnData, 400);
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fecha  $fecha
     * @return \Illuminate\Http\Response
     */
    public function show(Fecha $fecha)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fecha  $fecha
     * @return \Illuminate\Http\Response
     */
    public function getUltimaFecha()
    {
//        return DB::table('fechas')->orderBy('created_at', 'desc')->first();
        return Fecha::latest()->first();
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fecha  $fecha
     * @return \Illuminate\Http\Response
     */
    public function edit(Fecha $fecha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fecha  $fecha
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fecha $fecha)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fecha  $fecha
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fecha $fecha)
    {
        //
    }
}
