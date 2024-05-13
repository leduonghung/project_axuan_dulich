<?php

namespace App\Services;

use Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Services\Interfaces\PostServiceInterface;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;

class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;
    protected $language;

    public function __construct(
        PostRepository $postRepository,
        ){
        $this->postRepository = $postRepository;
        $this->language = $this->currentLanguage();
    }

    public function paginate($request) {

        $columns = $this->paginateSelect(); 
        $condition['keyword'] = $request->keyword ? addslashes($request->keyword): null;
        if ($request->has('publish') && !is_null($request->publish)) {
            $condition['publish'] =  $request->integer('publish');
        } else {
            unset($condition['publish']);
        }
        
        $condition['where'] = [
            ['tb2.language_id','=',$this->language]
        ];
        $perPages = $request->integer('perPages');
        $extend =['path'=>'post.index'];
        $orderBy =[
            ['posts.id', 'DESC'],
            ['posts.created_at','DESC']
        ];
        $join = [
            ['post_language as tb2','tb2.post_id','=','posts.id'],
            // ['post_catalogues as tb3','tb3.id','=','posts.post_catalogue_id']
        ]; 
        $relations =[];
        $rawQuery = $this->rawQuery($request);

        return $this->postRepository->pagination(
            $columns,
            $condition,
            $perPages,
            $extend,
            $orderBy,
            $join,
            $relations,
            $rawQuery,
        );
    }

    private function rawQuery($request){
        $rawCondition =[];
        if($request->integer('post_catalogue_id') > 0){
            $rawCondition['whereRaw'] = [
                [
                    'post_catalogue_id IN(
                        SELECT id
                        FROM post_catalogues
                        WHERE lft >= (SELECT lft FROM post_catalogues as pc WHERE pc.id = ?)
                        AND rgt <= (SELECT rgt FROM post_catalogues as pc WHERE pc.id = ?)
                    )',
                    [$request->integer('post_catalogue_id'),$request->integer('post_catalogue_id')]
                ]
            ];
        }
        // dd($rawCondition);
        return $rawCondition;
    }

    private function paginateSelect() {
        return [
            'posts.id',
            'tb2.name',
            'tb2.canonical',
            'posts.post_catalogue_id',
            'tb2.canonical',
            'posts.image',
            'posts.album',
            'posts.order',
            'posts.publish',
            'posts.created_at'
        ];
    }

    private function payload() {
        return [
            'post_catalogue_id',
            'image',
            'album',
            'follow',
            'publish',
            'order',
        ];
    }
    private function payloadLanguage() {
        return [
            'name',
            'description',
            'content',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'canonical'
        ];
    }

    public function create($request){
        DB::beginTransaction();
        try {
            
            $post = $this->createPost($request);
            if($post->id>0){
                $postLanguage = $this->createLanguageForPost($post,$request);
                // dd($postLanguage);
                
            }
            DB::commit();
            return $post;
        } catch (QueryException $e) {
            DB::rollback();
            echo $e->getMessage().' IN ' .$e->getLine();
            dd($e);
            return false;
        }
    }
    private function router($canonical,$post_id){
        return $this->formatRouterPayload($post_id,$canonical, 'PostController');
    }
    private function fieldPayload($request){
        $payload = $request->only($this->payload());
        $payload['follow'] = (array_key_exists('follow',$payload) && $payload['follow']=='on') ? 1 : 0 ;
        $payload['publish'] = (int) $payload['publish'];
        $payload['image'] = $payload['image'] !='' ? asset($payload['image']): null;
        $payload['album'] = !empty($payload['album']) ? json_encode($payload['album']) : '';
        return $payload;
    }
    
    private function createPost($request){
        $payload =  $this->fieldPayload($request);
        $payload['userCreated'] = Auth::id();
        return $this->postRepository->create($payload);
    }

    private function fieldPayloadLanguage($post_id,$request){
        $payloadLanguage = $request->only($this->payloadLanguage());
        $payloadLanguage['post_id'] = $post_id;
        $payloadLanguage['language_id'] = $this->language;
        $payloadLanguage['name'] = ucfirst($payloadLanguage['name']);
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
        return $payloadLanguage;
    }

    private function createLanguageForPost($post,$request){
        
        $payloadLanguage = $this->fieldPayloadLanguage($post->id,$request);
        $payloadLanguage['userCreated'] = Auth::id();
        // dd($payloadLanguage);
                
         $this->postRepository->createPivot($post,$payloadLanguage,'languages');
        $router = $this->router($payloadLanguage['canonical'],$post->id);
        $router['userCreated'] = Auth::id();
                // dd($router);
        return $post->routes()->updateOrCreate($router);
    }

    public function update($id, $request){
        DB::beginTransaction();
        try {
            if($post = $this->updatePost($id, $request)){
                $this->updateLanguageForPost($post, $request);
            }
            DB::commit();
            return $post;
        } catch (\Illuminate\Database\QueryException $e){
            DB::rollback();
            echo $e->getMessage().' IN ' .$e->getLine();
            dd($e);
        }
    }

    private function updatePost($id, $request){
        $payload =  $this->fieldPayload($request);
        $payload['userUpdated'] = Auth::id();
        return $this->postRepository->update($id, $payload);
    }

    private function updateLanguageForPost($post, $request){
        $payloadLanguage = $this->fieldPayloadLanguage($post->id,$request);
        $payloadLanguage['userUpdated'] = Auth::id();
        $post->languages()->updateExistingPivot($this->language, $payloadLanguage, false);
        $router = $this->router($payloadLanguage['canonical'],$post->id);
        $router['userCreated'] = Auth::id();
        return $post->routes()->update($router);
    }

    public function find($id)
    {
        try {
            return $this->postRepository->find($id);
        }  catch (\Exception $e) {
            echo $e->getMessage().' IN ' .$e->getLine();
            dd($e);
            return false;
        }

    }

    public function updateStatus($post = []){
        DB::beginTransaction();
        try {
            // dd($post);
            $payload['userUpdated'] = \Auth::id();
            $payload[$post['field']] = ! (int) $post['value'];
            $post = $this->postRepository->update($post['id'],$payload);
            
            DB::commit();
            return $post;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage().' IN ' .$e->getLine();
            return false;
        }
    }
    public function updateStatusAll($post = []){
        DB::beginTransaction();
        try {
            $payload['userUpdated'] = \Auth::id();
            $payload['publish'] = (int) $post['value'];
           
            $post = $this->postRepository->updateByWhereIn($post['id'],$payload);
            
            DB::commit();
            return $post;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage().' IN ' .$e->getLine();
            return false;
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $post = $this->postRepository->getPostById($id,$this->language);
            // dd($post->post_language);
            if ($post) {
                $data = [
                    'name' => $post->name,
                    'message' => 'Bạn xóa thành công bài viết: '.$post->name
                ];
                $post->post_language->detach();
                $post->delete();
                $post->routes()->detach();
    
            }
            DB::commit();
            return $data;

            // return redirect()->route('motorcycles.show', ['id' => $motorcycles->id]);
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            echo $e->getMessage();
            return response()->json([
                'code' => 500,
                'message' => 'Không có bài viết nào'.$e->getMessage().' IN ' .$e->getLine(),
            ], 500);
            // echo $e->getMessage().' IN ' .$e->getLine();
        }
       

        return false;
    }
}
