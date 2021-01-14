<?php


namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Expenditure;
use App\Models\User;

class LoanChecker 
{
	

	protected $category, $member, $value;

	public function __construct($category, $user, $value)
	{
		$this->category = $category;
		$this->member = $user;
		$this->value = $value;
	}


	private function balanceChecker() : bool
	{
		return $this->member->wallet->current * 2 >= $this->value;
	}


	private function expenditureChecker() : bool
	{
		return $this->value < $this->category->expenditure->balance;
	}


}
