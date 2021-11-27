<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Billing
 * @package App\Models
 * @version November 14, 2021, 11:32 am UTC
 *
 * @property \App\Models\User $createdBy
 * @property \App\Models\Estate $estate
 * @property string $name
 * @property string $description
 * @property number $amount
 * @property string $bill_frequency
 * @property string $bill_target
 * @property string $invoice_day
 * @property string $invoice_month
 * @property string $due_day
 * @property string $due_month
 * @property string $status
 * @property integer $estate_id
 * @property integer $created_by
 */
class Billing extends Model
{
    use SoftDeletes;


    public $table = 'billings';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'amount',
        'bill_frequency',
        'bill_target',
        'invoice_day',
        'invoice_month',
        'due_day',
        'due_month',
        'status',
        'estate_id',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'amount' => 'decimal:2',
        'bill_frequency' => 'string',
        'bill_target' => 'string',
        'invoice_day' => 'integer',
        'invoice_month' => 'integer',
        'due_day' => 'integer',
        'due_month' => 'integer',
        'status' => 'string',
        'estate_id' => 'integer',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100',
        'description' => 'required|string|max:255',
        'amount' => 'required|numeric',
        'bill_frequency' => 'required|string|max:50|in:yearly,monthly,daily,one-off',
        'bill_target' => 'required|string|max:50|in:current,new,both',
        'invoice_day' => 'required|integer',
        'invoice_month' => 'nullable|integer',
        'due_day' => 'required|integer',
        'due_month' => 'nullable|integer',
        'status' => 'required|string|max:10',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estate()
    {
        return $this->belongsTo(\App\Models\Estate::class, 'estate_id');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
