<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class FileController
 * @package App\Http\Controllers
 */
class FileController extends Controller
{
    protected $basePath = '';

    public function __construct()
    {
        $this->basePath = storage_path('logs/');
    }

    /**
     * @return welcome.blade view of application.
     */
    public function index(){
        return view('welcome');
    }

    /**
     * Convert the file to string array and returns the set of 10 lines WRT pageNumber
     *
     * View any file in Applications_Roots/storage/logs directory.
     *
     * @param Request $request Inputs Required are :-
     * File Location : String, start Flag : String, End Flag : String, pageNumber : Integer
     * @return array|string
     */
    public function viewFile(Request $request){

        $fileLocation = $request->input('location');
        $fileLocation = ltrim($fileLocation, '/'); //remove forward Slash from start of string
        $start = $request->input('start');
        $end = $request->input('end');
        $pageNumber = ( $request->input('pageNumber') < 0 )? 0 : $request->input('pageNumber');

        try{

            // read File and convert to string array
            $lines = file($this->basePath.$fileLocation);
            $totalLines = count($lines);

            //region Pagination
            if($start === 'true'){

                $pageNumber = 0;
            }

            if($end === 'true'){
                if($totalLines > 10){
                    $pageNumber = ($totalLines - ($totalLines % 10))/10;
                }else{
                    $pageNumber = 0;
                }
            }


            $start = false;
            $end = false;
            //endregion

            $result = array_slice($lines,$pageNumber*10,10,false);

            return json_encode([
                'status' => 'success',
                'logs' => $result,
                'start' => $start,
                'end' => $end,
                'pageNumber' => $pageNumber
            ]);
        }catch (\Exception $exception){
            return json_encode([
                'status' => 'error',
                'exception' => 'File not found on location.'
            ]);
        }
    }
}
