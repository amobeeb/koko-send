<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

   protected $fillable = ['reference', 'user_id', 'type', 'biller_name', 'amount', 'package_data', 'recurrence', 'country', 'customer', 'customer_type', 'status', 'is_reversal', 'errors'];
}
