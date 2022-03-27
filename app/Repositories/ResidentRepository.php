<?php

namespace App\Repositories;

use App\Models\Resident;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

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
        'users.surname',
        'users.othernames',
        'users.email',
        'users.phone',
        'streets.name',
        'residents.user_id',
        'residents.meterNo',
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
