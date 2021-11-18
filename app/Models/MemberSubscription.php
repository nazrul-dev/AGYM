<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSubscription extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected  $dates =  ['expired_at'];


    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
