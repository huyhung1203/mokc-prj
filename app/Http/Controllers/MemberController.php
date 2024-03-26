<?php

namespace App\Http\Controllers;

use App\Exports\MemberExport;
use App\Http\Requests\StoreMemBerRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->all();
            $is_gues = 0;
            $members = Member::filter($search)->where('is_gues', $is_gues)->paginate(config('custom.paginationMember'));
            $request->session()->put('search', $search);
            $data = ['members' => $members-> appends($request->query())];
            return view('pages.member.member', $data);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pages.member.add_member');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemBerRequest $request)
    {
        //

        try {
            $validatedData = $request->all();
            $member = Member::create($validatedData);
            return redirect('/member')->with('success', 'Thêm thành công');
        } catch (ValidationException $validator) {
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
        try {
            $member = Member::findOrFail($id);
            $qrCodeData = utf8_encode("Họ tên: $member->full_name - Mã: $member->code");
            $qrCode = QrCode::size(150)->generate($qrCodeData);
            $data = [
                'member' => $member,
                'qrCode' => $qrCode
            ];
            return view('pages.member.member_detail', $data);
        } catch (ModelNotFoundException $e) {
            return back()->with('error', 'Không tìm thấy member có id: ' . $id . '!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
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
    public function update(UpdateMemberRequest $request, string $id)
    {
        //
        try {

            $member = Member::findOrFail($id);
            $data = $request->all();
            if(isset($data['renewal']) && !empty($data['renewal']) && $member->ended_date <= now()->toDateString()) {
                $renewalMonths = intval($data['renewal']);
                $endedDate = now()->addMonths($renewalMonths)->toDateString();
                $data['ended_date'] = $endedDate;
            }
            if(isset($data['renewal']) && !empty($data['renewal']) && $member->ended_date > now()->toDateString()) {
                $renewalMonths = intval($data['renewal']);
                $endedDate = Carbon::parse($member->ended_date)->addMonths($renewalMonths);
                $data['ended_date'] = $endedDate;
            }
            $member->update($data);
            return redirect('/member')->with('success', 'Cập nhật thành công');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return back()->with('error', 'Không tìm thấy member có id: ' . $id . '!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try{

            $member = Member::findOrFail($id);
            $member->delete();
            return redirect()->back()->with('success', 'Xóa thành công!');
        }catch(ModelNotFoundException $e){
            DB::rollBack();
            return back()->with('error', 'Không tìm thấy người dùng!');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error', 'Người dùng đã có checkin không thể xóa!');
        }
    }

    /**
     * Generate QR code.
     */
    public function getQRCode(Request $request)
    {
        $name = $request->input('name');
        $code = $request->input('code');

        // Tạo dữ liệu cho mã QR
        $qrCodeData = utf8_encode("Họ tên: $name - Mã: $code");
        // Tạo mã QR
        $qrCode = QrCode::size(150)->generate($qrCodeData);
        // Trả về mã QR dưới dạng HTML
        return $qrCode;
    }
    /**
     * export member
     */
    public function exportMember(Request $request)
    {
        return Excel::download(new MemberExport($request), 'member'.date('Y-m-d').'.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
