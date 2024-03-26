<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Http\Request;

;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MemberExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    protected $columns = [
        'code', 'name', 'expired_date','address','phone' ,'email' ,
    ];
    public function __construct(Request $request) {
        $this->request = $request;
    }
    public function headings(): array{
        return $this->columns;
    }
    public function collection()
    {
        return Member::filter($this->request->all())->where('is_gues',0)->get();
    }
    public function map($member) : array{
        return [
                $member->code,
                $member->full_name,
                date('m-d-Y',strtotime($member->ended_date)),
                $member->address,
                $member->phone_number,
                $member->email,              
        ];
    }
}
