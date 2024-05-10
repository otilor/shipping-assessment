<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = ['user_id', 'status', 'amount', 'transaction_id'];

    protected $keyType = 'string';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
