<?php


namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\LoanCategory;
// use App\Models\Expenditure;
// use App\Models\User;
// use Carbon\Carbon;

class BudgetChecker
{

	protected $loanCategory, $amount;

	public function __construct(LoanCategory $loanCategory, $amount)
	{
		$this->loanCategory = $loanCategory;
		$this->amount = $amount;
	}

	public function init()
	{
		$availability = $this->availableFunds();
		$limit = $this->loanLimitCheck();
		$eligibility = $this->eligibility();

		return compact('availability', 'limit', 'eligibility');
	}

	private function computeInterest()
	{
		return $this->amount * ($this->loanCategory->interest / 100) + $this->amount;
	}

	private function availableFunds()
	{
		// $funds = $this->getCategoryExpenditureDiff() >= $this->category->limit;

		if ($this->getBalance() < $this->amount) {
			return response()->json([
				'data' => false,
				'status' => 'warning',
				'message' => 'Funds available cannot fund your loan!'
			], 403);
		}

		return response()->json([
			'data' => true,
			'status' => 'success',
			'message' => 'There are available funds for this loan!'
		], 200);
	}

	private function loanLimitCheck()
	{
		$limiter = $this->amount <= $this->loanCategory->limit;

		if (! $limiter) {
			return response()->json([
				'data' => false,
				'status' => 'warning',
				'message' => 'Loan amount requested is more than assigned loan amount for this loan category!'
			], 403);
		}

		return response()->json([
			'data' => true,
			'status' => 'success',
			'message' => 'Everything seems good!'
		], 200);
	}

	private function eligibility()
	{
		$eligible = $this->amount <= auth()->user()->wallet->current * 2;

		if (! $eligible) {
			return response()->json([
				'data' => false,
				'status' => 'warning',
				'message' => 'You are not eligible to access this loan amount!'
			], 403);
		}

		return response()->json([
			'data' => true,
			'status' => 'success',
			'message' => 'You are eligible!'
		], 200);
	}

	private function getBalance()
	{
		return $this->loanCategory->balance;
	}

	// private function getCategoryExpenditureTotal()
	// {
	// 	return $this->category->expenditure->amount;
	// }

	// private function getCategoryExpenditureBalance()
	// {
	// 	return $this->category->expenditure->balance;
	// }
}