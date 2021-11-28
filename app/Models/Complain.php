<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Complain
 * @package App\Models
 * @version November 26, 2021, 10:36 pm UTC
 *
 * @property \App\Models\ComplainCategory $complainCategory
 * @property \App\Models\Estate $estate
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $complainResponses
 * @property integer $complain_category_id
 * @property integer $user_id
 * @property integer $estate_id
 * @property string $ticket_no
 * @property string $subject
 * @property string $priority
 * @property string $file
 * @property string $description
 * @property string $status
 */
class Complain extends Model
{
    use SoftDeletes;


    public $table = 'complains';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'complain_category_id',
        'user_id',
        'estate_id',
        'ticket_no',
        'subject',
        'priority',
        'file',
        'description',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'complain_category_id' => 'integer',
        'user_id' => 'integer',
        'estate_id' => 'integer',
        'ticket_no' => 'string',
        'subject' => 'string',
        'priority' => 'string',
        'file' => 'string',
        'description' => 'string',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'complain_category_id' => 'required|integer|exists:complain_categories,id',
        'subject' => 'required|string|max:20',
        'priority' => 'required|string|max:20',
        'file' => 'nullable|string',
        'description' => 'required|string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function complainCategory()
    {
        return $this->belongsTo(\App\Models\ComplainCategory::class, 'complain_category_id');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function complainResponses()
    {
        return $this->hasMany(\App\Models\ComplainResponse::class, 'complain_id');
    }

    protected $hidden = [
        "updated_at","deleted_at"
    ];
}
