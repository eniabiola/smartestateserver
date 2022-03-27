<?php

namespace App\Repositories;

use App\Models\ComplainCategory;
use App\Repositories\BaseRepository;

/**
 * Class ComplainCategoryRepository
 * @package App\Repositories
 * @version November 27, 2021, 10:16 pm UTC
*/

class ComplainCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status',
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
        return ComplainCategory::class;
    }
}
