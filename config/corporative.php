<?php

return [
	'category' => [
		'loan' => 'Loan',
		'asset' => 'Asset',
        'shares' => 'Shares'
	],

	'loans' => [
		'payable' => [
			'salary' => 'Salary',
			'upfront' => 'Upfront',
			'contribution' => 'Contribution'
		],

		'frequency' => [
			'monthly' => 'Monthly',
			'annually' => 'Annually',
			'special' => 'Special',
			'rated' => 'Rated'
		],

		'approvals' => [
			'first' => 'treasurer',
			'second' => 'general-secretary',
			'third' => 'president'
		],
	],

	'services' => [
		'deactivate-account' => 'Deactivate Account',
		'liquidate-loan' => 'Liquidate Loan',
		'reset-password' => 'Reset Password',
		'alter-contribution-fee' => 'Alter Contribution Fee',
		'withdraw-from-contribution' => 'Withdraw From Contribution'
	],

	'payment' => [
		'types' => ['third-party', 'member', 'staff']
	],

	'superAdmin' => 'administrator',
];
