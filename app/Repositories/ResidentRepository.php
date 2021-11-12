<?php

namespace App\Repositories;

use App\Models\Resident;
use App\Repositories\BaseRepository;

/**
 * Class ResidentRepository
 * @package App\Repositories
 * @version November 4, 2021, 4:50 pm UTC
*/

class ResidentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'estate_id',
        'meterNo',
        'dateMovedIn'
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
        return Resident::class;
    }
}
