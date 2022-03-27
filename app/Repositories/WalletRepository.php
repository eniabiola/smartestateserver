<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Repositories\BaseRepository;

/**
 * Class WalletRepository
 * @package App\Repositories
 * @version November 30, 2021, 11:17 pm UTC
*/

class WalletRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'prev_balance',
        'amount',
        'current_balance',
        'transaction_type'
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
        return Wallet::class;
    }
}
