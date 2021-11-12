<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ModuleAccess
 * @package App\Models
 * @version November 6, 2021, 10:37 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $userModuleAccesses
 * @property string $name
 */
class ModuleAccess extends Model
{
    use SoftDeletes;


    public $table = 'module_accesses';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100|unique:module_accesses,name',
    ];

    /**
     *  Hidden Attributes
     *
     * @var array
     */
    protected $hidden = [
      'created_at', 'updated_at', 'deleted_at', 'pivot'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function userModuleAccesses()
    {
        return $this->hasMany(\App\Models\UserModuleAccess::class, 'module_access_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class, 'role_module_access', 'module_access_id', 'role_id');
    }
}
