<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Repositories\DashboardRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends AppBaseController
{

    private $dashboardRepo;

    public function __construct()
    {
        $this->dashboardRepo = new DashboardRepository();
    }

    public function dashboardAnalytics(Request $request)
    {
        /**
         * active_visits
         * visits_last_30_days
         * guests
         * cancelled_visits_last_30_days
         */
        $active_visits = $this->dashboardRepo->getVisitorPass()
            ->where('status', '=', 'active')
//            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->count();


        $total_visits = $this->dashboardRepo->getVisitorPass()
            ->where('status', '!=', 'cancel')
            ->where('status', '!=', 'inactive')
            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->count();

        $cancelled_visits = $this->dashboardRepo->getVisitorPass()
            ->where('status', '=', 'cancel')
            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->count();

        $graph = $this->dashboardRepo->getVisitorPass()

            ->select(\DB::raw('DATE_FORMAT(visitationDate, "%m/%Y") as visitationDate1'), \DB::raw('MONTH(created_at) as month,  count("visitationDate") as count'))
            ->groupBy('month')
            ->get();

        $owing = Invoice::query()
            ->where('status', '=', 'Not Paid')
            ->where('user_id', '=', Auth::id())
            ->sum('amount');

//         $graph->for
        $result_array = [
            'active_visits' => $active_visits,
            'total_visits' => $total_visits,
            'cancelled_visits' => $cancelled_visits,
            'graph' => $graph,
            'owing' => $owing,
        ];

        return $this->sendResponse($result_array, "Dashboard Analytics");
    }
}
