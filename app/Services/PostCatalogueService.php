<?php

namespace App\Services;

use DB,Log;
use App\Classes\Nestedsetbie;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;

class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    protected $nestedset;

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
        ){
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->nestedset = new Nestedsetbie([
            'table' =>  'post_catalogues',
            'foreignkey' =>  'post_catalogue_id',
            'language_id' =>  $this->currentLanguage(),
        ]);
    }

    public function paginate($request) {
        $condition['keyword'] = $request->keyword ? addslashes($request->keyword): null;
        $perPages = $request->integer('perPages') ;
        $postCatalogues =  $this->postCatalogueRepository->pagination(
            $this->paginateSelect(),
            $condition,
            [
                ['post_catalogue_language as tb2','tb2.post_catalogue_id','=','post_catalogues.id']
            ],
            ['path'=>'language'],
            $perPages ,
            [],
            [
                ['post_catalogues.lft', 'ASC'],
                ['post_catalogues.created_at','DESC']
            ]
        );
        // dd($postCatalogues);
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
            'post_catalogues.order',
            'post_catalogues.level',
            'post_catalogues.publish',
            'post_catalogues.created_at'
        ];
    }

    private function payload() {
        return ['parent_id','follow','public','image','order'];
    }
    private function payloadLanguage() {
        return ['name','description','content','meta_title','meta_keyword','meta_description','canonical'];
    }

    public function create($request){
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $payload['follow'] = (array_key_exists('follow',$payload) && $payload['follow']=='on') ? true : false;
            $payload['order'] = ($payload['order']=== null ) ? false : true ;
            $payload['userCreated'] = Auth::id();
            $postCatalogue = $this->postCatalogueRepository->create($payload);
            
            if($postCatalogue->id>0){
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['post_catalogue_id'] = $postCatalogue->id;
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['name'] = ucfirst($payloadLanguage['name']);
                $payloadLanguage['userCreated'] = Auth::id();
                
                $this->postCatalogueRepository->createTranslatePivot($postCatalogue,$payloadLanguage);
            }
            $this->nestedset->Get('level ASC, order ASC');
            $this->nestedset->Recursive(0,$this->nestedset->Set());
            $this->nestedset->Action();
            // dd($this->nestedset);
            DB::commit();
            // dd($translate);
            return $postCatalogue;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }

    public function update($id, $request){
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            // $payload['name'] = ucfirst($payload['name']);
            $payload['follow'] = (array_key_exists('follow',$payload) && $payload['follow']=='on') ? true : false;
            $payload['order'] = ($payload['order']=== null ) ? false : true ;
            $payload['userUpdated'] = Auth::id();
            $postCatalogue = $this->postCatalogueRepository->update($id, $payload);
            // dd($postCatalogue);
            if($postCatalogue){
                // array_push($payloadLanguage, $request->only($this->payloadLanguage()));
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['post_catalogue_id'] = $postCatalogue->id;
                // $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['name'] = ucfirst($payloadLanguage['name']);
                $payloadLanguage['userCreated'] = Auth::id();
                // dd($postCatalogue->languages);
                // dd($payloadLanguage);

                // $postCatalogue->languages->where('language_id',$payloadLanguage['language_id'])->where('post_catalogue_id',$payloadLanguage['post_catalogue_id'])->update($payloadLanguage);
                // $postCatalogue->languages()->sync([$payloadLanguage['language_id'],$payloadLanguage['post_catalogue_id']],$payloadLanguage);
                $postCatalogue->languages()->sync($this->currentLanguage(),$payloadLanguage);
                $this->nestedset->Get('level ASC, order ASC');
                $this->nestedset->Recursive(0,$this->nestedset->Set());
                $this->nestedset->Action();
            }
// dd($postCatalogue->languages);
            
            DB::commit();
            return $postCatalogue;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            die;
            return false;
        }
    }

    public function find($id)
    {
        try {
            return $this->postCatalogueRepository->find($id);
        }  catch (\Exception $e) {
            echo $e->getMessage();
            die;
            return false;
        }

    }

    public function updateStatus($post = []){
        DB::beginTransaction();
        try {
            $payload['languageUpdated'] = \Auth::id();
            $payload[$post['field']] = ($post['value'] == 1 )? 0 : 1;
            $language = $this->postCatalogueRepository->update($post['id'],$payload);
            
            // dd($language);
            DB::commit();
            return $language;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }
    public function updateStatusAll($post = []){
        DB::beginTransaction();
        try {
            // $field = ['status','languageUpdated'];
            $payload['languageUpdated'] = \Auth::id();
            $payload['status'] = (int) $post['value'];
            // if ((int) $post['value'] === 1) {
            // } else {
            //     $payload['status'] = 1;
            // }
            $language = $this->postCatalogueRepository->updateByWhereIn($post['id'],$payload);
            // dd($language);
            
            // dd($language);
            DB::commit();
            return $language;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $result = $this->find($id);
            if ($result) {
                $data = [
                    'name' => $result->name,
                    'message' => 'Bạn xóa thành công language: '.$result->name
                ];
                $result->delete();
    
            }
            DB::commit();
            return $data;

            // return redirect()->route('motorcycles.show', ['id' => $motorcycles->id]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Không có language nào',
            ], 500);
            // echo $e->getMessage().' IN ' .$e->getLine();
        }
       

        return false;
    }
}
