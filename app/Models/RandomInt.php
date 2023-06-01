<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RandomInt extends Model
{
    use HasFactory;

    protected $table = "random_int";

    protected $fillable = [
      "number"
    ];
}
