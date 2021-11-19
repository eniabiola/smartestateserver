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
        'visitor_pass_category_id',
        'estate_id',
        'generatedCode',
        'guestName',
        'pass_status',
        'user_id',
        'visitationDate',
        'generatedDate',
        'dateExpires',
        'duration',
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
