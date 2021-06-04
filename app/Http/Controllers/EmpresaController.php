<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Empresa;
use DB;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response

     */
    protected $table = 'empresas';
    public function index()
    {
        return Empresa::all();
        // $items = Item::latest()->paginate(50);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     //'unidad_id', 'itemsuperior_id', 'montoasig','periodo',
     public function store(Request $request)
     {
        if($request->has('nombreemp')){
         $empresaguardar = Empresa::create([
             'nombreemp' => $request->get('nombreemp'),
             'repnombre' => $request->get('repnombre'),
             'telefono' => $request->get('telefono'),
             'diremp' => $request->get('diremp'),
             'rubro' => $request->get('rubro'),
             'nit' => $request->get('nit'),
         ]);

        return response()->json($empresaguardar,201);

        }

        $returnData = array(
         'status' => 'error',
         'message' => 'An error occurred!'
     );
        return response()->json($returnData, 400);
     }

     public function infoEmpresa($info_idE){
     $empresainfo = DB::table('empresas')
             ->where('nombreemp', '=', $info_idE)
             ->get();
     return response()->json($empresainfo);
   }















































   public function cotizacion($id)
    {
         $cotizacion = Empresa::all()->cotizaciones->where('id_solicitud',$id);

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
