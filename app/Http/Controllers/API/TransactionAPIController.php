<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTransactionAPIRequest;
use App\Http\Requests\API\UpdateTransactionAPIRequest;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\DB;
use Response;
use Auth;

/**
 * Class TransactionController
 * @package
 */

class TransactionAPIController extends AppBaseController
{
    /** @var  TransactionRepository */
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepository = $transactionRepo;
    }

    /**
     * Display a listing of the Transaction.
     * GET|HEAD /transactions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $status = $request->status ?? null;
        $date_from = $request->date_from ?? null;
        $date_to = $request->date_to ?? null;
        $transactions = Transaction::query()
            ->when(!is_null($status), function ($query) use($status){
                $query->when('wallet_histories', '=', $status);
            })
            ->when(!is_null($date_from), function ($query) use($date_to, $date_from){
                
            })
            ->when(Auth::user()->hasrole('resident'), function ($query){
                $query->where('user_id', request()->user()->id)
                    ->select('transactions.amount', 'transactions.transaction_reference',
                        'transactions.transaction_status', 'transactions.date_initiated');
            })
            ->when(Auth::user()->hasrole('administrator'), function ($query){
                $query->join('users', 'users.id', '=', 'wallet_histories.user_id')
                    ->where('users.estate_id', '=', request()->user()->estate_id)
                    ->select('users.email', DB::raw("CONCAT(`users`.`surname`,`users`.`othernames`) as full_name"),
                        'transactions.amount', 'transactions.transaction_reference',
                        'transactions.transaction_status', 'transactions.date_initiated');
            })
            ->when(Auth::user()->hasrole('superadministrator'), function ($query){
                $query->join('users', 'users.id', '=', 'wallet_histories.user_id')
                    ->where('users.estate_id', '=', request()->user()->estate_id)
                    ->select('users.email', DB::raw("CONCAT(`users`.`surname`,`users`.`othernames`) as full_name"),
                        'transactions.amount', 'transactions.transaction_reference',
                        'transactions.transaction_status', 'transactions.date_initiated');
            })
            ->orderBy('transactions.created_at', 'DESC')
            ->paginate(20);;

        return $this->sendResponse($transactions->toArray(), 'Transactions retrieved successfully');
    }

    /**
     * Store a newly created Transaction in storage.
     * POST /transactions
     *
     * @param CreateTransactionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTransactionAPIRequest $request)
    {
        $input = $request->all();

        $transaction = $this->transactionRepository->create($input);

        return $this->sendResponse($transaction->toArray(), 'Transaction saved successfully');
    }

    /**
     * Display the specified Transaction.
     * GET|HEAD /transactions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        return $this->sendResponse($transaction->toArray(), 'Transaction retrieved successfully');
    }

    /**
     * Update the specified Transaction in storage.
     * PUT/PATCH /transactions/{id}
     *
     * @param int $id
     * @param UpdateTransactionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTransactionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Transaction $transaction */
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        $transaction = $this->transactionRepository->update($input, $id);

        return $this->sendResponse($transaction->toArray(), 'Transaction updated successfully');
    }

    /**
     * Remove the specified Transaction from storage.
     * DELETE /transactions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        $transaction->delete();

        return $this->sendSuccess('Transaction deleted successfully');
    }

    public function transactionRequery(Request $request, $transaction_reference)
    {

    }
}
