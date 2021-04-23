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
        $incomingdata = $request->json()->all();
               
        $items = $incomingdata["items"];
        //Verify if exits all the items
        $results = Item::whereIn('id', $items )->count();

        if($results !== count($items)){            
            $datas = [
                'status'=>"Items no encotrados",
                'message' => "Items no encotrados"
            ];
            //throw new Exception("All records don't exist");
            return response()->json(compact('datas'),201);
        }

        $newsolicitud = Solicitud::create([
            'responsable' => $request->get('responsable'),
            'montoestimado' => $request->get('montoestimado'),       
            'estado' => $request->get('estado'),     
        ]);
         
        $newsolicitud->items()->attach($items);
       
        return response()->json(compact('newsolicitud'),201);              
        
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
        
        $solicitud = Solicitud::find($request->id);
        $solicitud->estado = $request->estado;
        $result = $solicitud->save();
        if($result){
            return ["result"=>"Success, data is updated"];
        } else {
            return ["result"=>"Error, data didnt update"];
        }        
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
