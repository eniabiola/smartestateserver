<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\BaseRepository;

/**
 * Class CountryRepository
 * @package App\Repositories
 * @version November 15, 2021, 3:49 pm UTC
*/

class CountryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'iso_code_1',
        'iso_code_2',
        'status',
        'phonecode'
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
        return Country::class;
    }
}
