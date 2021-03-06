<?php

namespace App\Http\Controllers;

use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class UnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     ///////////////////
    public function index()
    {
        //$unidades = Unidad::all();
        // $unidades = Unidad::latest()->paginate(10);
        //return response()->json(['unidades' => $unidades, 'message' => 'unidades encontrados'], 200);


        $user = DB::table('unidads')
        ->select('nombre','facultad','telefono','id')
        ->where('visible','=','1')->get();
        return response()->json($user ,201);
    }
    public function index22()
    {
        $user = DB::table('unidads')
        ->select('nombre','facultad','telefono','id')
        ->where('visible','=','0')->get();
        return response()->json($user ,201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'nombre' => 'required|max:255|unique:unidads',
            'facultad' => 'required|max:500',
            'telefono' => 'required| max:255'
            ]);

        if ($validator->fails()) {
            return  response()->json([$validator->errors()], 400);
        }
        //$unidad = Unidad::create($data);
        $unidad = new Unidad;
        $unidad->nombre = $request->nombre;
        $unidad->facultad = $request->facultad;
        $unidad->telefono = $request->telefono;
        $unidad->visible ='1';
        $itemUpdated = $unidad;
        $unidad->save();
        ///////////////
        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($unidad){
            // Add activity logs
            activity('unidades')
            ->performedOn($unidad)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user,
                              'nuevo'=> $itemUpdated])
            ->log('created');
       }

        return response()->json(['unidad' => $unidad, 'message' => 'unidad guardada con exito'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $unidad = Unidad::find($id);

        if (is_null($unidad)) {
            return response()->json(['message' => 'unidad no encontrado']);
        }

        return response()->json($unidad, 200);
    }

    public function show2($id)
    {
      $info = DB::table('unidads')
              ->where('id', '=', $id)
              ->get();
      return response()->json($info);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nombre' => 'required|max:255',
            'facultad' => 'required|max:500',
            //'presupuesto' => 'required|numeric',
            'telefono' => 'required| max:255'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Error de validacion.', $validator->errors()]);
        }

        $unidad = Unidad::find($request->id);
        $olddata = $unidad;
        $unidad->nombre = $data['nombre'];
        $unidad->facultad = $data['facultad'];
        //$unidad->presupuesto = $data['presupuesto'];
        $unidad->telefono = $data['telefono'];
        $itemUpdated = $unidad->getDirty();
        $unidad->save();

        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($unidad){
            // Add activity logs
            activity('unidad')
            ->performedOn($unidad)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user,
                              'nuevo'=> $itemUpdated,
                              'anterior'=>$olddata])
            ->log('updated');
       }

        return response()->json($unidad, 200);
    }

      /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unidad
     * @return \Illuminate\Http\Response
     */
    public function unidadItemsSuperiores($id)
    {
        $unidad = Unidad::find($id);
        $itemSuperiores = $unidad->assign;

        return response()->json($itemSuperiores,201);
    }
       /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unidad
     * @return \Illuminate\Http\Response
     */
    public function unidadItemsSuperioresActuales($id)
    {
        $unidad = Unidad::find($id);
        $itemSuperiores = $unidad->assignActual;

        return response()->json($itemSuperiores,201);
    }

      /**
     * Display the specified resource.
     *
     * @param  \App\Models\DB
     * @return \Illuminate\Http\Response
     */
    public function allUnidadItems()
    {
       $unidadAsings = DB::table('unidads')
            ->join('unidadasignacionitems', 'unidads.id', '=', 'unidadasignacionitems.unidad_id' )
            ->get();
            return response()->json($unidadAsings,201);
    }

    public function getUnidadByName(Request $request)
    {
        $nombreUD = $request->get('nombreUD');
        $unidad = Unidad::where('nombre',$nombreUD)->first();
        $idUnidad = $unidad->id;
        return response()->json(compact('idUnidad'),201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unidad = Unidad::find($id);
        //$unidad->delete();
        $prueba = DB::table('presupuesto_unidads')
        ->select('id')
        ->where('id_unidad','=',$id)
        ->update(['visible' => '0']);

        Unidad::where('id','=',$id)->update(['visible' => '0']);

        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($unidad){
            // Add activity logs
            activity('unidad')
            ->performedOn($unidad)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user])
            ->log('deleted');
       }

        return response()->json(['message' => 'unidad eliminado']);
    }


    public function verificar($nombre)
    {
        $items = DB::table('unidads')
        ->where('nombre',$nombre)
         ->where('visible','=','1' )->get();
        return response()->json($items ,201);
    }
    public function restauracion($id)
    {
        $unidad = Unidad::find($id);
        //$unidad->delete();
        $prueba = DB::table('presupuesto_unidads')
        ->select('id')
        ->where('id_unidad','=',$id)
        ->update(['visible' => '1']);

        Unidad::where('id','=',$id)->update(['visible' => '1']);


        return response()->json(['message' => 'unidad restaurada']);
    }

}
