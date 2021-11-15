<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Country
 * @package App\Models
 * @version November 15, 2021, 3:49 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $estates
 * @property string $name
 * @property string $iso_code_1
 * @property string $iso_code_2
 * @property string $status
 * @property string $phonecode
 */
class Country extends Model
{
//    use SoftDeletes;


    public $table = 'countries';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'iso_code_1',
        'iso_code_2',
        'status',
        'phonecode'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'iso_code_1' => 'string',
        'iso_code_2' => 'string',
        'status' => 'string',
        'phonecode' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'iso_code_1' => 'required|string|max:255',
        'iso_code_2' => 'required|string|max:255',
        'status' => 'required|string',
        'phonecode' => 'nullable|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function estates()
    {
        return $this->hasMany(\App\Models\Estate::class, 'country_id');
    }
}
