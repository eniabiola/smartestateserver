<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ComplainResponse
 * @package App\Models
 * @version November 26, 2021, 10:37 pm UTC
 *
 * @property \App\Models\Complain $complain
 * @property \App\Models\Estate $estate
 * @property \App\Models\User $user
 * @property integer $complain_id
 * @property integer $user_id
 * @property integer $estate_id
 * @property string $response
 * @property string $file
 * @property string $user_role
 * @property boolean $isOwner
 */
class ComplainResponse extends Model
{
    use SoftDeletes;


    public $table = 'complain_responses';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'complain_id',
        'user_id',
        'estate_id',
        'response',
        'file',
        'user_role',
        'isOwner'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'complain_id' => 'integer',
        'user_id' => 'integer',
        'estate_id' => 'integer',
        'response' => 'string',
        'file' => 'string',
        'user_role' => 'string',
        'isOwner' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'complain_id' => 'required',
        'response' => 'required|string',
        'file' => 'nullable|string|max:255',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function complain()
    {
        return $this->belongsTo(\App\Models\Complain::class, 'complain_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estate()
    {
        return $this->belongsTo(\App\Models\Estate::class, 'estate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
