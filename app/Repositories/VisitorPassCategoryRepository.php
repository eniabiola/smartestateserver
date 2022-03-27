<?php

namespace App\Repositories;

use App\Models\VisitorPassCategory;
use App\Repositories\BaseRepository;

/**
 * Class VisitorPassCategoryRepository
 * @package App\Repositories
 * @version November 7, 2021, 9:51 pm UTC
*/

class VisitorPassCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'prefix',
        'numberAllowed',
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
        return VisitorPassCategory::class;
    }
}
