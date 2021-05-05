<?php


namespace App\Helpers;

use App\Models\BudgetHead;
use Illuminate\Support\Str;

class BudgetHelperClass
{

	private $budget, $identifier, $amount;

	const BNF = "not found";
	const AIH = "amount not valid";
	const POS = "everything looks good";

	public function __construct($budgetId, $amount)
	{
		$this->identifier = $budgetId;
		$this->amount = $amount;
	}

	public function init()
	{
		return $this->balanceChecker();
	}

	private function balanceChecker()
	{
		if ($this->setBudget() === static::BNF) {
			return static::BNF;
		}

		if (! ($this->setBudget()->fund->actual_balance >= $this->amount)) {
		    return static::AIH;
        }

		return static::POS;
	}

	private function setBudget()
	{
		return $this->budget = $this->getBudget();
	}

	private function getBudget()
	{
	    return BudgetHead::find($this->identifier);
	}

}

