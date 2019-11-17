<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Regencies;

class RegenciesController extends Controller
{
    public function index(Request $request)
    {
        try {
            $province_id = $request->input('province_id');
            $regency_id = $request->input('regency_id');
            $exclude_province = $request->input('exclude_province');
            $exclude_regency = $request->input('exclude_regency');

            $query = Regencies::where('regencies.id','!=','')->select('regencies.id as regency_id','regencies.name as regency_name','provinces.id as province_id','provinces.name as province_name')
            ->leftJoin('provinces','regencies.province_id','provinces.id');
            if(!empty($province_id))
            {
                $query->where('regencies.province_id',$province_id);
            }

            if (!empty($regency_id)) {
                $query->where('regencies.id', $regency_id);
            }

            if(!empty($exclude_province))
            {
                $query->whereNotIn('regencies.province_id',explode(",",$exclude_province));
            }

            if (!empty($exclude_regency)) {
                $query->whereNotIn('regencies.id', explode(",", $exclude_regency));
            }

            $data = $query->get();
            $count = $query->count();

            if (!empty($data)) {
                return response()->json([
                    'status' => 200,
                    'count'=>$count,
                    'message' => 'Data Found',
                    'data' => $data,
                    'state' => 'Get Data'
                ]);
            } else {
                return response()->json([
                    'status' => 200,
                    'count' => 0,
                    'message' => 'Data empty',
                    'data' => array(),
                    'state' => 'Get Data'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'count' => 0,
                'message' => $th->getMessage(),
                'data' => array(),
                'state' => 'Init'
            ]);
        }
    }
}
