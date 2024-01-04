<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

   protected $fillable = ['reference', 'user_id', 'type', 'biller_name', 'amount', 'package_data', 'recurrence', 'country', 'customer', 'customer_type', 'status', 'is_reversal', 'errors'];

   public function user(): BelongsTo
   {
       return $this->belongsTo(User::class);
   }

}
