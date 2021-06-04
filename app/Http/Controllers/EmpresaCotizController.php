<?php

namespace App\Http\Controllers;

use App\Models\EmpresaCotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class EmpresaCotizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return EmpresaCot::all();
        // $items = Item::latest()->paginate(50);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
        if($request->has('id_solicitud')){
         $empCot = EmpresaCot::create([
             'id_solicitud' => $request->get('id_solicitud'),
             'id_empresa' => $request->get('id_empresa'),
         ]);

        return response()->json($empCot,201);

        }

        $returnData = array(
         'status' => 'error',
         'message' => 'An error occurred!'
     );
        return response()->json($returnData, 400);
     }












































     
     //Gettin the buck data
     public function empresaCotizacion($id)
     {
        $cotizacion = EmpresaCotizacion::where('id_solicitud',$id)->get();

        //$empresadetails = $cotizacion->empresas; //only one
        //$itemscotizados = $cotizacion->itemscot; //Tmay of this class type
        
        //So the result
        /*
        $result = array(
            'detalles'=> $cotizacion,
            'empresadetalles'=> $empresadetails,
            'itemscotizados'=> $itemscotizados
        );
        */

        $object = json_decode(json_encode($result));
         return response()->json($cotizacion,201);
     }



}
