<?php

namespace App\Services;

use DB,Log;
use Illuminate\Support\Str;
use App\Classes\Nestedsetbie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;

class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    protected $routerRepository;
    protected $language;

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        RouterRepository $routerRepository
        ){
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->routerRepository = $routerRepository;
        $this->language = $this->currentLanguage();
        $this->nestedset = new Nestedsetbie([
            'table' =>  'post_catalogues',
            'foreignkey' =>  'post_catalogue_id',
            'language_id' =>  $this->language,
        ]);
    }

    public function paginate($request) {
        $condition['keyword'] = $request->keyword ? addslashes($request->keyword): null;
        $condition['publish'] = $request->integer('publish');
        $condition['where'] = [
            ['tb2.language_id','=',$this->language]
        ];

        $perPages = $request->integer('perPages') ;
        $postCatalogues =  $this->postCatalogueRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPages,
            ['path'=>'language'],
            [
                ['post_catalogues.lft', 'ASC'],
                ['post_catalogues.created_at','DESC']
            ],
            [
                ['post_catalogue_language as tb2','tb2.post_catalogue_id','=','post_catalogues.id']
            ],
        );
        return $postCatalogues;
    }

    private function paginateSelect() {
        return [
            'post_catalogues.id',
            'tb2.name',
            'tb2.canonical',
            'post_catalogues.parent_id',
            'tb2.canonical',
            'post_catalogues.lft',
            'post_catalogues.image',
            'post_catalogues.album',
            'post_catalogues.order',
            'post_catalogues.level',
            'post_catalogues.publish',
            'post_catalogues.created_at'
        ];
    }

    private function payload() {
        return ['parent_id','follow','public','image','order','album'];
    }
    private function payloadLanguage() {
        return ['name','description','content','meta_title','meta_keyword','meta_description','canonical'];
    }

    public function create($request){
        DB::beginTransaction();
        try {
            $payload = $this->createPayloadPostCataLogue($request);
            $payload['userCreated'] = Auth::id();
            $postCatalogue = $this->postCatalogueRepository->create($payload);
            
            if($postCatalogue->id>0){
                $payloadLanguage = $this->createPayloadLanguage($postCatalogue->id,$request);
                $payloadLanguage['userCreated'] = Auth::id();
                $postCatalogueLanguage = $this->postCatalogueRepository->createPivot($postCatalogue,$payloadLanguage,'languages');
                $router = $this->router(Str::slug($payloadLanguage['canonical']),$postCatalogue->id);
                $router['userCreated'] = Auth::id();
                // dd($postCatalogue->routes);
                $postCatalogue->routes()->updateOrCreate($router);
            }
            $this->nestedset();
            DB::commit();
            return $postCatalogue;
        } catch (QueryException $e) {
            DB::rollback();
            // echo $e->getMessage();
            print_r($e->errorInfo);die;
            dd($e);
            // echo $e->getMessage();
            return false;
        }
    }

   
    public function update($id, $request){
        DB::beginTransaction();
        try {
            $payload = $this->createPayloadPostCataLogue($request);
            $payload['userUpdated'] = Auth::id();
            $postCatalogue = $this->postCatalogueRepository->update($id, $payload);
            if($postCatalogue){
                $payloadLanguage = $this->createPayloadLanguage($postCatalogue->id,$request);
                $payloadLanguage['userUpdated'] = Auth::id();
                $postCatalogue->languages()->sync([$this->language=>$payloadLanguage]);
                $this->nestedset();
               
                $router = $this->router(Str::slug($payloadLanguage['canonical']),$postCatalogue->id);
                $router['userUpdated'] = Auth::id();
                $postCatalogue->routes()->update($router);

                // dd($postCatalogue);
            }
            
            DB::commit();
            return $postCatalogue;
        } catch (QueryException $e) {
            DB::rollback();
            \Session::flash('error', 'Unable to process request.Error:'.json_encode($e->getMessage(), true));
            echo $e->getMessage();
            dd($e);
            die;
            return false;
        }
    }
    private function router($canonical,$postCatalogue_id) {
        return $this->formatRouterPayload($postCatalogue_id,$canonical, 'PostCatalogueController');
    }
    private function createPayloadPostCataLogue($request) {
        $payload = $request->only($this->payload());
        $payload['follow'] = (array_key_exists('follow',$payload) && $payload['follow']=='on') ? true : false;
        $payload['order'] = ($payload['order']=== null ) ? false : true ;
        $payload['album'] = isset($payload['album']) ? json_encode($payload['album']): null;
        return $payload;
    }

    private function createPayloadLanguage($postCatalogue_id,$request) {
        $payloadLanguage = $request->only($this->payloadLanguage());
        $payloadLanguage['post_catalogue_id'] = $postCatalogue_id;
        $payloadLanguage['language_id'] = $this->language;
        $payloadLanguage['name'] = ucfirst($payloadLanguage['name']);
        $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
        return $payloadLanguage;
    }

    
    public function find($id)
    {
        try {
            return $this->postCatalogueRepository->find($id);
        }  catch (\QueryException $e) {
            echo $e->getMessage();
            die;
            return false;
        }

    }

    public function updateStatus($post = []){
        DB::beginTransaction();
        try {
            $payload['userUpdated'] = \Auth::id();
            $payload[$post['field']] = ! (int) $post['value'];
            $postCatalogue = $this->postCatalogueRepository->update($post['id'],$payload);
            DB::commit();
            return $postCatalogue;
        } catch (\QueryException $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }
    public function updateStatusAll($post = []){
        DB::beginTransaction();
        try {
            $payload['userUpdated'] = \Auth::id();
            $payload['publish'] = (int) $post['value'];
            $postCatalogue = $this->postCatalogueRepository->updateByWhereIn($post['id'],$payload);
            DB::commit();
            return $postCatalogue;
        } catch (\QueryException $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $postCatalogue = $this->postCatalogueRepository->getPostCatalogueById($id,$this->language);
            $this->nestedset->Get('level ASC, order ASC');
            $this->nestedset->Recursive(0,$this->nestedset->Set());
            $this->nestedset->Action();
            if ($postCatalogue) {
                $data = [
                    'name' => $postCatalogue->id,
                    'message' => 'Bạn xóa thành công danh mục: '.$postCatalogue->id
                ];
                $postCatalogue->delete();
                $postCatalogue->routes()->detach();
                $postCatalogue->post_language()->detach();
    
            }
            DB::commit();
            return $data;

            // return redirect()->route('motorcycles.show', ['id' => $motorcycles->id]);
        } catch (\QueryException $e) {
            DB::rollBack();
            echo $e->getMessage().' IN ' .$e->getLine();
            dd($e);
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Không có danh mục nào',
            ], 500);
        }
       

        return false;
    }
}
