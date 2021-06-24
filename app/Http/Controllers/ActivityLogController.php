<?php

namespace App\Http\Controllers;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

//Getting stats
use App\Models\User;
use App\Models\Solicitud;
use App\Models\EmpresaCotizacion;
use App\Models\Unidad;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $activities = Activity::all();
        return response()->json($activities);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInformes()
    {   
        $activities = Activity::where('subject_type','App\Models\Informe')->get();
        return response()->json($activities);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStats()
    {   
        $users = User::all()->count();  
        $solicitudes = Solicitud::all()->count();  
        $cotizaciones = EmpresaCotizacion::all()->count();  
        $unidades = Unidad::all()->count();
        /*  */
        $fullDate = Carbon::now();
        $actualYear = $fullDate->year;  
        $montosAsignados = DB::table('unidadasignacionitems')
        ->where('periodo',$actualYear)->sum('montoasig');

        return response()->json([
            'users' => $users,
            'solicitudes' => $solicitudes,
            'cotizaciones' => $cotizaciones,
            'unidades' => $unidades,
            'totalasignacion'=>$montosAsignados
        ]);        
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
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
