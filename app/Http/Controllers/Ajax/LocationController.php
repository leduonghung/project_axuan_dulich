<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;

class LocationController extends Controller
{
    protected $districtrepository;
    protected $provincerepository;
    public function __construct(ProvinceRepository $provincerepository, DistrictRepository $districtrepository) {
        $this->districtrepository = $districtrepository;
        $this->provincerepository = $provincerepository;
    }
    public function getLocation(Request $request){
        try {
            if($request->target == 'district' ){
            //    dd($request->data); die(23131);
                $result = $this->provincerepository->findById($request->data['id'],['code','full_name'], ['districts:code,full_name,province_code'])->toArray();
                $data = $result['districts'];
                // dd($result);
            }
            // dd($data);
            if($request->target == 'ward' ){
                $result = $this->districtrepository->findById($request->data['id'],['code','full_name'], ['wards:code,full_name,district_code'])->toArray();
                $data = $result['wards'];
            }
            
            if(!$data){
                abort(403, 'Không có dữ liệu. Hoặc dữ liệu đang cập nhật !' );
            }
            return response()->view('ajax.location.index', compact('data'),200)->header('Content-Type', 'html');
            
        } catch (\Exception $e) {
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }
    public function getWard(Request $request){
        try {
            $data = $this->districtrepository->findById($request->id,['code','name'], ['wards:code,name,district_code'])->toArray();
            // dd($data);
            if(!$data || !$data['wards']){
                abort(403, 'Không có dữ liệu Quận/Huyện của thành phố này' );
            }
            return response()->view('ajax.ward.index', ['data'=>$data['wards']])->setStatusCode(200)->header('Content-Type', 'html');
        } catch (\Exception $e) {
            //throw $th;
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }
}
