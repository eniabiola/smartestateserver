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
 * @property string $status
 * @property string $pass_type
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


    protected $dates = ['deleted_at', 'created_at', 'updated_at', 'visitationDate'];



    public $fillable = [
        'estate_id',
        'generatedCode',
        'guestName',
        'status',
        'user_id',
        'visitationDate',
        'generatedDate',
        'dateExpires',
        'duration',
        'pass_type',
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
        'status' => 'string',
        'user_id' => 'integer',
        'expected_number_of_guests' => 'integer',
        'number_of_guests_in' => 'integer',
        'number_of_guests_out' => 'integer',
        'visitationDate' => 'date:Y-m-d H:i:s',
        'generatedDate' => 'date:Y-m-d H:i:s',
        'dateExpires' => 'date:Y-m-d H:i:s',
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
        'guestName' => 'nullable|required_if:pass_type,==,individual|string',
        'event' => 'nullable|required_if:pass_type,==,group|string',
        'expected_number_of_guests' => 'nullable|required_if:pass_type,==,group|integer',
        'pass_type' => 'required|in:individual,group',
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function visitorGroup()
    {
        return $this->hasOne(\App\Models\VisitorPassGroup::class);
    }

}
