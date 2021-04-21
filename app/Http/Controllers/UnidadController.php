<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unidades = Unidad::latest()->paginate(10);
        
        return response()->json('unidades', ['message' => 'unidades encontrados'], 200);
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
            'nombre' => 'required|max:255',
            'facultad' => 'required|max:500',
            'presupuesto' => 'required|numeric| max:255',
            'telefono' => 'required| max:255',
            'user_id' => 'required| max:255'
        ]);

        if ($validator->fails()) {
            return  response()->json(['error' => 'Error de validación', $validator->errors()]);
        }

        $unidad = Unidad::create($data);
        return response()->json('unidad', ['message' => 'unidad guardada con exito'],201);
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

        return response()->json('unidad', ['message' => 'unidad encontrado'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unidad $unidad)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nombre' => 'required|max:255',
            'facultad' => 'required|max:500',
            'presupuesto' => 'required|numeric| max:255',
            'telefono' => 'required| max:255',
            'user_id' => 'required| max:255'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Error de validacion.', $validator->errors()]);       
        }
        
        $unidad = Unidad::find($request->id);
        $unidad->nombre = $data['nombre'];
        $unidad->facultad = $data['facultad'];
        $unidad->presupuesto = $data['presupuesto'];
        $unidad->telefono = $data['telefono'];
        $unidad->user_id = $data['user_id'];
        $unidad->save();

        return response()->json('unidad', ['message' => 'unidad actualizada con exito'], 200);
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
        $unidad->delete();

        return response()->json(['message' => 'unidad eliminado']);
    }
}
