<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ComplainCategory
 * @package App\Models
 * @version November 26, 2021, 10:32 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $complains
 * @property string $name
 * @property string $status
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
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:50|unique:complain_categories,name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function complains()
    {
        return $this->hasMany(\App\Models\Complain::class, 'complain_category_id');
    }
}
