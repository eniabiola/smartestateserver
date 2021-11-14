<?php

namespace App\Repositories;

use App\Models\Billing;
use App\Repositories\BaseRepository;

/**
 * Class BillingRepository
 * @package App\Repositories
 * @version November 14, 2021, 11:32 am UTC
*/

class BillingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'amount',
        'bill_frequency',
        'bill_target',
        'invoice_day',
        'invoice_month',
        'due_day',
        'due_month',
        'status',
        'estate_id',
        'created_by'
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
        return Billing::class;
    }
}
