<?php

namespace App\Http\Controllers\Backend;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $template= 'backend.dashboard.index';
        // dd(App::getLocale());
        return view('backend.dashboard.index',compact(
            'template'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function changeStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $serviceInterfaceNamespace = '\App\Services\\'. ucfirst($request->model). 'Service';
            if(class_exists($serviceInterfaceNamespace)){
                $serviceInstance = app($serviceInterfaceNamespace);
            }
            $data['field'] = 'publish';
            $data['id'] = $request->id;
            // dd($request->model);
            $result = $serviceInstance->updateStatus($request->toArray());
            $data['label'] = $result->isActive();
            $data['name'] = $result->name;
            $data['model'] = $request->model;
            $data[$request->field] = $result->publish;
            // dd($data);

            DB::commit();
            return response()->view('backend.dashboard.loadAjax', compact('data'), 200)->header('Content-Type', 'html');

            // return view('admin.unit.loadAjax', compact('data'));
        } catch (Exception $e) {
            DB::rollBack();
            log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }
    public function changeStatusAll(Request $request)
    {
        try {
            DB::beginTransaction();
            $serviceInterfaceNamespace = '\App\Services\\'. ucfirst($request->model). 'Service';
            if(class_exists($serviceInterfaceNamespace)){
                $serviceInstance = app($serviceInterfaceNamespace);
            }
            $data = [];
            if(empty($request->id)){
                $code = 403;
                $data['message'] = 'Không có bản ghi nào được chọn !';
            }else{
                $code = 200;
                $result = $serviceInstance->updateStatusAll($request->toArray());
                foreach ($result as $record) {
                    $data[$record->id] = [
                        // 'id'=> $record->id,
                        'name'=> $record->name ?? null,
                        'publish' => $record->publish,
                        'field' => 'publish',
                        'label'=> $record->isActive(),
                    ];
                }
            }
            // dd($data);

            DB::commit();
            return response()->json(compact('data'), $code);
            // return response()->view('backend.dashboard.changeStatusAll', compact('data'), 200)->header('Content-Type', 'html');

            // return view('admin.unit.loadAjax', compact('data'));
        } catch (Exception $e) {
            DB::rollBack();
            log::error('Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
            return abort(403, 'Message : ' . $e->getMessage() . 'Line  : ' . $e->getLine());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
