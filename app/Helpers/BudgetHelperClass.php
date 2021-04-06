<?php


namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Budget;

class BudgetHelperClass
{

	private $budget, $identifier, $amount;

	const BNF = "not found";
	const AIH = "amount not valid";

	public function __construct($code, $amount)
	{
		$this->identifier = $code;
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

		$accumulated = $this->amount + $this->budget->heads->sum('amount');
		if (! ($this->setBudget()->amount >= $accumulated)) {
		    return static::AIH;
        }

		return true;
	}

	private function setBudget()
	{
		return $this->budget = $this->getBudget();
	}

	private function getBudget()
	{
		$this->budget = Budget::find($this->identifier);
		return ($this->budget !== null && $this->budget->active == 1) ? $this->budget : static::BNF;
	}

}

