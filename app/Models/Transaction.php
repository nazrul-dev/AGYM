<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $dates = ['due_date'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function (Transaction $transaction) {
            $transaction->invoice = date('ymd') .'-'. self::quickRandom(5);
        });
    }

    public static function quickRandom($length = 16)
    {
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function getDecCustomersAttribute(){
        return json_decode($this->customers, true);
    }

    public function getDecOrdersAttribute(){
        if ($this->type == 'sale') {
            return json_decode($this->orders, true);
        }

    }
}
