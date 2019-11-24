<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TesterController extends Controller
{
    public function index(Request $request)
    {

        $date_request=date('Y-m-d H:i:s');
        $host_request = $request->server('REMOTE_ADDR');
        $request_info=array(
            'date' => $date_request,
            'host' => $host_request
        );
        $validator = \Validator::make($request->all(), [
            'item' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 300,
                'message' => $validator->errors(),
                'request_info'=> $request_info
            ]);
        }
        
        try {
            
        } catch (\Exception $th) {
            return response()->json([
                'status'=>300,
                'message'=>$th->getMessage(),
                'request_info' => $request_info
            ]);
        }

        
    }
}
