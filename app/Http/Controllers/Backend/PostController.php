<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceService;
use App\Repositories\Interfaces\DistrictRepositoryInterface as DistrictResponse;
use Log,DB;

class PostController extends Controller
{
    protected $userService;
    protected $provinceService;
    public function __construct(
        UserService $userService,
        ProvinceService $provinceService,
        ) {
        $this->userService = $userService ;
        $this->provinceService = $provinceService ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(UserRepositoryInterface $user,Request $request)
    {
        try {
            $data = config('apps.user');
            // $data['users'] = $this->userService->getAll();
            if(!$request->perPages) $request->perPages = 15;
           $result = $this->userService->paginate($request);
           $data['users'] =  $result['users'];
           $data['SoftDeletes'] =  $result['SoftDeletes'];
            // dd($data);
            // dd($data['users']->withPath('/admin/settings_admins'));
            
            return view('backend.user.index', compact('data'));//->with(['code'=>'success','title'=>'asdada','content'=>'Thêm bản ghi thành công !']);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $data = config('apps.user');
            $data['action'] = route('admin.user.create');
            $data['provinces'] = $this->provinceService->getAll()->toArray();
            // $data['action'] = route('admin.user.update', ['id' => $data['user']->id]);
            return view('backend.post.create', compact('data'));
        } catch (\Exception $e) {
            throw $e;
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            if($this->userService->create($request)){
                return redirect()->route('admin.user')->with(['code'=>'success','title'=>'Thêm mới thành công','content'=>'Bản ghi đã được thêm thành công vào dữ liệu !']);
            }
            return redirect()->route('admin.user.create')->with('error','Thêm bản ghi không thành công !');
            // return redirect()->route('admin.proTags.index');

        } catch (\Exception $e) {
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id,DistrictResponse $districtResponse)
    {
        try {
            $data = config('apps.user');
            $data['user'] = $this->userService->find($id);
            $data['action'] = route('admin.user.update',['id'=>$data['user']->id]);
            // dd($id);
            // dd($data);
            $data['provinces'] = $this->provinceService->getAll()->toArray();
            if (isset($data['user']->province_id) && $data['user']->province_id) {
                $data['districts'] = $this->provinceService->findById($data['user']->province_id,['code','full_name'], ['districts:code,full_name,province_code'])->toArray();
            }
            if (isset($data['user']->district_id) && $data['user']->district_id) {
                $data['wards'] = $districtResponse->findById($data['user']->district_id,['code','full_name'], ['wards:code,full_name,district_code'])->toArray();
            }
            return view('backend.user.create', compact('data'));

        } catch (\Exception $e) {
            throw $e;
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            if($this->userService->update($id, $request)){
                return redirect()->route('admin.user')->with(['code'=>'success','title'=>'Chỉnh sửa thành công','content'=>'Bản ghi đã được Chỉnh sửa thành công vào dữ liệu !']);
                // ->with(['code'=>'info','color'=>'ff6849','time'=>'4500','title'=>'Chỉnh sửa thành công !','content'=>'Bản ghi đã được chỉnh sửa thành công !']);
            }
            return redirect()->route('admin.user.create')->with(['code'=>'error','title'=>'Chỉnh sửa không thành công','content'=>'Bản ghi đã được Chỉnh sửa không thành công vào dữ liệu !']);//->with('error','Chỉnh sửa bản ghi không thành công !');

        } catch (\Exception $e) {
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = $this->userService->delete($id);
            // dd($user);
            $data = [
                // 'rederect' => route('admin.user'),
                'title' => 'Xóa user thành công !',
                'name' => $user['name'],
                'message' => $user['message'],
            ];
            return response()->json($data, 200);

            // return redirect()->route('motorcycles.show', ['id' => $motorcycles->id]);
        } catch (Exception $e) {
            log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return response()->json([
                'code' => 500,
                'message' => false,
            ], 500);
            // echo $e->getMessage().' IN ' .$e->getLine();
        }
    }

    public function loadAjax(Request $request)
    {
        // dd($request->toArray());
        try {
            DB::beginTransaction();
            // $oneUnit = $this->unit->find($id);
            $data['field'] = $request->field;
            $data['id'] = $request->id;
            $user = $this->userService->find($request->id);
            
            // dd($user);
            if ($data['field'] == 'status') {
                $user->status = !$user->status;
                $user->userUpdated = \Auth::id();
                $user->save();

                $data['label'] = $user->isActive();
                $data['name'] = $user->name;
                $data[$request->field] = $user->status;
            }

            DB::commit();
            return response()->view('backend.user.loadAjax', compact('data'), 200)->header('Content-Type', 'html');

            // return view('admin.unit.loadAjax', compact('data'));
        } catch (Exception $e) {
            DB::rollBack();
            log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }
}
