<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('pages.checkin.checkin');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        try {
            DB::beginTransaction();
            $id = $request->id;
            //  checkin expired day
            $member = Member::findOrFail($id);
            $expried =  $member->ended_date;
            if($expried < date('Y-m-d')){
                return back()->with('warning', 'Người dùng đã hết hạn!');
            }

            $checkIdExit = CheckIn::where('member_id', $id)->orderBy('check_in_date', 'desc')->first();
            if ($checkIdExit != null) {
                $dayCheckIn = date('Y-m-d', strtotime($checkIdExit->check_in_date));
                $currentDay = date('Y-m-d');
                if (($dayCheckIn >= $currentDay)) {
                    return back()->with('warning', 'Người dùng đã checkin!');
                }
            }
            $data = CheckIn::create([
                'member_id' => $id,
                'check_in_date' => date('Y-m-d H:i:s'),
            ]);
            DB::commit();
            return back()->with('success', 'Checkin thành công');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Người dùng không tồn tại !');
        }
    }
    /**
     * store and checkin for guest.
     */
    public function storeGuest(Request $request)
    {
        try {
            DB::beginTransaction();
            $member = $request->all();
            $member = Member::create($member);
            $data = CheckIn::create([
                'member_id' => $member->id,
                'check_in_date' => date('Y-m-d H:i:s'),
            ]);
            DB::commit();
            return back()->with('success', 'Check in thành công!');
        } catch (ValidationException $validator) {
            // Kiểm tra xem ngoại lệ được ném ra không
            DB::rollBack();
            return back()->withErrors($validator->errors())->withInput();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
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
    public function getMemberByCode(Request $request)
    {
        try {
            $member = Member::where('code', $request->code)->first();
            if ($member) {
                return response()->json(['success' => true, 'member' => $member]);
            } else {
                return response()->json(['success' => false, 'error' => 'Không tìm thấy người dùng!']);
            }
        } catch (Exception $e) {
            return response()->with('error', $e->getMessage());
        }
    }
}
