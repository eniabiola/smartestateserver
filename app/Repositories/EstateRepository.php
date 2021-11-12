<?php

namespace App\Repositories;

use App\Models\Estate;
use App\Repositories\BaseRepository;

/**
 * Class EstateRepository
 * @package App\Repositories
 * @version November 3, 2021, 9:47 pm UTC
*/

class EstateRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'city_id',
        'state_id',
        'bank_id',
        'estateCode',
        'name',
        'email',
        'phone',
        'address',
        'accountNumber',
        'accountName',
        'imageName',
        'accountVerified',
        'alternateEmail',
        'alternatePhone',
        'status',
        'created_by'
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
        return Estate::class;
    }
}
