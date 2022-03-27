<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Bank
 * @package App\Models
 * @version November 3, 2021, 6:35 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $estates
 * @property string $name
 * @property string $bank_code
 * @property string $sort_code
 */
class Bank extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'banks';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'bank_code',
        'sort_code'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'bank_code' => 'string',
        'sort_code' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:191',
        'bank_code' => 'required|string|max:5',
        'sort_code' => 'nullable|string|max:10',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function estates()
    {
        return $this->hasMany(\App\Models\Estate::class, 'bank_id');
    }
}
