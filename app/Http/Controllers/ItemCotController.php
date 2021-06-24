<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CotizacionItem;

class ItemCotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CotizacionItem::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('empresa_cotizacion_id')){
            $itemCotizacion = CotizacionItem::create([
                'nombre' => $request->get('nombre'),
                'descripcion' => $request->get('descripcion'),
                'cantidad' => $request->get('cantidad'),
                'precioUnitario' => $request->get('precioUnitario'),
                'total' => $request->get('total'),
                'empresa_cotizacion_id' => $request->get('empresa_cotizacion_id')
            ]);

            $user = auth()->user();
            $requestIP = request()->ip();
            //error_log($requestID);
           if($itemCotizacion){
                // Add activity logs           
                activity('itemscotizados')
                ->performedOn($itemCotizacion)
                ->causedBy($user)
                ->withProperties(['ip' => $requestIP,
                                  'user'=> $user])
                ->log('created');
           }
            return response()->json($itemCotizacion,201);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $item = CotizacionItem::find($id);
        $item->delete();

        return response()->json(['message' => 'item eliminado']);
    }
}
