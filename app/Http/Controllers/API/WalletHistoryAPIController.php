<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWalletHistoryAPIRequest;
use App\Http\Requests\API\UpdateWalletHistoryAPIRequest;
use App\Models\WalletHistory;
use App\Repositories\WalletHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
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
        $walletHistories = $this->walletHistoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($walletHistories->toArray(), 'Wallet Histories retrieved successfully');
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
