<?php

namespace App\Services;

use DB;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\UserServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;

/**
 * Class UserService
 * @package App\Services
 */
class UserService implements UserServiceInterface 
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function paginate($request) {
        $condition['keyword'] =addslashes($request->keyword);
        $perPages = $request->perPages ;
        return $this->userRepository->pagination($this->paginateSelect(),$condition,$perPages,['path'=>'user']);
    }
    public function getAll() {
        return $this->userRepository->getAll();
    }
    private function paginateSelect() {
        return ['id', 'name', 'email', 'phone', 'address', 'publish','deleted_at'];
    }

    public function create($request){
        DB::beginTransaction();
        try {
            $payload =$request->except(['_token','send','re_password']);
            
            $password = Hash::make($payload['password']);
            $payload['password'] = $password;
            
            $user = $this->userRepository->create($payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }

    public function update($id, $request){
        DB::beginTransaction();
        try {
            // $user = $this->userRepository->findById($id);
            $payload = $request->except(['_token','send']);
            
            // $password = Hash::make($payload['password']);
            // $payload['password'] = $password;
            // dd($payload);
            $user = $this->userRepository->update($id, $payload);
            DB::commit();
            return true;
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
            return $this->userRepository->find($id);
        }  catch (\Exception $e) {
            echo $e->getMessage();
            die;
            return false;
        }

    }

    public function updateStatus($post = []){
        DB::beginTransaction();
        try {
            $payload['userUpdated'] = \Auth::id();
            $payload[$post['field']] = ($post['value'] == 1 )? 0 : 1;
            $user = $this->userRepository->update($post['id'],$payload);
            
            // dd($user);
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollback();
            echo $e->getMessage();
            return false;
        }
    }
    public function updateStatusAll($post = []){
        DB::beginTransaction();
        try {
            // $field = ['publish','userUpdated'];
            $payload['userUpdated'] = \Auth::id();
            $payload['publish'] = (int) $post['value'];
            // if ((int) $post['value'] === 1) {
            // } else {
            //     $payload['publish'] = 1;
            // }
            $user = $this->userRepository->updateByWhereIn($post['id'],$payload);
            // dd($user);
            
            // dd($user);
            DB::commit();
            return $user;
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
                    'message' => 'Bạn xóa thành công user: '.$result->name
                ];
                $result->delete();
    
            }
            DB::commit();
            return $data;

            // return redirect()->route('motorcycles.show', ['id' => $motorcycles->id]);
        } catch (Exception $e) {
            DB::rollBack();
            log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Không có User nào',
            ], 500);
            // echo $e->getMessage().' IN ' .$e->getLine();
        }
       

        return false;
    }
}
