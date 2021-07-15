<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user = DB::table('solicituds')
      ->select('supera','estado','montoestimado','responsable','tipo','unidad_nombre','id','unidad_id','created_at','updated_at')
      ->where('visible','=','1')->get();
      return response()->json($user ,201);
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
     * Display the specified resource.
     *
     * @param  \App\Models\Solicitud  $item
     * @return \Illuminate\Http\Response
     */
    public function solicitudItems($id)
    {
        $solicitud = Solicitud::find($id);
        $items = $solicitud->items;

        return response()->json($items,201);
    }

    public function solicitudItemsPivot()
    {
        $solicitudes = Solicitud::with('items')->get();
        return response()->json($solicitudes,201);
    }

    public function solicitudItems2($solicitud_idR){
    $solicitudes3 = DB::table('item_solicitud')
            ->where('solicitud_id', '=', $solicitud_idR)
            ->get();
    return response()->json($solicitudes3);
  }

    public function solicitud3($solicitud_idR){
    $solicitudes4 = DB::table('solicituds')
            ->where('id', '=', $solicitud_idR)
            ->get();
    return response()->json($solicitudes4);
    }


    public function nuevasolicitud(Request $request){
        $incomingdata = $request->json()->all();

        $items = $incomingdata["items"];
        $itemsobs = $incomingdata["itemsobs"];
        //Verify if exits all the items
        $results = Item::whereIn('id', $items)->count();

        if($results !== count($items)){
            $datas = [
                'status'=>"Items no encotrados",
                'message' => "Items no encotrados en la DB, deben estar registrados"
            ];
            //throw new Exception("All records don't exist");
            return response()->json(compact('datas'),201);
        }

        $newsolicitud = new Solicitud;
        $newsolicitud ->unidad_id = $request->unidad_id;
        $newsolicitud ->unidad_nombre = $request->unidad_nombre;
        $newsolicitud ->tipo = $request->tipo;
        $newsolicitud ->responsable = $request->responsable;
        $newsolicitud ->montoestimado = $request->montoestimado;
        $newsolicitud ->estado = $request->estado;
        $newsolicitud ->supera = $request->supera;
        $newsolicitud ->visible ='1';
        $newsolicitud ->save();



        $newsolicitud->items()->attach($itemsobs);


         $user = auth()->user();
         $requestIP = request()->ip();
         //error_log($requestID);
        if($newsolicitud){
             // Add activity logs

             activity('solicitudes')
             ->performedOn($newsolicitud)
             ->causedBy($user)
             ->withProperties(['ip' => $requestIP,
                               'user'=> $user,
                               'nuevo'=> $newsolicitud])
             ->log('created');
        }
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
        $olds = $solicitud;
        $solicitud->estado = $request->estado;
        $itemUpdated = $solicitud->getDirty();
        $result = $solicitud->save();



        if($result){
        $user = auth()->user();
        $requestID = request()->ip();

            activity('solicitud')
            ->performedOn($result)
            ->causedBy($user)
            ->withProperties(['ip' => $requestID,
                              'user'=> $user,
                              'nuevo'=> $itemUpdated,
                              'anterior'=>$olds])
            ->log('updated');
            //$user->name

            return ["result"=>"Success, data is updated"];
        } else {
            return ["result"=>"Error, data didnt update"];
        }

    }

    public function update1(Request $request, Solicitud $solicitud)
    {
        $libros_mario_puzo = DB::table('solicituds')
        //$estado444='estado';
        ->where('id',$request->id)
        ->where('unidad_id',$request->unidad_id )
        ->update(
              ['estado' => $request->estado, 'montoestimado' =>$request->montoestimado ,'tipo'=> $request->tipo],
        ['supera' => 'Quizas']
                );
    }
    /**
     * Show a list of all of the application's users.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudesAceptadas()
    {
        $solicitudes = DB::table('solicituds')
                ->where('estado', '=', 'Aceptada')
                ->where('visible', '=', '1')
                ->get();
        return response()->json($solicitudes);
    }

    /**
     * Show a list of all of the application's users.
     *
     * @return \Illuminate\Http\Response
     */
    public function solicitudesRechazadas()
    {
        $solicitudes = DB::table('solicituds')
                ->where('estado', '=', 'Rechazada')
                ->where('visible', '=', '1')
                ->get();
        return response()->json($solicitudes);
    }

    public function solicitudesPendientes()
    {
        $solicitudes = DB::table('solicituds')
                ->where('estado', '=', 'Pendiente')
                ->where('visible', '=', '1')
                ->get();
        return response()->json($solicitudes);
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
