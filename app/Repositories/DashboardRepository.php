<?php

namespace App\Repositories;

use App\Models\Bank;
use App\Models\VisitorPass;
use App\Repositories\BaseRepository;

/**
 * Class BankRepository
 * @package App\Repositories
 * @version November 3, 2021, 6:35 pm UTC
*/

class DashboardRepository
{

    public function getVisitorPass()
    {
        $user = request()->user();
        return VisitorPass::query()
            ->when($user->hasRole('resident'), function ($query)use($user){
                $query->where('user_id', $user->id);
            });
    }
}
