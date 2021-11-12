<?php

namespace App\Repositories;

use App\Models\ModuleAccess;
use App\Repositories\BaseRepository;

/**
 * Class ModuleAccessRepository
 * @package App\Repositories
 * @version November 6, 2021, 10:37 pm UTC
*/

class ModuleAccessRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
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
        return ModuleAccess::class;
    }
}
