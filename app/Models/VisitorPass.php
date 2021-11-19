<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class VisitorPass
 * @package App\Models
 * @version November 19, 2021, 4:40 pm UTC
 *
 * @property \App\Models\Estate $estate
 * @property \App\Models\User $user
 * @property \App\Models\VisitorPassCategory $visitorPassCategory
 * @property integer $visitor_pass_category_id
 * @property integer $estate_id
 * @property string $generatedCode
 * @property string $guestName
 * @property string $pass_status
 * @property integer $user_id
 * @property string|\Carbon\Carbon $visitationDate
 * @property string|\Carbon\Carbon $generatedDate
 * @property string|\Carbon\Carbon $dateExpires
 * @property integer $duration
 * @property boolean $isActive
 */
class VisitorPass extends Model
{
    use SoftDeletes;


    public $table = 'visitor_passes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'estate_id',
        'generatedCode',
        'guestName',
        'pass_status',
        'user_id',
        'visitationDate',
        'generatedDate',
        'dateExpires',
        'duration',
        'isActive'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'estate_id' => 'integer',
        'generatedCode' => 'string',
        'guestName' => 'string',
        'pass_status' => 'string',
        'user_id' => 'integer',
        'visitationDate' => 'datetime',
        'generatedDate' => 'datetime',
        'dateExpires' => 'datetime',
        'duration' => 'integer',
        'isActive' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'visitationDate' => 'required',
        'guestName' => 'required|string|max:255',
        'duration' => 'required|integer',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function visitorPassCategory()
    {
        return $this->belongsTo(\App\Models\VisitorPassCategory::class, 'visitor_pass_category_id');
    }
}
