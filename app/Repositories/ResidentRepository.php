<?php

namespace App\Repositories;

use App\Models\Resident;
use App\Repositories\BaseRepository;

/**
 * Class ResidentRepository
 * @package App\Repositories
 * @version November 4, 2021, 4:50 pm UTC
*/

class ResidentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'estate_id',
        'meterNo',
        'dateMovedIn'
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
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        $query->whereHas('user', function ($query){
           $query->where('estate_id', \request()->user()->estate_id);
        });
        if (count($search)) {
            foreach($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Resident::class;
    }
}
