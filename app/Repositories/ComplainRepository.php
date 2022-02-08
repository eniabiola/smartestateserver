<?php

namespace App\Repositories;

use App\Models\Complain;
use App\Repositories\BaseRepository;

/**
 * Class ComplainRepository
 * @package App\Repositories
 * @version November 26, 2021, 10:36 pm UTC
*/

class ComplainRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'complains.complain_category_id',
        'users.surname',
        'users.othernames',
        'estates.name',
        'complains.ticket_no',
        'complains.subject',
        'complains.priority',
        'complains.file',
        'complains.description',
        'complains.status'
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
        return Complain::class;
    }
}
