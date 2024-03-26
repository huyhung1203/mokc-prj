<?php

namespace App\Http\Controllers;

use App\Exports\CheckInExport;
use App\Models\CheckIn;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InOutController extends Controller
{
    public function index(Request $request){
        try{
            $data = $request->all();
            $list = CheckIn::with('members')->filter($data)->paginate(config('custom.pagination'));
            $request->session()->put('data', $data);
            $list -> appends($request->query());
            return view('pages.inout.list',compact('list'));
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
