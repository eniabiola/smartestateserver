<?php

namespace App\Repositories;

use App\Models\Street;
use App\Repositories\BaseRepository;

/**
 * Class StreetRepository
 * @package App\Repositories
 * @version November 15, 2021, 7:49 am UTC
*/

class StreetRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
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
        return Street::class;
    }
}
