<?php

namespace App\Http\Controllers;

use App\Models\Member;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use PDF;
class PDFController extends Controller
{
    public function PDF(String $id){
        $member = Member::findOrFail($id);
        
        $name = $member->full_name;
        $code = $member->code;
        $email = $member->email;
        $phone = $member->phone_number;

        $data = utf8_encode("code: $code,name: $name, email: $email, phone: $phone");
        $qr_code = QrCode::size(110)->generate($data);
        $qrCode = substr($qr_code, strpos($qr_code, '<svg'));
        $pdf = PDF::loadView('pages.member.code', compact('member', 'qrCode'));
        return $pdf->stream('member.pdf');

    }
}
