<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWalletAPIRequest;
use App\Http\Requests\API\UpdateWalletAPIRequest;
use App\Models\Wallet;
use App\Repositories\WalletRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

/**
 * Class WalletController
 * @package
 */

class WalletAPIController extends AppBaseController
{
    /** @var  WalletRepository */
    private $walletRepository;

    public function __construct(WalletRepository $walletRepo)
    {
        $this->walletRepository = $walletRepo;
    }

    /**
     * Display a listing of the Wallet.
     * GET|HEAD /wallets
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {

        $wallets = Wallet::query()
            ->when(Auth::user()->hasrole('resident'), function ($query){
                $query->where('user_id', request()->user()->id);
            })
            ->when(Auth::user()->hasrole('administrator'), function ($query){
                $query->whereHas('user', function($query){
                    $query->where('estate_id',request()->user()->estate_id);
                });
            })
            ->when(Auth::user()->hasrole('superadministrator'), function ($query){
                $query->whereHas('user', function($query){
                    $query->where('estate_id',request()->user()->estate_id);
                });
            })
            ->sum('current_balance');
            return $this->sendResponse($wallets, "Wallet Balance");

    }

    /**
     * Store a newly created Wallet in storage.
     * POST /wallets
     *
     * @param CreateWalletAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateWalletAPIRequest $request)
    {
        $input = $request->all();

        $wallet = $this->walletRepository->create($input);

        return $this->sendResponse($wallet->toArray(), 'Wallet saved successfully');
    }

    /**
     * Display the specified Wallet.
     * GET|HEAD /wallets/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Wallet $wallet */
        $wallet = $this->walletRepository->find($id);

        if (empty($wallet)) {
            return $this->sendError('Wallet not found');
        }

        return $this->sendResponse($wallet->toArray(), 'Wallet retrieved successfully');
    }

    /**
     * Update the specified Wallet in storage.
     * PUT/PATCH /wallets/{id}
     *
     * @param int $id
     * @param UpdateWalletAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWalletAPIRequest $request)
    {
        $input = $request->all();

        /** @var Wallet $wallet */
        $wallet = $this->walletRepository->find($id);

        if (empty($wallet)) {
            return $this->sendError('Wallet not found');
        }

        $wallet = $this->walletRepository->update($input, $id);

        return $this->sendResponse($wallet->toArray(), 'Wallet updated successfully');
    }

    /**
     * Remove the specified Wallet from storage.
     * DELETE /wallets/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Wallet $wallet */
        $wallet = $this->walletRepository->find($id);

        if (empty($wallet)) {
            return $this->sendError('Wallet not found');
        }

        $wallet->delete();

        return $this->sendSuccess('Wallet deleted successfully');
    }
}
