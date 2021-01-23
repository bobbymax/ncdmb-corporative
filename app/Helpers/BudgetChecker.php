<?php


namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Category;
// use App\Models\Expenditure;
// use App\Models\User;
// use Carbon\Carbon;

class BudgetChecker
{

	protected $category, $amount;

	public function __construct(Category $category, $amount)
	{
		$this->category = $category;
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
		$this->amount * ($this->category->interest / 100) + $this->amount;
	}

	private function availableFunds()
	{
		$funds = $this->getCategoryExpenditureDiff() >= $this->category->limit;

		if (! $funds) {
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
		$limiter = $this->amount <= $this->category->limit;

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

	private function getCategoryExpenditureDiff()
	{
		return $this->getCategoryExpenditureTotal() - $this->getCategoryExpenditureBalance();
	}

	private function getCategoryExpenditureTotal()
	{
		return $this->category->expenditure->amount;
	}

	private function getCategoryExpenditureBalance()
	{
		return $this->category->expenditure->balance;
	}
}