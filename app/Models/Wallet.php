<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model){
            $model->uuid = (string) Str::uuid();
        });
    }
}
