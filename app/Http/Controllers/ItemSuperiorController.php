<?php

namespace App\Http\Controllers;

use App\Models\ItemSuperior;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;

class ItemSuperiorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return ItemSuperior::all();
        // $items = Item::latest()->paginate(50);
        $user = DB::table('item_superiors')
        ->select('nomitemSup','descripSup','id')
        ->where('visible','=','1')->get();
        return response()->json($user ,201);
    }

    public function verificar($nombre)
    {
        $items = DB::table('item_superiors')
        ->where('nomitemSup',$nombre)
         ->where('visible','=','1' )->get();
        return response()->json($items ,201);
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
    //if($request->has('nomitemSup')){
        //$itemsitoSup = ItemSuperior::create([
          //  'nomitemSup' => $request->get('nomitemSup'),
          //  'descripSup' => $request->get('descripSup'),
        //]);
        //////////////////////////////
        $superior = new ItemSuperior;
        $superior->nomitemSup = $request->nomitemSup;
        $superior->descripSup = $request->descripSup;
        $superior->visible ='1';
        $newes = $superior;
        $superior->save();
        //////////////////////////////


        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($superior){
            // Add activity logs
            activity('itemscotizados')
            ->performedOn($superior)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user,
                              'nuevo'=>$newes])
            ->log('created');
      // }

    return response()->json($itemsitoSup,201);

    }

    /*$returnData = array(
        'status' => 'error',
        'message' => 'An error occurred!'
    );*/
    return response()->json($returnData, 400);
    }




    public function show($id)
    {

        $item = ItemSuperior::find($id);

        if (is_null($item)) {
            return response()->json(['message' => 'item no encontrado']);
        }

        return response()->json($item, 200);
    }

    public function update($id, Request $request){
        $input = $request->all();
        $validator = Validator::make($input, [
            'nomitemSup' => 'required',
            'descripSup' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $item = ItemSuperior::find($id);
        $olddata = $item;
        $item->nomitemSup = $input['nomitemSup'];
        $item->descripSup = $input['descripSup'];
        $itemUpdated = $item->getDirty();
        $item->save();

        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($item){
            // Add activity logs
            activity('itemsuperior')
            ->performedOn($item)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user,
                              'nuevo'=> $itemUpdated,
                              'anterior'=>$olddata])
            ->log('updated');
       }

        return response()->json(['item' => $input], 200);
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
        //$item->delete();
        ItemSuperior::where('id','=',$id)->update(['visible' => '0']);


        $user = auth()->user();
        $requestIP = request()->ip();
        //error_log($requestID);
       if($item){
            // Add activity logs
            activity('itemsuperior')
            ->performedOn($item)
            ->causedBy($user)
            ->withProperties(['ip' => $requestIP,
                              'user'=> $user])
            ->log('deleted');
       }

        return response()->json(['message' => 'item eliminado']);
    }

}
