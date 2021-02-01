<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Transactee;
use App\Models\Deposit;
use App\Models\User;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

    public function onlineDeposit(Request $request)
    {
    	// Payment coming from online payment

    	$validator = Validator::make($request->all(), [
    		'trxref' => 'required',
    		'status' => 'required|string|max:255',
    		'message' => 'required|string|max:255',
    		'amount' => 'required|integer',
    		'payment_type' => 'required|string|max:255',
    		'payment_method' => 'required|string|max:255'
    	]);

    	if ($validator->fails()) {
    		return response()->json([
    			'data' => $validator->errors(),
    			'status' => 'danger',
    			'message' => 'Please fix the following errors'
    		], 422);
    	}

    	$deposit = $this->addDeposit($request->all());

    	if (! $deposit) {
    		return response()->json([
    			'data' => null,
    			'status' => 'danger',
    			'message' => 'Oops we think something went wrong!'
    		], 500);
    	}

    	$transaction = $this->createTransaction($deposit, $request->all());

    	if (! $transaction) {

    		$deposit->delete();

    		return response()->json([
    			'data' => null,
    			'status' => 'danger',
    			'message' => 'Oops we think something went wrong with your transaction!'
    		], 500);
    	}

    	$transaction->transactees()->create([
			'user_id' => $request->user()->id,
			'type' => 'credit',
			'status' => 'receiver'
		]);

		$request->user()->wallet->current += $transaction->amount;
		$request->user()->wallet->deposit += $transaction->amount;
		$request->user()->wallet->save();

    	return response()->json([
    		'data' => new TransactionResource($transaction),
    		'status' => 'success',
    		'message' => 'You have successfully deposited to your account successfully!!'
    	], 201);
    }

    public function bankDeposit(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'trxref' => 'required',
    		'amount' => 'required|integer',
    		'payment_type' => 'required|string|max:255',
    		'payment_method' => 'required|string|max:255',
    		'status' => 'required|string|max:255'
    	]);

    	if ($validator->fails()) {
    		return response()->json([
    			'data' => $validator->errors(),
    			'status' => 'danger',
    			'message' => 'Please fix the following errors'
    		], 422);
    	}

    	$deposit = $this->addDeposit($request->all());

    	if (! $deposit) {
    		return response()->json([
    			'data' => null,
    			'status' => 'danger',
    			'message' => 'Oops we think something went wrong!'
    		], 500);
    	}

    	$transaction = $this->createTransaction($deposit, $request->all());

    	if (! $transaction) {

    		$deposit->delete();

    		return response()->json([
    			'data' => null,
    			'status' => 'danger',
    			'message' => 'Oops we think something went wrong with your transaction!'
    		], 500);
    	}

    	$transaction->transactees()->create([
			'user_id' => $request->user()->id,
			'type' => 'credit',
			'status' => 'receiver'
		]);

		return response()->json([
    		'data' => new TransactionResource($transaction),
    		'status' => 'success',
    		'message' => 'Your request has been received awaiting verification!'
    	], 201);
    }

    public function verifyPayment(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'member' => 'required|string',
    		'transaction' => 'required'
    	]);

    	if ($validator->fails()) {
    		return response()->json([
    			'data' => $validator->errors(),
    			'status' => 'danger',
    			'message' => 'Please fix the following errors'
    		], 422);
    	}

    	$member = User::where('staff_no', $request->member)->first();
    	$transaction = Transaction::where('code', $request->transaction)->first();

    	if (! ($member && $transaction)) {
    		return response()->json([
    			'data' => null,
    			'status' => 'danger',
    			'message' => 'Either the member or transaction record is invalid!'
    		], 422);
    	}

    	if ($transaction->status === "paid") {
    		return response()->json([
    			'data' => new TransactionResource($transaction),
    			'status' => 'warning',
    			'message' => 'This payment transaction has been verified already!',
    		], 409);
    	}

    	$transaction->status = "paid";
    	$transaction->completed = true;

    	if (! $transaction->save()) {
    		return response()->json([
    			'data' => null,
    			'status' => 'danger',
    			'message' => 'The transaction was not saved for some reason!'
    		], 500);
    	}

		$member->wallet->current += $transaction->amount;
		$member->wallet->deposit += $transaction->amount;
		$member->wallet->save();

		return response()->json([
			'data' => new TransactionResource($transaction),
			'status' => 'success',
			'message' => 'This transaction has been updated successfully!'
		], 200);
    }

    private function addDeposit(array $data)
    {
    	return Deposit::create([
    		'user_id' => auth()->user()->id,
    		'trxRef' => $data['trxref'],
    		'amount' => $data['amount'],
    		'paid' => $data['status'] === "success" ? true : false
    	]);
    }

    private function createTransaction(Deposit $deposit, array $data)
    {
    	$transaction = new Transaction;
    	$transaction->code = $data['trxref'];
    	$transaction->type = $data['payment_method'];
    	$transaction->amount = $data['amount'];
    	$transaction->status = $data['status'] === "success" ? "paid" : "pending";
    	$transaction->completed = $data['payment_method'] === "online" ? true : false;

    	$deposit->transactions()->save($transaction);

    	return $transaction;
    }
}
