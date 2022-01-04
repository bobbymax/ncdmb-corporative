<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Transactee;
use App\Models\Deposit;
use App\Models\User;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
/**
     * @OA\Post(
     * path="/online/deposit",
     *   tags={"Payments"},
     *   summary="Make Payments",
     *   operationId="onlineDeposit",
     *
     *
     *   @OA\Parameter(
     *      name="trxRef",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Parameter(
     *      name="message",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     * @OA\Parameter(
     *      name="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer",
     *
     *      )
     * ),
     * @OA\Parameter(
     *      name="payment_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     *
     * @OA\Parameter(
     *      name="payment_method",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     *   @OA\Response(
     *      response=201,
     *       description="You have successfully deposited into your account!!",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="Please fix the following errors"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
        * @OA\Response(
     *         response=500,
     *         description="Oops we think something went wrong!",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     )
     *
     * )
     * )
    */

    /**
     * @OA\Post(
     * path="/bank/deposit",
     *   tags={"Payments"},
     *   summary="Bank Deposit",
     *   operationId="bankDeposit",
     *
     *
     *   @OA\Parameter(
     *      name="trxRef",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="payment_type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     * @OA\Parameter(
     *      name="payment_method",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     * @OA\Parameter(
     *      name="status",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string",
     *
     *      )
     * ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Your request has been received awaiting verification!",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="Please fix the following errors"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
        * @OA\Response(
     *         response=500,
     *         description="Oops we think something went wrong!",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     )
     *
     * )
     * )
    */

       /**
     * @OA\Post(
     * path="/verify/member/payment",
     *   tags={"Payments"},
     *   summary="Verify Member Payments",
     *   operationId="verifyMemberPayment",
     *
     *
     *   @OA\Parameter(
     *      name="member",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="transaction",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *
     *      )
     * ),
     *   @OA\Response(
     *      response=200,
     *       description="This transaction has been updated successfully",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="Please fix the following errors"
     *   ),
     *   @OA\Response(
     *      response=409,
     *      description="this payment transaction has been verified already!"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Page Not Found. If error persists, contact info@ncdmb.gov.ng"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
        * @OA\Response(
     *         response=500,
     *         description="The transaction was not saved for some reason!",
     *         @OA\JsonContent(
     *             type="string",
     *
     *         )
     *
     *     )
     *
     * )
     * )
    */
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
    		'trxRef' => 'required',
    		'status' => 'required|string|max:255',
    		'message' => 'required|string|max:255',
    		'amount' => 'required|integer',
    		'payment_type' => 'required|string|max:255',
    		'payment_method' => 'required|string|max:255'
    	]);

    	if ($validator->fails()) {
    		return response()->json([
    			'data' => $validator->errors(),
    			'status' => 'error',
    			'message' => 'Please fix the following errors'
    		], 422);
    	}

    	$deposit = $this->addDeposit($request->all());

    	if (! $deposit) {
    		return response()->json([
    			'data' => null,
    			'status' => 'error',
    			'message' => 'Oops we think something went wrong!'
    		], 500);
    	}

    	$transaction = $this->createTransaction($deposit, $request->all());

    	if (! $transaction) {

    		$deposit->delete();

    		return response()->json([
    			'data' => null,
    			'status' => 'error',
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
    		'message' => 'You have successfully deposited into your account!!'
    	], 201);
    }

    public function bankDeposit(Request $request)
    {
    	$validator = Validator::make($request->all(), [
    		'trxRef' => 'required|unique:deposits',
    		'amount' => 'required|integer',
    		'payment_type' => 'required|string|max:255',
    		'payment_method' => 'required|string|max:255',
    		'status' => 'required|string|max:255'
    	]);

    	if ($validator->fails()) {
    		return response()->json([
    			'data' => $validator->errors(),
    			'status' => 'error',
    			'message' => 'Please fix the following errors'
    		], 422);
    	}

    	$deposit = $this->addDeposit($request->all());

    	if (! $deposit) {
    		return response()->json([
    			'data' => null,
    			'status' => 'error',
    			'message' => 'Oops we think something went wrong!'
    		], 500);
    	}

    	$transaction = $this->createTransaction($deposit, $request->all());

    	if (! $transaction) {

    		$deposit->delete();

    		return response()->json([
    			'data' => null,
    			'status' => 'error',
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
    			'status' => 'error',
    			'message' => 'Please fix the following errors'
    		], 422);
    	}

    	$member = User::where('staff_no', $request->member)->first();
    	$transaction = Transaction::where('code', $request->transaction)->first();

    	if (! ($member && $transaction)) {
    		return response()->json([
    			'data' => null,
    			'status' => 'error',
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

    	$transaction->transactionable->paid = true;
    	$transaction->transactionable->save();

    	$transaction->status = "paid";
    	$transaction->completed = true;

    	if (! $transaction->save()) {
    		return response()->json([
    			'data' => null,
    			'status' => 'error',
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
    		'trxRef' => $data['trxRef'],
    		'amount' => $data['amount'],
    		'paid' => $data['status'] === "success" ? true : false
    	]);
    }

    private function createTransaction(Deposit $deposit, array $data)
    {
    	$transaction = new Transaction;
    	$transaction->code = $data['trxRef'];
    	$transaction->type = $data['payment_method'];
    	$transaction->amount = $data['amount'];
    	$transaction->status = $data['status'] === "success" ? "paid" : "pending";
    	$transaction->completed = $data['payment_method'] === "online" ? true : false;

    	$deposit->transactions()->save($transaction);

    	return $transaction;
    }
}
