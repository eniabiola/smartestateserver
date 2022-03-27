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
        'visitor_passes.estate_id',
        'visitor_passes.generatedCode',
        'visitor_passes.guestName',
        'visitor_passes.visitationDate',
        'visitor_passes.generatedDate',
        'visitor_passes.duration',
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
