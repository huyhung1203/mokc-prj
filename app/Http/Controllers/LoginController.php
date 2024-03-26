<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin(){
        if(Auth::check()){
            if(Auth::user()->hasRole('admin')){
                return redirect()->route('home');
            }else{
                return redirect()->route('checkin.index');
            }
        
        }
        else{
            return view('includes.login');
        }
    }
    public function login(Request $request)
    {
        try{
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $request->input('remember'))) {
                if(Auth::user()->force_password_change == config('custom.force_password_false') && Auth::user()->hasRole(config('custom.roleAmdin'))){
                    return redirect()->route('password');
                }else if(Auth::user()->force_password_change == config('custom.force_password_true') && Auth::user()->hasRole(config('custom.roleAmdin'))){
                   
                    return redirect()->route('home')->with('success','Chào Mừng Quay Trở Lại');
                }else{
                    
                    return redirect()->route('checkin.index')->with('success','Chào Mừng Quay Trở Lại');
                }
            }
            else{
                return redirect()->back()->with('error','Email hoặc mật khẩu không đúng');
            }
        }catch(\Exception $e){
            return redirect()->route('index')->with('error',$e->getMessage());
        }

       
    }

    public function logout(Request $request)
    {
        try{
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('index')->with('success', 'You have been logged out successfully.');
        }catch(\Exception $e){
            return redirect()->route('home')->with('error', $e->getMessage());
        }
    }

    public function showViewchangePassword(){
        return view('includes.change-password');
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        try{
            $request->all();
            $user =Auth::user();
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->with('error', 'Mật Khẩu Không Đúng.');
            }
            $user->password = Hash::make($request->new_password);
            $user->force_password_change = config('custom.force_password_true');
            $user->save();
    
            return redirect()->route('index')->with('success', 'Chào Mừng Quay Trở Lại.');
        }catch (\Exception $e){
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }

       
    }
}
