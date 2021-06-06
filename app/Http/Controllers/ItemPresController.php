<?php
namespace App\Http\Controllers;
use App\Models\ItemPres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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

        return response()->json($unidadasignacion,201);
        }

        $returnData = array(
         'status' => 'error',
         'message' => 'An error occurred!'
     );
        return response()->json($returnData, 400);
     }



}
