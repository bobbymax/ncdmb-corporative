<?php


namespace App\Helpers;


use Carbon\Carbon;


class MonthSpliter
{

	protected $date = "26 January, 2021";


	protected $payables = [];



	public function splitMonths()
	{
		for ($i = 0; $i < 36; $i++) {
			$this->payables[] = date('d F, Y', strtotime($this->date . '+' . $i . ' months'));
		}

		return $this->payables;
	}

}
