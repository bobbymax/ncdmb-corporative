<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransacteeResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transactee;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $transactions = Transaction::where('id', '>=', 1)->with('transactees')->get();
        if ($transactions->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => TransactionResource::collection($transactions),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    public function show($id)
    {
        $transactees = Transactee::where('user_id', $id)->with('transaction')->get();
        if ($transactees->count() < 1) {
            return response()->json([
                'data' => null,
                'status' => 'info',
                'message' => 'No data was found!'
            ], 404);
        }
        return response()->json([
            'data' => TransacteeResource::collection($transactees),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }

    public function transactionType($type)
    {
        $transactions = Transaction::where('type', $type)->get(['id', 'code', 'type', 'amount', 'status', 'completed', 'created_at']);
        if ($type == 'deposit') {
            $transactions = Transaction::where('type', 'online')->orWhere('type', 'bank')->get(['id', 'code', 'type', 'amount', 'status', 'completed', 'created_at']);
        }
        if (count($transactions) < 1) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This transaction type does not exists'
            ], 404);
        }
        return response()->json([
            'data' => $transactions, //new TransactionResource($transactions),
            'status' => 'success',
            'message' => 'Data found!'
        ], 200);
    }
}
