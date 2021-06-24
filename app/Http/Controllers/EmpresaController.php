<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Empresa;
use DB;
use Illuminate\Support\Facades\Auth;


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
             'correo' => $request->get('correo'),
         ]);

         $user = auth()->user();
         $requestIP = request()->ip();
         //error_log($requestID);
        if($empresaguardar){
             // Add activity logs           
             activity('items')
             ->performedOn($empresaguardar)
             ->causedBy($user)
             ->withProperties(['ip' => $requestIP,
                               'user'=> $user])
             ->log('create');
        }

        return response()->json($empresaguardar,201);

        }

        $returnData = array(
         'status' => 'error',
         'message' => 'An error occurred!'
     );
        return response()->json($returnData, 400);
     }

    public function show($id){

    $empresa = Empresa::find($id);

        if (is_null($empresa)) {
            return response()->json(['message' => 'empresa no encontrada']);
        }

    return response()->json($empresa);
    }

    public function update($id, Request $request){
        $input = $request->all();

        $validator = Validator::make($input, [
            'nombreemp' => 'required',
            'repnombre' => 'required',
            'telefono' => 'required',
            'diremp' => 'required',
            'rubro' => 'required',
            'nit' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message' => 'Error de validacion.', $validator->errors()]);
        }

        $empresa = Empresa::find($id);
        $empresa->nombreemp = $input['nombreemp'];
        $empresa->repnombre = $input['repnombre'];
        $empresa->telefono = $input['telefono'];
        $empresa->diremp = $input['diremp'];
        $empresa->rubro = $input['rubro'];
        $empresa->nit = $input['nit'];
        $empresa->save();

        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($empresa){
            // Add activity logs           
            activity('empresa')
            ->performedOn($empresa)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user])
            ->log('update');
       }
        return response()->json($empresa, 200);
    }

    public function destroy($id)
    {
        $unidad = Empresa::find($id);
        $unidad->delete();

        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($unidad){
            // Add activity logs           
            activity('empresa')
            ->performedOn($unidad)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user])
            ->log('update');
       }

        return response()->json(['message' => 'empresa eliminado']);
    }

    public function empresInfo($nombre)
    {
        $empresa= DB::table('empresas')
        ->where('nombreemp',$nombre)->get();
        return response()->json($empresa ,201);
    }
    public function empresInfo1($nombre)
    {
        $unidad = Empresa::find($nombre);
        return response()->json($nombre, 200);
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
