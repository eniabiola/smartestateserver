<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Invoice
 * @package App\Models
 * @version November 14, 2021, 2:25 pm UTC
 *
 * @property \App\Models\Billing $billing
 * @property \App\Models\Estate $estate
 * @property \App\Models\User $user
 * @property integer $billing_id
 * @property integer $user_id
 * @property integer $estate_id
 * @property string $name
 * @property string $description
 * @property string $invoiceNo
 * @property number $amount
 * @property string $status
 */
class Invoice extends Model
{
    use SoftDeletes;


    public $table = 'invoices';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'billing_id',
        'user_id',
        'estate_id',
        'name',
        'description',
        'invoiceNo',
        'amount',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'billing_id' => 'integer',
        'user_id' => 'integer',
        'estate_id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'invoiceNo' => 'string',
        'amount' => 'decimal:2',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'billing_id' => 'required',
        'user_id' => 'required',
        'estate_id' => 'required',
        'name' => 'required|string|max:50',
        'description' => 'required|string|max:255',
        'invoiceNo' => 'required|string|max:20',
        'amount' => 'required|numeric',
        'status' => 'required|string|max:30',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function billing()
    {
        return $this->belongsTo(\App\Models\Billing::class, 'billing_id');
    }

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
