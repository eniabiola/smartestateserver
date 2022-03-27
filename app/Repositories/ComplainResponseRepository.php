<?php

namespace App\Repositories;

use App\Models\ComplainResponse;
use App\Repositories\BaseRepository;

/**
 * Class ComplainResponseRepository
 * @package App\Repositories
 * @version November 26, 2021, 10:37 pm UTC
*/

class ComplainResponseRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'complain_id',
        'user_id',
        'estate_id',
        'response',
        'file',
        'user_role',
        'isOwner'
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
        return ComplainResponse::class;
    }
}
