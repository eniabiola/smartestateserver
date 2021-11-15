<?php

namespace App\Repositories;

use App\Models\Invoice;
use App\Repositories\BaseRepository;

/**
 * Class InvoiceRepository
 * @package App\Repositories
 * @version November 14, 2021, 2:25 pm UTC
*/

class InvoiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'billing_id',
        'user_id',
        'estate_id',
        'name',
        'description',
        'invoiceNo',
        'amount',
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
        return Invoice::class;
    }
}
