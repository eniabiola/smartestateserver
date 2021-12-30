<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Setting
 * @package App\Models
 * @version December 30, 2021, 9:47 pm UTC
 *
 * @property string $front_end_url
 * @property string $security_unit
 * @property string $fire_and_emergency
 * @property string $police_post
 * @property string $hospital
 * @property string $CRI
 * @property string $clinic
 */
class Setting extends Model
{
//    use SoftDeletes;


    public $table = 'settings';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'front_end_url',
        'security_unit',
        'fire_and_emergency',
        'police_post',
        'hospital',
        'CRI',
        'clinic'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'front_end_url' => 'string',
        'security_unit' => 'string',
        'fire_and_emergency' => 'string',
        'police_post' => 'string',
        'hospital' => 'string',
        'CRI' => 'string',
        'clinic' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'front_end_url' => 'required|string|max:150',
        'security_unit' => 'nullable|string|max:191',
        'fire_and_emergency' => 'nullable|string|max:191',
        'police_post' => 'nullable|string|max:191',
        'hospital' => 'nullable|string|max:191',
        'CRI' => 'nullable|string|max:191',
        'clinic' => 'nullable|string|max:191',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];


}
