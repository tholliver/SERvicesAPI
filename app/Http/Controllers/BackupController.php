<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BackupController extends Controller
{
    //
      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function newBack(Request $request)
    {
       //       
       $backupRes = shell_exec('php artisan backup:list');
       $fiels = shell_exec('cd .. && php artisan backup:run --only-db');

       //Lets create a verificaition log
       $user = auth()->user();
       $requestIP = request()->ip();
       //error_log($requestID);
       $object = new stdClass();
       $object->name  = 'Backup';

       $object1 = new stdClass();
       $object->name  = 'User';
      if($fiels){
           // Add activity logs
           activity('backup')
           ->performedOn($object)
           ->causedBy($object1)
           ->withProperties(['ip' => $requestIP,
                             'user'=> $user])
           ->log('created');
       }
       // $fiels = shell_exec('cd .. && cd storage && cd app && cd Laravel && ls -a');

       //$backupRes = [];
       return response()->json($fiels, 200);
    }

    public function getBacks(Request $request)
    {
        $pathL = public_path('Laravel');
        //$files = Storage::allFiles($pathL); 
        $fiels = shell_exec('cd .. && cd storage && cd app && cd Laravel && ls ');
        $b = preg_split("/[\n]/",$fiels);
        
        //error_log($pathL);
       return response()->json($b, 201);
    }
}
