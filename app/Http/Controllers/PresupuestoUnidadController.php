<?php

namespace App\Http\Controllers;

use App\Models\PresupuestoUnidad;
use App\Models\Unidad;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class PresupuestoUnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  return PresupuestoUnidad::all();
        $user = DB::table('presupuesto_unidads')
        ->select('id_unidad','presupuesto','gestion','id')
        ->where('visible','=','1')->get();
        return response()->json($user ,201);
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

              /*
                 $pres = PresupuestoUnidad::create([
                     'id_unidad' => $request->get('id_unidad'),
                     'presupuesto' => $request->get('presupuesto'),
                     'gestion' => $request->get('gestion'),
                      'visible'-> 1,
                 ]);*/

                 $pres = new PresupuestoUnidad;
                 $pres->id_unidad= $request->id_unidad;
                 $pres->presupuesto = $request->presupuesto;
                 $pres->gestion = $request->gestion;;
                 $pres->visible ='1';
                 $pres->save();




                 $newdata = $pres;
                 $user = auth()->user();
                 $requestIP = request()->ip();
                 //error_log($requestID);
                if($pres){
                     // Add activity logs
                     activity('presupuesto')
                     ->performedOn($pres)
                     ->causedBy($user)
                     ->withProperties(['ip' => $requestIP,
                                       'user'=> $user,
                                       'nuevo'=>$newdata])
                     ->log('created');
                }
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

    public function presupuestoId($id, $gestion){
       // $id = $request->input('id');
        $presupuesto = DB::table('presupuesto_unidads')
                ->where('id_unidad', '=', $id)
                ->where('gestion','=', $gestion)
                ->get();
        return response()->json($presupuesto);
    }

    public function getDatos() {
        $presupuestos = DB::table('presupuesto_unidads')
            ->select('unidads.nombre','presupuesto_unidads.presupuesto','presupuesto_unidads.gestion','presupuesto_unidads.id')
            ->join('unidads', 'presupuesto_unidads.id_unidad', '=', 'unidads.id')
            ->where('presupuesto_unidads.visible','=','1')->get();
        return response()->json($presupuestos);
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
        $olddata = $pres;
        $pres->presupuesto = $request->presupuesto;
        $itemUpdated = $pres->getDirty();
        $result = $pres->save();

        $user = auth()->user();
        $requestIP = request()->ip();

      //  if($result){
             // Add activity logs

          activity('presupuesto')
             //->performedOn($pres)
             ->causedBy($user)
             ->withProperties(['ip' => $requestIP,
                               'user'=> $user,
                               'nuevo'=> $itemUpdated,
                               'anterior'=>$olddata])
             ->log('updated');
            //return ["result"=>"Success, data is updated"];


      /*  } else {
            return ["result"=>"Error, data didnt update"];
        }*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PresupuestoUnidad  $presupuestoUnidad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pres = PresupuestoUnidad::find($id);
        $del = $pres;
        //$pres->delete();
        PresupuestoUnidad::where('id','=',$id)->update(['visible' => '0']);


        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($pres){
            // Add activity logs
            activity('presupuesto')
            ->performedOn($pres)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user,
                              'anterior'=>$del])
            ->log('deleted');
       }
        return response()->json(['message' => 'item eliminado']);
    }
}
