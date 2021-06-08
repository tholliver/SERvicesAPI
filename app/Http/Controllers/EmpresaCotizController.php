<?php

namespace App\Http\Controllers;

use App\Models\EmpresaCotizacion;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

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

    public function obtenerCotizacion($idSol, $idEmp)
    {
        $libros_mario_puzo = DB::table('empresa_cotizacion')
        ->select('id')
        ->where('id_empresa',$idEmp)
        ->where('id_solicitud',$idSol )->get();
        return response()->json($libros_mario_puzo,201);
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

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        //dump($request);
         //Procesando archivo
         $file = $request->file('cotizacion_pdf');
         $nombre = "pdf_".time().".".$file->getClientOriginalExtension();
         $rute1 = $request->file("cotizacion_pdf")->move(public_path()."/pdf", $nombre); //Moving the file to public route
        
         $ruta = 'public/pdf/'.$nombre;
         //$request->file("cotizacion_pdf")->move(public_path("pdf/".$nombre));
   
        $empresaCot = EmpresaCotizacion::Find($id);
        $empresaCot->observaciones = $input['observaciones'];
        $empresaCot->plazo_de_entrega = $input['plazo_de_entrega'];
        $empresaCot->validez_oferta = $input['validez_oferta'];
        $empresaCot->total = $input['total'];
        $empresaCot->cotizacion_pdf = $ruta;
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
