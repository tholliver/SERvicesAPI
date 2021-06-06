<?php

namespace App\Http\Controllers;

use App\Models\EmpresaCotizacion;
use App\Models\Solicitud;
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
        return EmpresaCotizacion::all();
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
         $empCot = EmpresaCotizacion::create([
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

    public function update(Request $request, $id)
    {
        $input = $request->all();

        $empresaCot = EmpresaCotizacion::Find($id);
        $empresaCot->observaciones = $input['observaciones'];
        $empresaCot->plazo_de_entrega = $input['plazo_de_entrega'];
        $empresaCot->validez_oferta = $input['validez_oferta'];
        $empresaCot->total = $input['total'];
        $empresaCot->save();

        return response([ 'message' => 'actualizado'], 200);
    }


    public function recomendacionUpdate(Request $request)
    {
        $id  = $request->get('id');
        $updatedReco = EmpresaCotizacion::where('id','=',$id)->update(['eleccion' => 'Si']);
        return response()->json($updatedReco,201);
    }

    //Gettin the buck data
    public function cotizacionItems($id)
    {
        $cotizacionWithItems = EmpresaCotizacion::where('id_solicitud',$id)->with('itemscot')->get();

    
        return response()->json($cotizacionWithItems,201);
    }

     public function empresaCotizacion($id)
     {
        //$cotizacion1 = EmpresaCotizacion::where('id_solicitud',$id)->all();

        $solicitud = Solicitud::find($id);
        $empresasWithCot = $solicitud->cotizacionesEmpresa;
           
         return response()->json($empresasWithCot,201);
     }
}
