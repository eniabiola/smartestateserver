<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\BaseRepository;

/**
 * Class SettingRepository
 * @package App\Repositories
 * @version December 30, 2021, 9:47 pm UTC
*/

class SettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'front_end_url',
        'security_unit',
        'fire_and_emergency',
        'police_post',
        'hospital',
        'CRI',
        'clinic'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Setting::class;
    }
}
