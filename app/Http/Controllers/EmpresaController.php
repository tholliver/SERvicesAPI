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
      $user = DB::table('empresas')
      ->select('nombreemp','repnombre','telefono','diremp','rubro','nit','created_at','updated_at','id')
      ->where('visible','=','1')->get();
      return response()->json($user ,201);
    }
    public function index2()
    {
      $user = DB::table('empresas')
      ->select('nombreemp','repnombre','telefono','diremp','rubro','nit','created_at','updated_at','id')
      ->where('visible','=','0')->get();
      return response()->json($user ,201);
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
         $itemUpdated = $empresaguardar;
         $user = auth()->user();
         $requestIP = request()->ip();
         //error_log($requestID);
        if($empresaguardar){
             // Add activity logs
             activity('empresa')
             ->performedOn($empresaguardar)
             ->causedBy($user)
             ->withProperties(['ip' => $requestIP,
                               'user'=> $user,
                               'nuevo'=> $itemUpdated])
             ->log('created');
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
        $olddata = $empresa;
        $empresa->nombreemp = $input['nombreemp'];
        $empresa->repnombre = $input['repnombre'];
        $empresa->telefono = $input['telefono'];
        $empresa->diremp = $input['diremp'];
        $empresa->rubro = $input['rubro'];
        $empresa->nit = $input['nit'];
        $itemUpdated = $empresa->getDirty();
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
                              'user'=> $user,
                              'nuevo'=> $itemUpdated,
                              'anterior'=>$olddata])
            ->log('updated');
       }
        return response()->json($empresa, 200);
    }

    public function destroy($id)
    {
        $unidad = Empresa::find($id);
        $itemdl = $unidad;
        Empresa::where('id','=',$id)->update(['visible' => '0']);

        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($unidad){
            // Add activity logs
            activity('empresa')
            ->performedOn($unidad)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user,
                              'anterior'=> $itemdl])
            ->log('deleted');
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

     public function verificar($nombre)
     {
         $items = DB::table('empresas')
         ->where('nombreemp',$nombre)->get();
         return response()->json($items ,201);
     }
     public function restauracion($id)
     {
         Empresa::where('id','=',$id)->update(['visible' => '1']);
         return response()->json(['message' => 'empresa restaurada']);
     }


}
