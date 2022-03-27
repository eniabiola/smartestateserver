<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ComplainCategory
 * @package App\Models
 * @version November 27, 2021, 10:16 pm UTC
 *
 * @property \App\Models\Estate $estate
 * @property \Illuminate\Database\Eloquent\Collection $complains
 * @property string $name
 * @property string $status
 * @property integer $estate_id
 */
class ComplainCategory extends Model
{
    use SoftDeletes;


    public $table = 'complain_categories';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'status',
        'estate_id',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'string',
        'estate_id' => 'integer',
        'email' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:50|unique:complain_categories,name',
        'email' => 'required|email:rfc,dns'
//        'status' => 'required|string|max:20',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estate()
    {
        return $this->belongsTo(\App\Models\Estate::class, 'estate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function complains()
    {
        return $this->hasMany(\App\Models\Complain::class, 'complain_category_id');
    }
}
