<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @package App\Models
 * @version November 3, 2021, 3:38 pm UTC
 *
 * @property string $surname
 * @property string $othernames
 * @property string $phone
 * @property string $gender
 * @property string $email
 * @property string|\Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 */
class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;

    use HasFactory, Notifiable, HasRoles;

    public $table = 'users';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'estate_id',
        'surname',
        'othernames',
        'phone',
        'gender',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'estate_id' => 'integer',
        'surname' => 'string',
        'othernames' => 'string',
        'phone' => 'string',
        'gender' => 'string',
        'email' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'string',
        'remember_token' => 'string',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'surname' => 'required|string|max:100',
        'othernames' => 'required|string|max:100',
        'phone' => 'required|string|max:14',
        'gender' => 'required|string',
        'email' => 'required|string|max:255|unique:users,email',
        'remember_token' => 'nullable|string|max:100',
    ];

    protected $hidden = [
        'password', 'updated_at', 'deleted_at', 'email_verified_at', 'remember_token'
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function resident()
    {
        return $this->hasOne(Resident::class);
    }
}
