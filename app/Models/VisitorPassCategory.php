<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class VisitorPassCategory
 * @package App\Models
 * @version November 7, 2021, 9:51 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $visitorPasses
 * @property string $name
 * @property string $description
 * @property string $prefix
 * @property integer $numberAllowed
 * @property boolean $isActive
 */
class VisitorPassCategory extends Model
{
    use SoftDeletes;


    public $table = 'visitor_pass_categories';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'prefix',
        'numberAllowed',
        'isActive'
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
        'prefix' => 'string',
        'numberAllowed' => 'integer',
        'isActive' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255|unique:visitor_pass_categories,name',
        'description' => 'required|string|max:255',
        'prefix' => 'nullable|string|max:10|unique:visitor_pass_categories,prefix',
        'numberAllowed' => 'required|integer',
        'isActive' => 'required|boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function visitorPasses()
    {
        return $this->hasMany(\App\Models\VisitorPass::class, 'visitor_pass_category_id');
    }
}
