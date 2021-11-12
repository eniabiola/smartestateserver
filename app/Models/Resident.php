<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Resident
 * @package App\Models
 * @version November 4, 2021, 4:50 pm UTC
 *
 * @property integer $user_id
 * @property integer $estate_id
 * @property string $meterNo
 * @property string $street
 * @property string $houseNo
 * @property string|\Carbon\Carbon $dateMovedIn
 */
class Resident extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'residents';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'user_id',
        'houseNo',
        'street',
        'meterNo',
        'dateMovedIn'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'estate_id' => 'integer',
        'meterNo' => 'string',
        'houseNo' => 'string',
        'street' => 'string',
        'dateMovedIn' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'estateCode' => 'required|exists:estates,estateCode',
        'meterNo' => 'nullable|string|max:40',
        'street' => 'required|string|max:40',
        'houseNo' => 'required|max:12',
        'dateMovedIn' => 'required|date',
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $hidden = [
        'created_at', 'updated_at', 'pivot', 'deleted_at'
    ];
}
