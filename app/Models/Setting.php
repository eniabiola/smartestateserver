<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Setting
 * @package App\Models
 * @version February 2, 2022, 7:16 pm UTC
 *
 * @property \App\Models\Estate $estate
 * @property string $name
 * @property string $value
 * @property string $type
 * @property integer $estate_id
 */
class Setting extends Model
{
//    use SoftDeletes;


    public $table = 'settings';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'value',
        'type',
        'estate_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'value' => 'string',
        'type' => 'string',
        'estate_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100',
        'value' => 'required|string|max:100',
        'type' => 'required|string|max:20',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'estate_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estate()
    {
        return $this->belongsTo(\App\Models\Estate::class, 'estate_id');
    }
}
