<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Transaction
 * @package App\Models
 * @version November 14, 2021, 2:28 pm UTC
 *
 * @property \App\Models\Estate $estate
 * @property \App\Models\User $user
 * @property integer $user_id
 * @property integer $estate_id
 * @property string $description
 * @property number $amount
 * @property string $transaction_type
 * @property string $transaction_status
 * @property string $transaction_reference
 * @property string|\Carbon\Carbon $date_initiated
 */
class Transaction extends Model
{
    use SoftDeletes;


    public $table = 'transactions';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'estate_id',
        'description',
        'amount',
        'transaction_type',
        'transaction_status',
        'transaction_reference',
        'date_initiated'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'estate_id' => 'integer',
        'description' => 'string',
        'amount' => 'decimal:2',
        'transaction_type' => 'string',
        'transaction_status' => 'string',
        'transaction_reference' => 'string',
        'date_initiated' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required',
        'estate_id' => 'required',
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'transaction_type' => 'required|string',
        'transaction_status' => 'required|string|max:30',
        'transaction_reference' => 'required|string|max:100',
        'date_initiated' => 'required',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estate()
    {
        return $this->belongsTo(\App\Models\Estate::class, 'estate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
