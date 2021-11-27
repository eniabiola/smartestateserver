<?php

namespace App\Repositories;

use App\Models\ComplainCategory;
use App\Repositories\BaseRepository;

/**
 * Class ComplainCategoryRepository
 * @package App\Repositories
 * @version November 26, 2021, 10:32 pm UTC
*/

class ComplainCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status'
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
