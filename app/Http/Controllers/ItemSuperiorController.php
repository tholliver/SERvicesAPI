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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'nomitemSup' => 'required|max:255',
            'descripSup' => 'required|max:500',
        ]);
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

}
