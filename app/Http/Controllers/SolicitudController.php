<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return Solicitud::all();
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
    public function nuevasolicitud (Request $request){
        $data = $request->json()->all();
        /*
        $solicitud=$data[0];
        $items=$data[1];

        $newsolicitud = Solicitud::create([
            'responsable' => $solicitud->get('responsable'),
            'montoestimado' => $solicitud->get('montoestimado'),       
            'estado' => $solicitud->get('estado'),     
        ]);
         
        $newsolicitud->items()->attach($items);
       */

        return response()->json(compact('data'),201);
        //Here create a new solicitud
        //$last3 = DB::table('solicituds')->latest('id')->first();
        
        /*
        if($request->has('')){
            $rol = Rol::create([
                'rolnom' => $request->get('rolnom'),
                'descrip' => $request->get('descrip'),            
            ]);
    
           return response()->json(compact('rol'),201);
                
           }
       */
                 
        
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
     * @param  \App\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function show(Solicitud $solicitud)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function edit(Solicitud $solicitud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Solicitud $solicitud)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Solicitud  $solicitud
     * @return \Illuminate\Http\Response
     */
    public function destroy(Solicitud $solicitud)
    {
        //
    }
}
