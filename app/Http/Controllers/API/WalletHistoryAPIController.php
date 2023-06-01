<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWalletHistoryAPIRequest;
use App\Http\Requests\API\UpdateWalletHistoryAPIRequest;
use App\Models\Transaction;
use App\Models\WalletHistory;
use App\Repositories\WalletHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class WalletHistoryController
 * @package
 */

class WalletHistoryAPIController extends AppBaseController
{
    /** @var  WalletHistoryRepository */
    private $walletHistoryRepository;

    public function __construct(WalletHistoryRepository $walletHistoryRepo)
    {
        $this->walletHistoryRepository = $walletHistoryRepo;
    }

    /**
     * Display a listing of the WalletHistory.
     * GET|HEAD /walletHistories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $walletHistories = WalletHistory::query()
            ->when(Auth::user()->hasrole('resident'), function ($query){
                $query->where('user_id', request()->user()->id)
                ->select('prev_balance', 'amount', 'current_balance', 'description', 'transaction_type', 'created_at');
            })
            ->when(Auth::user()->hasrole('administrator'), function ($query){
                $query->join('users', 'users.id', '=', 'wallet_histories.user_id')
                      ->where('users.estate_id', '=', request()->user()->estate_id)
                       ->select('wallet_histories.prev_balance', 'wallet_histories.amount',
                           'wallet_histories.current_balance', 'wallet_histories.description',
                           'wallet_histories.transaction_type', 'wallet_histories.created_at', 'users.email');
            })
            ->when(Auth::user()->hasrole('superadministrator'), function ($query){
                $query->join('users', 'users.id', '=', 'wallet_histories.user_id')
                    ->where('users.estate_id', '=', request()->user()->estate_id)
                    ->select('wallet_histories.prev_balance', 'wallet_histories.amount',
                        'wallet_histories.current_balance', 'wallet_histories.description',
                        'wallet_histories.transaction_type', 'wallet_histories.created_at', 'users.email');
            })
            ->orderBy('wallet_histories.created_at', 'DESC')
            ->paginate(20);

        return $this->sendResponse($walletHistories, 'Wallet Histories retrieved successfully');

    }

    /**
     * Display a listing of the WalletHistory based on a particular user.
     * GET|HEAD /walletHistories_per_user/{user_id}
     *
     * @param Request $request
     * @param user_id
     * @return Response
     */
    public function userIndex(Request $request, $user_id)
    {
        if(Auth::user()->hasrole('administrator')){
            abort(404);
            return $this->sendError("You have no right to view this page");
        }
        $walletHistories = WalletHistory::query()
            ->when(Auth::user()->hasrole('administrator'), function ($query){
                $query->whereHas('user', function($query){
                    $query->where('estate_id',request()->user()->estate_id);
//                    ->where('user_id', $user_id);
                });
            })
            ->when(Auth::user()->hasrole('superadministrator'), function ($query){
                $query->whereHas('user', function($query){
                    $query->where('estate_id',request()->user()->estate_id);
                });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        return $this->sendResponse($walletHistories, 'Wallet Histories retrieved successfully');

    }

    /**
     * Store a newly created WalletHistory in storage.
     * POST /walletHistories
     *
     * @param CreateWalletHistoryAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateWalletHistoryAPIRequest $request)
    {
        $input = $request->all();

        $walletHistory = $this->walletHistoryRepository->create($input);

        return $this->sendResponse($walletHistory->toArray(), 'Wallet History saved successfully');
    }

    /**
     * Display the specified WalletHistory.
     * GET|HEAD /walletHistories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var WalletHistory $walletHistory */
        $walletHistory = $this->walletHistoryRepository->find($id);

        if (empty($walletHistory)) {
            return $this->sendError('Wallet History not found');
        }

        return $this->sendResponse($walletHistory->toArray(), 'Wallet History retrieved successfully');
    }

    /**
     * Update the specified WalletHistory in storage.
     * PUT/PATCH /walletHistories/{id}
     *
     * @param int $id
     * @param UpdateWalletHistoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWalletHistoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var WalletHistory $walletHistory */
        $walletHistory = $this->walletHistoryRepository->find($id);

        if (empty($walletHistory)) {
            return $this->sendError('Wallet History not found');
        }

        $walletHistory = $this->walletHistoryRepository->update($input, $id);

        return $this->sendResponse($walletHistory->toArray(), 'WalletHistory updated successfully');
    }

    /**
     * Remove the specified WalletHistory from storage.
     * DELETE /walletHistories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var WalletHistory $walletHistory */
        $walletHistory = $this->walletHistoryRepository->find($id);

        if (empty($walletHistory)) {
            return $this->sendError('Wallet History not found');
        }

        $walletHistory->delete();

        return $this->sendSuccess('Wallet History deleted successfully');
    }
}
