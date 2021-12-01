<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Wallet
 * @package App\Models
 * @version November 30, 2021, 11:17 pm UTC
 *
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property number $prev_balance
 * @property number $amount
 * @property number $current_balance
 * @property string $transaction_type
 */
class Wallet extends Model
{
    use SoftDeletes;


    public $table = 'wallets';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'prev_balance',
        'amount',
        'current_balance',
        'transaction_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'prev_balance' => 'decimal:2',
        'amount' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'transaction_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'prev_balance' => 'required|numeric',
        'amount' => 'nullable|numeric',
        'current_balance' => 'required|numeric',
        'transaction_type' => 'required|string',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
