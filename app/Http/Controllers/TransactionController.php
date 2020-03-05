<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\DeleteTransactionRequest;
use App\Http\Requests\getTotalRequest;
use App\Transaction;
use App\User;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    //
    public function createTransaction(CreateTransactionRequest $request) {
        // Incoming validated
        $transaction = Transaction::_create($request);

        $user = auth()->user();

        if ($transaction->type === "expense") {
            $newFunds = $user->funds - $transaction->amount;
            User::_updateFunding($user, $newFunds);
        } elseif ($transaction->type === "income") {
            $newFunds = $user->funds + $transaction->amount;
            User::_updateFunding($user, $newFunds);
        }

        return response()->json(['transaction' => $transaction, 'user' => $user, 'funds' => number_format($user->funds, 2)]);
    }

    public function getTransactions() {
        // Get all transaction
        $user = auth()->user();

        $transactions = Transaction::_getAll($user);

        return response()->json(['transactions' => $transactions]);
    }

    public function deleteTransaction(DeleteTransactionRequest $request) {
        // Check if ID is invalid if it exist
        $user = auth()->user();

        $transaction = Transaction::find($request['id']);
        // If the transaction is expense, add back the money, if its income, take out the money
        if ($transaction->type === "expense") {
            $newFunds = $user->funds + $transaction->amount;
            User::_updateFunding($user, $newFunds);
        } elseif ($transaction->type === "income") {
            $newFunds = $user->funds - $transaction->amount;
            User::_updateFunding($user, $newFunds);
        }
        // then delete the record
        Transaction::_delete($transaction);
        // Return new list
        $transactions = Transaction::_getAll($user);

        return response()->json(['transactions' => $transactions, 'user' => $user]);
    }

    public function getTotal(getTotalRequest $request) {
        // Incoming validated
        $id = auth()->user()->id;
        $transaction = Transaction::where([
            ['user_id' => $id],
            ['on' => $request['on']]
        ])->get();

        $total = Transaction::_getTotal($transaction);

        return response()->json(['total' => number_format($total, 2)]);
    }
}
