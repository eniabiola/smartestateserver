<?php

namespace App\Repositories;

use App\Models\WalletHistory;
use App\Repositories\BaseRepository;

/**
 * Class WalletHistoryRepository
 * @package App\Repositories
 * @version November 14, 2021, 2:41 pm UTC
*/

class WalletHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'prev_balance',
        'amount',
        'current_balance',
        'transaction_type',
        'description'
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
        return WalletHistory::class;
    }
}
