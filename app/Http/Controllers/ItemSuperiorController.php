<?php

namespace App\Http\Controllers;

use App\Models\ItemSuperior;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ItemSuperiorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ItemSuperior::all();
        // $items = Item::latest()->paginate(50);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  allItemsOnSup($id)
    {
        $itemSup = ItemSuperior::find($id);
        $items = $itemSup->items;
        return response()->json($items,201);
        // $items = Item::latest()->paginate(50);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
     {
        if($request->has('nomitemSup')){
         $itemsitoSup = ItemSuperior::create([
             'nomitemSup' => $request->get('nomitemSup'),
             'descripSup' => $request->get('descripSup'),
         ]);

        return response()->json($itemsitoSup,201);

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
     * @param  \App\ItemSuperior  $item
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ItemSuperior  $item
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ItemSuperior  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = ItemSuperior::find($id);
        $item->delete();

        return response()->json(['message' => 'item eliminado']);
    }

}
