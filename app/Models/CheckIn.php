<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory, Filterable;
    protected $table = 'check_ins';
    public $timestamps = false;
    protected $fillable = [
        'member_id',
        'check_in_date'
    ];
    public function members(){
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
