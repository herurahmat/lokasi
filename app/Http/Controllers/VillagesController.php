<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Villages;

class VillagesController extends Controller
{
    public function index(Request $request)
    {
        try {
            $validatedData = $this->validate($request, [
                'district_id' => 'required',
            ]);

            if (!$validatedData) {
                return response()->json([
                    'status' => 300,
                    'data' => array(),
                    'message' => 'Validation Error. Require district_id'
                ]);
            }

            $province_id = $request->input('province_id');
            $regency_id = $request->input('regency_id');
            $district_id = $request->input('district_id');
            $village_id = $request->input('village_id');
            $exclude_province = $request->input('exclude_province');
            $exclude_regency = $request->input('exclude_regency');
            $exclude_district = $request->input('exclude_district');
            $exclude_village = $request->input('exclude_village');

            $query = Villages::where('villages.id', '!=', '')->select('villages.id as village_id', 'villages.name as village_name','districts.id as district_id', 'districts.name as district_name', 'regencies.id as regency_id', 'regencies.name as regency_name', 'provinces.id as province_id', 'provinces.name as province_name')
                ->leftJoin('districts','villages.district_id','districts.id')
                ->leftJoin('regencies', 'districts.regency_id', 'regencies.id')
                ->leftJoin('provinces', 'regencies.province_id', 'provinces.id');
            if (!empty($province_id)) {
                $query->where('regencies.province_id', $province_id);
            }

            if (!empty($regency_id)) {
                $query->where('regencies.id', $regency_id);
            }

            if (!empty($district_id)) {
                $query->where('districts.id', $district_id);
            }

            if (!empty($village_id)) {
                $query->where('villages.id', $village_id);
            }

            if (!empty($exclude_province)) {
                $query->whereNotIn('regencies.province_id', explode(",", $exclude_province));
            }

            if (!empty($exclude_regency)) {
                $query->whereNotIn('regencies.id', explode(",", $exclude_regency));
            }

            if (!empty($exclude_district)) {
                $query->whereNotIn('regencies.id', explode(",", $exclude_district));
            }

            if (!empty($exclude_village)) {
                $query->whereNotIn('villages.id', explode(",", $exclude_village));
            }

            $data = $query->get();
            $count = $query->count();

            if (!empty($data)) {
                return response()->json([
                    'status' => 200,
                    'count' => $count,
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
