<?php


namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Budget;

class BudgetHelperClass
{
    
	private $budget, $identifier, $amount;

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
		if ($this->budget = $this->getBudget() == null) {
			return false;
		}

		$balance = $this->budget->amount - $this->budget->heads()->sum('amount');
		return $balance >= $this->amount ? true : false;
	}

	private function getBudget()
	{
		$this->budget = Budget::find($this->identifier);
		return ($this->budget !== null && $this->budget->active == 1) ? $this->budget : null;
	}

}

