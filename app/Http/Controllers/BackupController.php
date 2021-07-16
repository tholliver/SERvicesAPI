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
       ini_set('max_execution_time', 3000);   //SET MORE TIME TO AVOID TIME EXE OUT
       //       
       //$backupRes = shell_exec('php artisan backup:list');
       //$fiels = shell_exec('cd .. &&  php artisan backup:run --only-db');

      //$fiels = shell_exec('cd .. && php artisan backup:run --only-db');
       
        //$stup = \Zipper::make($files)->extractTo('restoration');
        $fullDate = Carbon::now();
        $actualYear = $fullDate->year; 

        $currentTime = date('Y-m-d--H-i-s');

        $filename = "".$currentTime.".sql";
        
        $b = storage_path("app\Laravel\\".$filename);

        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        $command = sprintf('cd c:\xampp\mysql\bin && mysqldump -u %s --password=%s  %s > %s', $username, $password, $database, $b);
        $massa1 = shell_exec($command);
        if (file_exists($b)) {

            $files = glob(storage_path("app\Laravel\\".$filename));
            $ret = \Zipper::make(storage_path("app\Laravel\\".$currentTime.".zip"))->add($files)->close();

            $filenamess = "".$currentTime.".zip";        
            $zipConfirm = storage_path("app\Laravel\\".$filenamess);

            if(file_exists($zipConfirm)){
                File::delete($b);
                return response()->json(["Success"=>'New backup created'], 201);
            }
           
            return response()->json("Noting", 200);
        } else {
            return response()->json(["No found"=>'Verifique su conexcion o rutas'], 401);
        } 

       
        //TILL HERE
      
       return response()->json($b, 200);
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
        $removed = str_replace(".zip", "", $filename);
        $b = public_path('restoration\\'.$removed.'.sql');

        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        $command = sprintf('cd c:\xampp\mysql\bin && mysql -u %s --password=%s  %s < %s', $username, $password, $database, $b);
        

        $massa1 = shell_exec($command);

        if(!$massa1){
            File::delete($b);
            return response()->json(["Success"=>"Se ha restaurado"], 201);
        }
        
        //TILL HERE
    // massa1
    return response()->json("Error al leer archivo", 401);

    }
}
