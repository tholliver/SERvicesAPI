<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemSuperior;
use App\Models\Solicitud;
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
        $items = Item::all();
        // $items = Item::latest()->paginate(50);
        //Cambiando la respuesta a solo un array 
        return response()->json($items, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)    
    {
        $validator = Validator::make($request->all(), [

            'nomitem' => 'required|max:255',
            'descrip' => 'required|max:500',
            'itemsuperior' => 'required|max:5000'
        ]);

        if ($validator->fails()) {
            return  response()->json(['error' => 'Error de validación', $validator->errors()]);
        }

        $unidadName = $request->get('itemsuperior');
        $itemsuperior = ItemSuperior::where('nomitemSup',$unidadName)->first()->id;

        $item = Item::create([
            'nomitem' => $request->get('nomitem'),
            'descrip' => $request->get('descrip'),           
            'item_general_id' => $itemsuperior,
        ]);


        return response()->json(['item' => $item, 'message' => 'item guardado con exito'],201);
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

        return response()->json(['items' => $items, 'message' => 'item encontrado'], 200);
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
            'montoasig' => 'required|numeric| max:10000000',
            'periodo' => 'required| max:255',
            'unidaddegasto' => 'required| max:255'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Error de validacion.', $validator->errors()]);
        }

        $item = Item::find($request->id);
        $item->nomitem = $data['nomitem'];
        $item->descrip = $data['descrip'];
        $item->montoasig = $data['montoasig'];
        $item->periodo = $data['periodo'];
        $item->unidaddegasto = $data['unidaddegasto'];
        $item->save();

        return response()->json(['items' => $items, 'message' => 'item actualizado con exito'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo($item);
        $item = Item::find($id);
        $item->delete();

        return response()->json(['message' => 'item eliminado']);
    }
}
