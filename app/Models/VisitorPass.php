<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class VisitorPass
 * @package App\Models
 * @version November 7, 2021, 9:50 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\VisitorPassCategory $visitorPassCategory
 * @property integer $visitor_pass_category_id
 * @property string $generatedCode
 * @property string $guestName
 * @property string $gender
 * @property string $pass_status
 * @property integer $user_id
 * @property string|\Carbon\Carbon $visitationDate
 * @property string|\Carbon\Carbon $generatedDate
 * @property string $dateExpires
 * @property boolean $isRecurrent
 */
class VisitorPass extends Model
{
    use SoftDeletes;


    public $table = 'visitor_passes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'visitor_pass_category_id',
        'generatedCode',
        'guestName',
        'gender',
        'pass_status',
        'user_id',
        'visitationDate',
        'generatedDate',
        'dateExpires',
        'isRecurrent'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'visitor_pass_category_id' => 'integer',
        'generatedCode' => 'string',
        'guestName' => 'string',
        'gender' => 'string',
        'pass_status' => 'string',
        'user_id' => 'integer',
        'visitationDate' => 'datetime',
        'generatedDate' => 'datetime',
        'dateExpires' => 'date',
        'isRecurrent' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'visitor_pass_category_id' => 'required',
        'guestName' => 'required|string|max:255',
        'gender' => 'required|string|max:255',
        'pass_status' => 'required|string|max:255',
        'user_id' => 'required',
        'visitationDate' => 'required',
        'dateExpires' => 'required',
        'isRecurrent' => 'required|boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function visitorPassCategory()
    {
        return $this->belongsTo(\App\Models\VisitorPassCategory::class, 'visitor_pass_category_id');
    }
}
