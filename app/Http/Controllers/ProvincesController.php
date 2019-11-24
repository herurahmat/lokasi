<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Provinces;

class ProvincesController extends Controller
{
    public function index(Request $request)
    {
        try {
            $time_call=date('Y-m-d H:i:s');
            $province_id = $request->input('province_id');
            $exclude_province = $request->input('exclude_province');

            $query = Provinces::where('id','!=','')->select('id as province_id','name as province_name');
            if(!empty($province_id))
            {
                $query->where('id',$province_id);
            }
            if(!empty($exclude_province))
            {
                $query->whereNotIn('id', explode(",",$exclude_province));
            }

            $data = $query->get();
            $count=$query->count();

            if (!empty($data)) {
                return response()->json([
                    'status' => 200,
                    'count'=>$count,
                    'message' => 'Data Found',
                    'data' => $data,
                    'state' => 'Get Data',
                    'date'=> $time_call
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'count'=>0,
                    'message' => 'Data empty',
                    'data' => array(),
                    'state' => 'Get Data',
                    'date' => $time_call
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'count' => 0,
                'message' => $th->getMessage(),
                'data' => array(),
                'state' => 'Init',
                'date' => $time_call
            ]);
        }
    }
}
