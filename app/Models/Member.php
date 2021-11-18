<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use  HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $with = ['subscription', 'transaction'];

    public function subscription()
    {
        return $this->hasOne(MemberSubscription::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
