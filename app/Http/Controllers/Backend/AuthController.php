<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    public function __construct() {

    }
    public function index()
    {
        try {
            // dd(Auth::id());
            if(Auth::id()){
                return redirect()->route('admin.index');
            }
            return view('backend.auth.login');
        } catch (\Exception $th) {
            //throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(AuthRequest $request)
    {
        try {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];
            if (Auth::attempt($credentials)) {
                // $request->session()->regenerate();
                return redirect()->back()->with('success','Đăng nhập thành công  !');
                
                
                // return redirect()->route('admin.dashboard')->with('success','Đăng nhập thành công !');
                // return redirect()->intended('admin.dashboard');
            }
            return redirect()->route('auth.admin')->with('warnings',['heading'=>'Đăng nhập thất bại','text'=>'Email hoặc mật khẩu không chính xác !']);
            // dd($request->password);
            // return view('backend.auth.login');
        } catch (\Exception $th) {
            throw $th;
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.admin');
        } catch (\Exception $th) {
            throw $th;
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
