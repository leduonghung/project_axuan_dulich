<?php

namespace App\Http\Controllers\Backend;

use Log,DB;
use Illuminate\Http\Request;
use App\Classes\Nestedsetbie;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;

class PostController extends Controller
{
    protected $postService;
    protected $postRepository;
    protected $language;
    public function __construct(
        PostRepository $postRepository,
        PostService $postService,
        ) {
        $this->postRepository = $postRepository;
        $this->postService = $postService;
        $this->language = $this->currentLanguage();;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $nestedset = new Nestedsetbie([
                'table' =>  'post_catalogues',
                'foreignkey' =>  'post_catalogue_id',
                'language_id' =>  1,
            ]);
            $data = __('messages.post');
            $data['dropdowns']= $nestedset->Dropdown();
            unset($data['dropdowns'][0]); 
// dd($data['dropdowns']);
            $data['action'] = 'admin.post';
            $data['posts'] = $this->postService->paginate($request);

        //    dd($data['posts']);
            return view('backend.post.index', compact('data'));//->with(['code'=>'success','title'=>'asdada','content'=>'Thêm bản ghi thành công !']);
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
            $nestedset = new Nestedsetbie([
                'table' =>  'post_catalogues',
                'foreignkey' =>  'post_catalogue_id',
                'language_id' =>  1,
            ]);
            $data = __('messages.post');
            $data['action'] = route('admin.post.store');
            $data['post']= [];
            $data['dropdowns']= $nestedset->Dropdown();
            
            // dd($data['dropdowns']);
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
    public function store(PostRequest $request)
    {
        try {
            if($this->postService->create($request)){
               
                return redirect()->route('admin.post')->with(['code'=>'success','title'=>'Thêm mới thành công','content'=>'Bản ghi đã được thêm thành công vào dữ liệu !','color'=>'000']);
            }
            return redirect()->route('admin.post.create')->with(['code'=>'error','title'=>'Thêm mới không thành công','content'=>'Bản ghi đã được thêm không thành công vào dữ liệu !']);
            // return redirect()->route('admin.proTags.index');
            // dd($this->postService->create($request));
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
            $nestedset = new Nestedsetbie([
                'table' =>  'post_catalogues',
                'foreignkey' =>  'post_catalogue_id',
                'language_id' =>  1,
            ]);
            $data = __('messages.post');
            $data['post'] = $this->postRepository->getPostById($id,$this->language);
            $data['action'] = route('admin.post.update',['id'=>$data['post']->id]);
            $data['dropdowns']= $nestedset->Dropdown();
            $data['album'] = json_decode($data['post']->album);
            
            //  dd($data['post']);
            return view('backend.post.create', compact('data'));

        } catch (\Exception $e) {
            throw $e;
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, PostRequest $request)
    {
        try {
            if($this->postService->update($id, $request)){
                return redirect()->route('admin.post')->with(['code'=>'success','title'=>'Chỉnh sửa thành công','content'=>'Bản ghi đã được Chỉnh sửa thành công vào dữ liệu !']);
                // ->with(['code'=>'info','color'=>'ff6849','time'=>'4500','title'=>'Chỉnh sửa thành công !','content'=>'Bản ghi đã được chỉnh sửa thành công !']);
            }
            return redirect()->route('admin.post.create')->with(['code'=>'error','title'=>'Chỉnh sửa không thành công','content'=>'Bản ghi đã được Chỉnh sửa không thành công vào dữ liệu !']);//->with('error','Chỉnh sửa bản ghi không thành công !');

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
            $posts = $this->postService->delete($id);
            $data = [
                'title' => 'Xóa posts thành công !',
                'name' => $posts['name'],
                'message' => $posts['message'],
            ];
            return response()->json($data, 200);
        } catch (\Exception $e) {
            // log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return response()->json([
                'code' => 500,
                'message' => false,
            ], 500);
            echo $e->getMessage().' IN ' .$e->getLine();
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
            $posts = $this->postService->find($request->id);
            
            // dd($posts);
            if ($data['field'] == 'status') {
                $posts->status = !$posts->status;
                $posts->postsUpdated = \Auth::id();
                $posts->save();

                $data['label'] = $posts->isActive();
                $data['name'] = $posts->name;
                $data[$request->field] = $posts->status;
            }

            DB::commit();
            return response()->view('backend.post.loadAjax', compact('data'), 200)->header('Content-Type', 'html');

            // return view('admin.unit.loadAjax', compact('data'));
        } catch (Exception $e) {
            DB::rollBack();
            log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }
}
