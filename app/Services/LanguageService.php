<?php

namespace App\Services;

use App\Services\Interfaces\LanguageServiceInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use DB,Log;

class LanguageService implements LanguageServiceInterface
{
    protected $languageRepository;

    public function __construct(LanguageRepository $languageRepository) {
        $this->languageRepository = $languageRepository;
    }

    public function paginate($request) {
        $condition['keyword'] = $request->keyword ? addslashes($request->keyword): null;
        if ($request->has('publish') && !is_null($request->publish)) {
            $condition['publish'] =  $request->integer('publish');
        } else {
            unset($condition['publish']);
        }
        $perPages = $request->integer('perPages');
        $orderBy =[
            ['id', 'DESC'],
            ['created_at','DESC']
        ];
        return $this->languageRepository->pagination(
            $this->paginateSelect(), 
            $condition, 
            $perPages, 
            ['path' => 'language.index'],
            $orderBy
        );
    }

    private function paginateSelect() {
        return ['id', 'name', 'image','publish'];
    }

    public function create($request){
        DB::beginTransaction();
        try {
            $payload =$request->except(['_token']);
            $payload['publish'] = (array_key_exists('publish',$payload) && $payload['publish']=='on') ? true : false;
            $payload['user_id'] = \Auth::id();
            // dd($payload);
            
            $language = $this->languageRepository->create($payload);
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
            $payload['publish'] = (array_key_exists('publish',$payload) && $payload['publish']=='on') ? true : false;
            
            $language = $this->languageRepository->update($id, $payload);
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
            return $this->languageRepository->find($id);
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
            $language = $this->languageRepository->update($post['id'],$payload);
            
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
            $payload['publish'] = (int) $post['value'];
            // if ((int) $post['value'] === 1) {
            // } else {
            //     $payload['publish'] = 1;
            // }
            $language = $this->languageRepository->updateByWhereIn($post['id'],$payload);
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

    public function switch($id){
        try {
            DB::beginTransaction();
            $this->languageRepository->updateLanguage($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage().' IN ' .$e->getLine();
            dd($e);
            return false;
        }
    }
}
