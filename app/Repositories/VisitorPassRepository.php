<?php

namespace App\Repositories;

use App\Models\VisitorPass;
use App\Repositories\BaseRepository;

/**
 * Class VisitorPassRepository
 * @package App\Repositories
 * @version November 19, 2021, 4:40 pm UTC
*/

class VisitorPassRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'estate_id',
        'generatedCode',
        'guestName',
        'status',
        'user_id',
        'visitationDate',
        'generatedDate',
        'dateExpires',
        'duration',
        'expected_number_guests',
        'number_of_guests_in',
        'number_of_guests_out',
        'isActive'
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
        return VisitorPass::class;
    }
}
