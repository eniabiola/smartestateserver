<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class State
 * @package App\Models
 * @version November 3, 2021, 6:34 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $cities
 * @property \Illuminate\Database\Eloquent\Collection $estates
 * @property string $name
 */
class State extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'states';
    
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
        'name' => 'required|string|max:100',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function cities()
    {
        return $this->hasMany(\App\Models\City::class, 'state_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function estates()
    {
        return $this->hasMany(\App\Models\Estate::class, 'state_id');
    }
}
