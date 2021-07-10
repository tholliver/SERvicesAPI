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

        //get the filename
        
        $filename = $request->nom;
        
        $fileUnzipedPath = "app\Laravel";
        $files = storage_path("app\Laravel\\".$filename);
        /*
         $files = storage_path("app\\Laravel\\".''.$file);
       
       */
        
        $stup = \Zipper::make($files)->extractTo('restoration');
        $b = public_path('restoration\8vC9ZQ2AJT.sql');

        //$fiels = shell_exec('cd .. && cd storage && cd app && cd Laravel && ls -a');
        //$backing = shell_exec("cd C:\xampp\mysql\bin && mysql -u ".\Config::get('database.mysql.user')." -p".\Config::get('database.mysql.password')." ".\Config::get('database.mysql.database')." < ".$b);
        //$var = shell_exec('cd C:\xampp\mysql\bin && ls -a');

        $host = env('DB_HOST');
        $username = env('DB_USERNAME');
        //$password = env('DB_PASSWORD');
        $password = env('DB_PASSWORD');
        $database = env('DB_DATABASE');

        
        //$ts = time();

        //mysql -u root --password=  testapp < C:\\xampp\htdocs\\API-SERvices\public\\restoration\8vC9ZQ2AJT.sql
        //$file = date('Y-m-d-His', $ts) . '-dump-' . $database . '.sql';
        $command = sprintf('cd c:\xampp\mysql\bin && mysql -u %s --password=%s  %s < %s', $username, $password, $database, $b);
        

        $massa1 = shell_exec($command);
        //TILL HERE
 
   /*   

        //TESTING RESTORATION 
        //check if the file exits 
 //  if (Storage::disk($this->disk)->exists($this->backupPath . $file)) {


            $storageLocal = Storage::createLocalDriver(['root' => base_path()]);
            $contents = Storage::disk($this->disk)->get($this->backupPath . $file);

            $storageLocal->put($file, $contents);

           

                $connection = [
                    'host' => config('database.connections.mysql.host'),
                    'database' => config('database.connections.mysql.database'),
                    'username' => config('database.connections.mysql.username'),
                    'password' => config('database.connections.mysql.password'),
                ];

                $connectionOptions = "-u {$connection['username']} ";

                if (trim($connection['password'])) {
                    $connectionOptions .= " -p\"{$connection['password']}\" ";
                }

                $connectionOptions .= " -h {$connection['host']} {$connection['database']} ";

                //$command = "$cd gunzip < $this->fBackupName | mysql $connectionOptions";
                $commands = 'cd ' . str_replace('\\', '/',
                        base_path()) . " && $this->zcat $file | mysql $connectionOptions";
                //exit($command);

               $bytes = shell_exec($commands . ' 2>&1');

                // delete local file
                //$storageLocal->delete($file);
        

                */

  //  }
        //$massa1
    return response()->json($massa1, 201);

    }
}
