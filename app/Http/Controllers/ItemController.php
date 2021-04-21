<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::latest()->paginate(10);
        

        return response()->json('items', ['message' => 'items encontrados'], 200);
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
            'nomitem' => 'required|max:255',
            'descrip' => 'required|max:500',
            'montoasig' => 'required|numeric| max:255',
            'periodo' => 'required| max:255'
        ]);

        if ($validator->fails()) {
            return  response()->json(['error' => 'Error de validación', $validator->errors()]);
        }

        $item = Item::create($data);
        return response()->json('item', ['message' => 'item guardado con exito'],201);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);

        if (is_null($item)) {
            return response()->json(['message' => 'item no encontrado']);
        }

        return response()->json('item', ['message' => 'item encontrado'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nomitem' => 'required|max:255',
            'descrip' => 'required|max:500',
            'montoasig' => 'required|numeric| max:255',
            'periodo' => 'required| max:255'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Error de validacion.', $validator->errors()]);       
        }
        
        $item = Item::find($request->id);
        $item->nomitem = $data['nomitem'];
        $item->descrip = $data['descrip'];
        $item->montoasig = $data['montoasig'];
        $item->periodo = $data['periodo'];
        $item->save();

        return response()->json('item', ['message' => 'item actualizado con exito'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();

        return response()->json(['message' => 'item eliminado']);
    }
}
