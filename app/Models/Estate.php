<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Estate
 * @package App\Models
 * @version November 3, 2021, 9:47 pm UTC
 *
 * @property \App\Models\Bank $bank
 * @property \App\Models\City $city
 * @property \App\Models\User $createdBy
 * @property \App\Models\State $state
 * @property integer $city_id
 * @property integer $state_id
 * @property integer $bank_id
 * @property string $estateCode
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $accountNumber
 * @property string $accountName
 * @property string $imageName
 * @property boolean $accountVerified
 * @property string $alternateEmail
 * @property string $alternatePhone
 * @property string $status
 * @property integer $created_by
 */
class Estate extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'estates';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'city_id',
        'state_id',
        'bank_id',
        'estateCode',
        'contactPerson',
        'name',
        'email',
        'phone',
        'address',
        'accountNumber',
        'accountName',
        'imageName',
        'accountVerified',
        'alternativeContact',
        'alternateEmail',
        'alternatePhone',
        'mail_slug',
        'status',
        'created_by'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'city_id' => 'integer',
        'state_id' => 'integer',
        'bank_id' => 'integer',
        'estateCode' => 'string',
        'contactPerson' => 'string',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'address' => 'string',
        'alternativeContact' => 'string',
        'accountNumber' => 'string',
        'accountName' => 'string',
        'imageName' => 'string',
        'accountVerified' => 'boolean',
        'alternateEmail' => 'string',
        'alternatePhone' => 'string',
        'status' => 'string',
        'created_by' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'city_id' => 'required|integer|exists:cities,id',
        'mail_slug' => 'required|string|max:10',
        'state_id' => 'required|integer|exists:states,id',
        'bank_id' => 'required|integer|exists:banks,id',
        'email' => 'required|string|max:100',
        'phone' => 'required|string|max:17',
        'address' => 'required|string|max:255',
        'contactPerson' => 'required|string|max:100',
        'accountNumber' => 'required|max:12',
        'accountName' => 'required|string|max:100',
        'imageName' => 'nullable|sometimes',
        'created_by' => 'required|integer|exists:users,id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function bank()
    {
        return $this->belongsTo(\App\Models\Bank::class, 'bank_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class, 'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function state()
    {
        return $this->belongsTo(\App\Models\State::class, 'state_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id');
    }
}
