<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Seeder;

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
        ini_set('max_execution_time', 3000);
       //       
       //$backupRes = shell_exec('php artisan backup:list');
       //$fiels = shell_exec('cd .. &&  php artisan backup:run --only-db');
      $fiels = shell_exec('cd .. && php artisan backup:run --only-db');
       
       //$fiels = shell_exec('php artisan backup:list');

       //Lets create a verificaition log
       $user = auth()->user();
       $requestIP = request()->ip();
      
/*
       //sleep(300);
      if($fiels){
           // Add activity logs
           activity('backup')
           ->causedBy($user)
           ->withProperties(['ip' => $requestIP,
                             'user'=> $user])
           ->log('created');
       }
       */
    
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

    public function testFunc(Request $request){
        //on the request get ----> the name file to unzip
        ini_set('max_execution_time', 3000);
       
        $file = storage_path('app\Laravel\2021-07-02-082434.zip');
        
        $stup = \Zipper::make($file)->extractTo('restoration');
        $b = public_path('restoration\8vC9ZQ2AJT.sql');

        //$fiels = shell_exec('cd .. && cd storage && cd app && cd Laravel && ls -a');
        //$backing = shell_exec("cd C:\xampp\mysql\bin && mysql -u ".\Config::get('database.mysql.user')." -p".\Config::get('database.mysql.password')." ".\Config::get('database.mysql.database')." < ".$b);
        //$var = shell_exec('cd C:\xampp\mysql\bin && ls -a');

        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');
        
        //$ts = time();


        //$file = date('Y-m-d-His', $ts) . '-dump-' . $database . '.sql';
        $command = sprintf('mysql -u %s -p%s %s  < %s', $username, $password, $database, $b);
      

        $massa1 = shell_exec($command);
        
    return response()->json($massa1, 201);

    }
}
