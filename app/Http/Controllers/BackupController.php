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

        //get the filename
        
        $filename = $request->nom;
        
        $fileUnzipedPath = "app\Laravel";
        $files = storage_path("app\Laravel\\".$filename);
        /*
         $files = storage_path("app\\Laravel\\".''.$file);
       
       */
        
        $stup = \Zipper::make($files)->extractTo('restoration');

        $b = public_path('restoration\\testapp.sql');

        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        $command = sprintf('cd c:\xampp\mysql\bin && mysql -u %s --password=%s  %s < %s', $username, $password, $database, $b);
        

        $massa1 = shell_exec($command);
        //TILL HERE
    // massa1
    return response()->json($massa1, 201);

    }
}
