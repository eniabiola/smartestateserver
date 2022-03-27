<?php

namespace App\Repositories;

use App\Models\NotificationGroup;
use App\Repositories\BaseRepository;

/**
 * Class NotificationGroupRepository
 * @package App\Repositories
 * @version November 27, 2021, 10:18 pm UTC
*/

class NotificationGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'user_id',
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
        return NotificationGroup::class;
    }
}
