<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateAccount extends Model
{
    use HasFactory;

    protected $fillable = [
      "estate_id", "bank_code", "account_number", "account_name", "split_type", "split_value", "subaccount_id"
    ];


}
