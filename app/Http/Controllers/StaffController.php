<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\UserNotFoundException;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        try{
            $search = $request->all();
            $staffList = User::filter($search)->paginate(config('custom.pagination'));
            $request->session()->put('search', $search);
            $staffList -> appends($request->query());
            return view('pages.staff.staff', compact('staffList'));
        }catch(Exception $e){
            return redirect()->route('staff.index')->with('error', $e->getMessage());
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
       try{
            return view('pages.staff.add_staff');
       }catch(\Exception $e){
            return redirect()->route('staff.index')->with('error', $e->getMessage());
       }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffRequest $request)
    {
        //
        try{
            $data = $request->all();
            $role = $data['level'];
            $user = User::create($data);
            if($role == config('custom.level')){
                $user->assignRole('admin');
            }else{
                $user->assignRole('staff');
            }
            return redirect()->route('staff.index')->with('success', 'Thêm Staff mới thành công!');
        }catch(Exception $e){
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }


   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       try{
            $staff = User::find($id);
            return view('pages.staff.edit_staff',compact('staff'));
       }catch(Exception $e){
            return redirect()->route('staff.index')->with('error', $e->getMessage());
       }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            
            $staff = User::findOrFail($id);
            $staff->update([
                'full_name' => $request->input('full_name'),
                'email' =>$request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'dob' => $request->input('dob'),
            ]);
            return redirect()->route('staff.index')->with('success', 'Chỉnh Sửa Thông Tin Staff thành công!');
        } catch(\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       try{
            if($id == 1){
                return redirect()->route('staff.index')->with('error', 'Không thể xóa admin!');
            }else{
                $staff = User::find($id);
                $staff->delete();
                return redirect()->route('staff.index')->with('success', 'Xóa Staff thành công!');
            }
       }catch(\Exception $e){
            return redirect()->route('staff.index')->with('error', $e->getMessage());
       }
    }
}
