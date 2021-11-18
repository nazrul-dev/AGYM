<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionRenew extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $with = ['transaction'];
    public $dates = ['renew_start', 'renew_end'];


    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
