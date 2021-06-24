<?php
namespace App\Http\Controllers;
use App\Models\ItemPres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class ItemPresController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response

     */
    protected $table = 'unidadasignacionitems';
    public function index()
    {
        return ItemPres::all();
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
    if($request->has('unidad_id')){
        $unidadasignacion = ItemPres::create([
            'unidad_id' => $request->get('unidad_id'),
            'itemsuperior_id' => $request->get('itemsuperior_id'),
            'montoasig' => $request->get('montoasig'),
            'periodo' => $request->get('periodo'),
        ]);

        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($unidadasignacion){
            // Add activity logs           
            activity('itemscotizados')
            ->performedOn($unidadasignacion)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user])
            ->log('create');
       }

        return response()->json($unidadasignacion,201);
        }

        $returnData = array(
         'status' => 'error',
         'message' => 'An error occurred!'
     );
        return response()->json($returnData, 400);
     }

     public function obtenerPresItem($idUni, $periodo)
     {
         $items = DB::table('unidadasignacionitems')
         ->select('item_superiors.nomitemSup','montoasig','unidadasignacionitems.id')
         ->join('item_superiors', 'unidadasignacionitems.itemsuperior_id', '=', 'item_superiors.id')
         ->where('unidad_id',$idUni)
         ->where('periodo',$periodo )->get();
         return response()->json($items ,201);
     }
     public function obtenerPresItemSum($idUni, $periodo)
     {
         $items = DB::table('unidadasignacionitems')
         //->select('item_superiors.nomitemSup','montoasig')
         ->join('item_superiors', 'unidadasignacionitems.itemsuperior_id', '=', 'item_superiors.id')
         ->where('unidad_id',$idUni)
         ->where('periodo',$periodo )->get()
         ->sum('montoasig');
         return response()->json($items ,201);
     }
     public function obtenerAnios($idUni)
     {
         $items = DB::table('unidadasignacionitems')
         ->select('periodo')->distinct()
         ->orderBy('periodo', 'asc')
         ->where('unidad_id',$idUni)->get();
         return response()->json($items ,201);
     }
     public function obtenerAnios1($idUni)
     {
         $items = DB::table('presupuesto_unidads')
         ->select('gestion')->distinct()
         ->orderBy('gestion', 'asc')
         ->where('id_unidad',$idUni)->get();
         return response()->json($items ,201);
     }

     public function destroy($id)
     {
      $items = DB::table('unidadasignacionitems')
      ->where('id', $id)
      ->delete();
      return response()->json($items ,201);
     }
///////////////////////////////

}
