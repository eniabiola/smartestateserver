<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\BaseRepository;

/**
 * Class SettingRepository
 * @package App\Repositories
 * @version February 2, 2022, 7:16 pm UTC
*/

class SettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'value',
        'type',
        'estate_id'
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
