<?php


namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Expenditure;
use App\Models\User;
use Carbon\Carbon;

class LoanCalculator
{
	/**
	 *	Significant variables 
	 */
	protected $category, $member, $value, $message, $proposed;

	protected $sum = 0;

	protected $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

	protected $fee = [];

	public function __construct($category, $user, $value)
	{
		$this->category = $category;
		$this->member = $user;
		$this->value = $value;
	}

	public function existingLoan(): bool
	{
		return is_object($this->member->loans->first()) && $this->member->loans->first()->closed != 1;
	}

	public function balanceChecker(): bool
	{
		return $this->member->wallet->current * 2 >= $this->value;
	}

	public function expenditureChecker(): bool
	{
		return $this->value < $this->category->expenditure->balance;
	}

	private function remainingDaysInYear()
	{
		return now()->daysInYear - now()->dayOfYear;
	}

	private function splitValueInDays()
	{
		return $this->interestRatePlusValue() / $this->category->restriction;
	}

	private function monthlyDue()
	{
		// Check Current Month
		$current_month = $this->currentMonth();
		// Compare Month Values
		$months_section = $this->remainingMonths();
		// Slice
		
		// Check Restrictions
		// Compare Slice & Restrictions
		// If Slice < Restrictions (Restrictions - Slice)
		// Start from beginning after months have finished

		foreach (range(1, $this->category->restriction) as $month) {
			// $this->proposed = new Carbon($month); 
			// $due = $this->splitValueInDays() * $this->proposed->daysInMonth;

			$this->fee[] = round($this->splitValueInDays(), 2);

			$this->sum += $this->splitValueInDays();
		}

		return [$this->fee, round($this->sum, 2)];
	}

	private function currentMonth()
	{
		return now()->month;
	}

	private function remainingMonths()
	{
		return array_slice($this->months, $this->currentMonth() - 1);
	}

	private function interestRatePlusValue()
	{
		return $this->value * ($this->category->interest / 100) + $this->value;
	}

	public function init()
	{
		switch ($this->category->frequency) {
			case "annually":
				return $this->interestRatePlusValue();
				break;

			default:
				return $this->monthlyDue();
				break;
		}
	}
}
