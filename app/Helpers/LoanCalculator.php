<?php


namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;

class LoanCalculator
{
	/**
	 *	Significant variables 
	 */
	protected $loan;

	protected $requests = [];
	protected $payables = [];
	protected $dues = [];

	public function __construct(Loan $loan, array $requests)
	{
		$this->loan = $loan;
		$this->requests = $requests;
	}

	public function init()
	{
		return $this->scheduler();
	}

	private function payable()
	{
		return $this->loan->amount + ($this->loan->amount * ($this->loan->loanCategory->interest / 100));
	}

	private function payment()
	{
		return round($this->payable() / $this->requests['restriction'], 2);
	}

	private function scheduler()
	{
		foreach ($this->normaliser() as $setter) {
			$this->dues[] = $setter . " : " . $this->payment();
		}

		return response()->json($this->dues);
	}

	private function paySetter($frequency)
	{
		for ($i = 0; $i < $this->requests['restriction']; $i++) {
			$this->payables[] = date('d F, Y', strtotime($this->starter() . '+' . $i . ' ' . $frequency));
		}

		return $this->payables;
	}

	private function normaliser()
	{
		switch ($this->loan->loanCategory->frequency) {
			case "annually":
				return $this->paySetter('years');
				break;
			
			default:
				return $this->paySetter('months');
				break;
		}
	}

	private function starter()
	{
		return Carbon::parse($this->requests['date']);
	}
}
