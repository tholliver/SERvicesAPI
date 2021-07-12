<?php

namespace App\Http\Controllers;
use App\Models\Informe;
use App\Models\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   //We update the solicitud -> estado 

       $user = auth()->user();

       $id_solit  = $request->get('id_solicitud');
         
       $newInforme = Informe::create([
            'nombre_cotizador' => $request->get('nombre_cotizador'),
            'tipo_informe' => $request->get('tipo_informe'),
            'informe_escrito' => $request->get('informe_escrito'),
            'id_solicitud' => $request->get('id_solicitud')
        ]);
        // $user = auth()->user();
        $newe = $newInforme;
        $requestID = request()->ip();
         //error_log($requestID);
        if($newInforme){
            $updatedReco = Solicitud::where('id','=',$id_solit)->update(['estado' => 'Concluido']); 
             // Add activity logs   
             
             activity('informes')
             ->performedOn($newInforme)
             ->causedBy($user)
             ->withProperties(['ip' => $requestID,
                               'user'=> $user,
                               'nuevo'=>$newe])
             ->log('created');
             //$user->name
        }
     
        return response()->json([
            'message' => 'Data processed successfully',
            'data' => [
                'infome' => $newInforme,
                'ID_updated' => $updatedReco
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function show(Informe $informe)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function getOneInforme($id)
    {
        $solicitud = Solicitud::find($id);
        $informe = $solicitud->informe;

        return response()->json($informe,201);
    }
  
       /**
     * Display the specified resource.
     *
     * @param  \App\Informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function getAllInformes()
    {
        $informes = Informe::all();
       
        return response()->json($informes,201);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function edit(Informe $informe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Informe $informe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Informe  $informe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Informe $informe)
    {
        //
    }
}
