<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostCatalogueRequest;
use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
class PostCatalogueController extends Controller
{
    protected $postCatalogueService;
    public function __construct(
        PostCatalogueService $postCatalogueService,
        ) {
        $this->postCatalogueService = $postCatalogueService ;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $data = config('apps.postCatalogue');
            $data['action'] = 'admin.post.catalogue';
            if(!$request->perPages) $request->perPages = 15;
           $result = $this->postCatalogueService->paginate($request);
           $data['postCatalogues'] =  $result['postCatalogues'];
           $data['softDeletes'] =  $result['softDeletes'];
// dd($data)            ;
            return view('backend.postCatalogue.index', compact('data'));//->with(['code'=>'success','title'=>'asdada','content'=>'Thêm bản ghi thành công !']);
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
            $data = config('apps.postCatalogue');
            $data['action'] = route('admin.post.catalogue.store');
            $data['postCatalogues']= [];
            // dd($data);
            return view('backend.postCatalogue.create', compact('data'));
        } catch (\Exception $e) {
            throw $e;
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCatalogueRequest $request)
    {
        try {
            if($this->postCatalogueService->create($request)){
                return redirect()->route('admin.post.catalogue')->with(['code'=>'success','title'=>'Thêm mới thành công','content'=>'Bản ghi đã được thêm thành công vào dữ liệu !']);
            }
            return redirect()->route('admin.post.catalogue.create')->with(['code'=>'error','title'=>'Thêm mới không thành công','content'=>'Bản ghi đã được thêm không thành công vào dữ liệu !']);
            // return redirect()->route('admin.proTags.index');
            // dd($this->postCatalogueService->create($request));
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
    public function edit($id)
    {
        try {
            $data = config('apps.postCatalogue');
            $data['postCatalogues'] = $this->postCatalogueService->find($id);
            $data['action'] = route('admin.post.catalogue.update',['id'=>$data['postCatalogues']->id]);
            // dd($id);
            // dd($data);
            return view('backend.postCatalogue.create', compact('data'));

        } catch (\Exception $e) {
            throw $e;
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCatalogueRequest $request, $id)
    {
        try {
            if($this->postCatalogueService->update($id, $request)){
                return redirect()->route('admin.post.catalogue')->with(['code'=>'success','title'=>'Chỉnh sửa thành công','content'=>'Bản ghi đã được Chỉnh sửa thành công vào dữ liệu !']);
                // ->with(['code'=>'info','color'=>'ff6849','time'=>'4500','title'=>'Chỉnh sửa thành công !','content'=>'Bản ghi đã được chỉnh sửa thành công !']);
            }
            return redirect()->route('admin.post.catalogue.create')->with(['code'=>'error','title'=>'Chỉnh sửa không thành công','content'=>'Bản ghi đã được Chỉnh sửa không thành công vào dữ liệu !']);//->with('error','Chỉnh sửa bản ghi không thành công !');

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
            $postCatalogues = $this->postCatalogueService->delete($id);
            // dd($postCatalogues);
            $data = [
                // 'rederect' => route('admin.post.catalogue'),
                'title' => 'Xóa postCatalogues thành công !',
                'name' => $postCatalogues['name'],
                'message' => $postCatalogues['message'],
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
            $postCatalogues = $this->postCatalogueService->find($request->id);
            
            // dd($postCatalogues);
            if ($data['field'] == 'status') {
                $postCatalogues->status = !$postCatalogues->status;
                $postCatalogues->postCataloguesUpdated = \Auth::id();
                $postCatalogues->save();

                $data['label'] = $postCatalogues->isActive();
                $data['name'] = $postCatalogues->name;
                $data[$request->field] = $postCatalogues->status;
            }

            DB::commit();
            return response()->view('backend.postCatalogue.loadAjax', compact('data'), 200)->header('Content-Type', 'html');

            // return view('admin.unit.loadAjax', compact('data'));
        } catch (Exception $e) {
            DB::rollBack();
            log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }
}
