<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Street
 * @package App\Models
 * @version November 15, 2021, 7:49 am UTC
 *
 * @property \App\Models\Estate $estate
 * @property string $name
 * @property integer $estate_id
 */
class Street extends Model
{
    use SoftDeletes;


    public $table = 'streets';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
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
        'estate_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255,unique:streets,name'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estate()
    {
        return $this->belongsTo(\App\Models\Estate::class, 'estate_id');
    }
}
