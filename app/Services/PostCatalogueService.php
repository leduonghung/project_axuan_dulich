<?php

namespace App\Services;

use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use DB,Log;

class PostCatalogueService implements PostCatalogueServiceInterface
{
    protected $PostCatalogueRepository;

    public function __construct(PostCatalogueRepository $PostCatalogueRepository) {
        $this->PostCatalogueRepository = $PostCatalogueRepository;
    }

    public function paginate($request) {
        $condition['keyword'] =addslashes($request->keyword);
        $perPages = $request->perPages ;
        return $this->PostCatalogueRepository->pagination($this->paginateSelect(),$condition,[],['path'=>'language'],$perPages);
    }

    private function paginateSelect() {
        return ['id', 'name', 'image','status'];
    }

    public function create($request){
        DB::beginTransaction();
        try {
            $payload =$request->except(['_token']);
            $payload['status'] = (array_key_exists('status',$payload) && $payload['status']=='on') ? true : false;
            $payload['user_id'] = \Auth::id();
            // dd($payload);
            
            $language = $this->PostCatalogueRepository->create($payload);
            DB::commit();
            return $language;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }

    public function update($id, $request){
        DB::beginTransaction();
        try {
            $payload =$request->except(['_token']);
            $payload['status'] = (array_key_exists('status',$payload) && $payload['status']=='on') ? true : false;
            
            // dd($payload);
            $language = $this->PostCatalogueRepository->update($id, $payload);
            DB::commit();
            return $language;
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
            return $this->PostCatalogueRepository->find($id);
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
            $language = $this->PostCatalogueRepository->update($post['id'],$payload);
            
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
            $language = $this->PostCatalogueRepository->updateByWhereIn($post['id'],$payload);
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
