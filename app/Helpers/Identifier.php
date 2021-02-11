<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Agent;
use App\Models\Project;
use App\Models\Loan;
 

class Identifier
{
    
	protected $type, $identifier, $paymentType, $code;

	public function __construct($type, $identifier, $method, $code)
	{
		$this->type = $type;
		$this->identifier = $identifier;
		$this->paymentType = $method;
		$this->code = $code;
	}

	public function init()
	{
		return $this->normalise();
	}

	public function meth()
	{
		return $this->methodise();
	}

	protected function methodise()
	{
		switch ($this->paymentType) {
			case "project":
				return Project::where('code', $this->code)->first();
				break;
			
			default:
				return Loan::where('code', $this->code)->first();
				break;
		}
	}

	protected function normalise()
	{
		switch ($this->type) {
			case "third-party":
				return Agent::where('code', $this->identifier)->first();
				break;
			
			default:
				return User::where('staff_no', $this->identifier)->first();
				break;
		}
	}

}
