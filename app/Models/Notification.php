<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Notification
 * @package App\Models
 * @version November 27, 2021, 10:18 pm UTC
 *
 * @property \App\Models\User $createdBy
 * @property \App\Models\Estate $estate
 * @property \App\Models\NotificationGroup $group
 * @property \App\Models\User $receiver
 * @property \Illuminate\Database\Eloquent\Collection $notificationStreets
 * @property integer $created_by
 * @property integer $estate_id
 * @property integer $receiver_id
 * @property integer $group_id
 * @property integer $street_id
 * @property string $name
 * @property string $title
 * @property string $message
 * @property string $file
 * @property string $recipient_type
 */
class Notification extends Model
{
    use SoftDeletes;


    public $table = 'notifications';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'created_by',
        'estate_id',
        'receiver_id',
        'group_id',
        'street_id',
        'name',
        'title',
        'message',
        'file',
        'recipient_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'created_by' => 'integer',
        'estate_id' => 'integer',
        'receiver_id' => 'integer',
        'group_id' => 'integer',
        'street_id' => 'integer',
        'name' => 'string',
        'title' => 'string',
        'message' => 'string',
        'file' => 'string',
        'recipient_type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'created_by' => 'nullable',
        'estate_id' => 'nullable',
        'receiver_id' => 'nullable',
        'group_id' => 'nullable',
        'street_id' => 'nullable',
        'name' => 'required|string|max:100',
        'title' => 'required|string|max:200',
        'message' => 'required|string',
        'file' => 'nullable|string|max:255',
        'recipient_type' => 'nullable|string|max:20',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

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
    public function estate()
    {
        return $this->belongsTo(\App\Models\Estate::class, 'estate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function group()
    {
        return $this->belongsTo(\App\Models\NotificationGroup::class, 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function receiver()
    {
        return $this->belongsTo(\App\Models\User::class, 'receiver_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function notificationStreets()
    {
        return $this->hasMany(\App\Models\NotificationStreet::class, 'notification_id');
    }
}
