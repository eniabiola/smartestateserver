<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class WalletHistory
 * @package App\Models
 * @version November 14, 2021, 2:41 pm UTC
 *
 * @property number $prev_balance
 * @property number $amount
 * @property number $current_balance
 * @property string $transaction_type
 * @property string $description
 */
class WalletHistory extends Model
{
    use SoftDeletes;


    public $table = 'wallet_histories';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'prev_balance',
        'amount',
        'current_balance',
        'transaction_type',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'prev_balance' => 'decimal:2',
        'amount' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'transaction_type' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'prev_balance' => 'required|numeric',
        'amount' => 'required|numeric',
        'current_balance' => 'required|numeric',
        'transaction_type' => 'required|string',
        'description' => 'required|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    
}
