<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;


/**
 * Class Setting
 * @package App\Models
 * @version February 2, 2022, 7:16 pm UTC
 *
 * @property \App\Models\Estate $estate
 * @property string $name
 * @property string $value
 * @property string $type
 * @property integer $estate_id
 */
class Setting extends Model
{
//    use SoftDeletes;


    public $table = 'settings';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'value',
        'type',
        'estate_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'value' => 'string',
        'type' => 'string',
        'estate_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:100',
        'value' => 'required|string|max:100',
        'type' => 'required|string|max:20',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'estate_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estate()
    {
        return $this->belongsTo(\App\Models\Estate::class, 'estate_id');
    }


    /**
     * Add a settings value
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function add($key, $val, $type = 'string')
    {
        if ( self::has($key) ) {

            return self::set($key, $val, $type);
        }

        return self::create(['name' => $key, 'val' => $val, 'type' => $type]) ? $val : false;
    }

    /**
     * Get a settings value
     *
     * @param $key
     * @param null $default
     * @return bool|int|mixed
     */
    public static function get($key, $default = null)
    {
        if ( self::has($key) ) {
            $setting = self::getAllSettings()->where('name', $key)->first();
            return self::castValue($setting->val, $setting->type);
        }

        return self::getDefaultValue($key, $default);
    }

    /**
     * Set a value for setting
     *
     * @param $key
     * @param $val
     * @param string $type
     * @return bool
     */
    public static function set($key, $val, $type = 'string')
    {
        $val = ($type == 'array')? json_encode($val) :$val;
        //dump($type);
        if ( $setting = self::getAllSettings()->where('name', $key)->first() ) {
            $setting->name = $key;
            $setting->val = $val;
            $setting->type = $type;
            return $setting->save() ? $val : false;
        }

        return self::add($key, $val, $type);
    }

    /**
     * Remove a setting
     *
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        if( self::has($key) ) {
            return self::whereName($key)->delete();
        }

        return false;
    }

    /**
     * Check if setting exists
     *
     * @param $key
     * @return bool
     */
    public static function has($key)
    {
        return (boolean) self::getAllSettings()->whereStrict('name', $key)->count();
    }

    /**
     * Get the validation rules for setting fields
     *
     * @return array
     */
    public static function getValidationRules()
    {
        return self::getDefinedSettingFields()->pluck('rules', 'name')
            ->reject(function ($val) {
                return is_null($val);
            })->toArray();
    }

    /**
     * Get the data type of a setting
     *
     * @param $field
     * @return mixed
     */
    public static function getDataType($field)
    {
        $type  = self::getDefinedSettingFields()
            ->pluck('data', 'name')
            ->get($field);

        return is_null($type) ? 'string' : $type;
    }

    /**
     * Get default value for a setting
     *
     * @param $field
     * @return mixed
     */
    public static function getDefaultValueForField($field)
    {
        return self::getDefinedSettingFields()
            ->pluck('value', 'name')
            ->get($field);
    }

    /**
     * Get default value from config if no value passed
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    private static function getDefaultValue($key, $default)
    {
        return is_null($default) ? self::getDefaultValueForField($key) : $default;
    }

    /**
     * Get all the settings fields from config
     *
     * @return Collection
     */
    private static function getDefinedSettingFields()
    {
        return collect(config('settings'))->pluck('elements')->flatten(1);
    }

    /**
     * caste value into respective type
     *
     * @param $val
     * @param $castTo
     * @return bool|int
     */
    private static function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
                break;
            case 'array':
                return json_decode($val);
                break;

            case 'bool':
            case 'boolean':
                return boolval($val);
                break;

            default:
                return $val;
        }
    }



    /**
     * Get all setting
     * @return array
     */
    public static function settings(){
        $collection =  new Collection();
        $settings = config('settings');
        foreach ($settings as $section => $fields){
            if(is_array($fields['elements'])) {

                foreach ($fields['elements'] as $index => $element) {
                    $fields['elements'][$index]['value'] = setting($element['name']);
                }
            }

            $collection->put($section, $fields);
        }

        return $collection->toArray();
    }


    /**
     * Get all the settings
     *
     * @return mixed
     */
    public static function getAllSettings()
    {
        return self::all();
        return Cache::rememberForever('settings.all', function() {
            return self::all();
        });
    }

    /**
     * Flush the cache
     */
    public static function flushCache()
    {
        Cache::forget('settings.all');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::updated(function () {
            self::flushCache();
        });

        static::created(function() {
            self::flushCache();
        });
    }
}
