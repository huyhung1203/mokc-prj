<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
class Member extends Model
{
    use HasFactory,Filterable;
    protected $table = 'members';
    protected $fillable = [
        'code',
        'full_name',
        'email',
        'phone_number',
        'address',
        'dob',
        'gender',
        'is_gues',
        'ended_date',
    ];
    public function checkins(){
        return $this->hasMany(CheckIn::class, 'member_id', 'id');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function($member){
           if($member->is_gues){
               $member->code = null;
               $member->ended_date = now()->addDay();
           }else{
               $member->code = static::generateUniqueCode(); 
               if (is_null($member->ended_date)) {
                $member->created_at = now();
                $member->ended_date = $member->created_at->copy()->addYear();
                }
           }
        });
    }
    protected static function generateUniqueCode()
    {
        $lastCode = Member::max('code');
    
        if ($lastCode) {
            $lastCodeNumber = (int) substr($lastCode, 1);
            $newCodeNumber = $lastCodeNumber + 1;
        } else {
            // If no member exists yet, start from 1
            $newCodeNumber = 1;
        }
    
        $code = 'M' . str_pad($newCodeNumber, 5, '0', STR_PAD_LEFT);
    
        // Check if the generated code already exists
        while (Member::where('code', $code)->exists()) {
            $newCodeNumber++;
            $code = 'M' . str_pad($newCodeNumber, 5, '0', STR_PAD_LEFT);
        }
    
        return $code;
    }
    
}
