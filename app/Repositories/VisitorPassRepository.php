<?php

namespace App\Repositories;

use App\Models\VisitorPass;
use App\Repositories\BaseRepository;

/**
 * Class VisitorPassRepository
 * @package App\Repositories
 * @version November 7, 2021, 9:50 pm UTC
*/

class VisitorPassRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'visitor_pass_category_id',
        'generatedCode',
        'guestName',
        'gender',
        'pass_status',
        'user_id',
        'visitationDate',
        'generatedDate',
        'dateExpires',
        'isRecurrent'
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
