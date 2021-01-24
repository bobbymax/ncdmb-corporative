<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Helpers\MonthSpliter;
use App\Models\Category;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tests', function() {
	// $category = Category::where('label', 'regular-loan')->first();

	// $months = (new LoanCalculator($category))->monthsy();

	// dd($months);

	// dd(date('Y', strtotime('+1 year')));
	// dd(Carbon::parse(18));

	dd((new MonthSpliter)->splitMonths());
});

Route::post('loans/{loan}/calculator', 'ExpenditureController@loanCalculator');

Route::apiResource('members', 'MemberController');
Route::apiResource('budgets', 'BudgetController');
Route::apiResource('expenditures', 'ExpenditureController');
Route::apiResource('categories', 'CategoryController');
Route::apiResource('groups', 'GroupController');
Route::apiResource('guarantors', 'GuarantorController');
Route::apiResource('investments', 'InvestmentController');
Route::apiResource('loans', 'LoanController');
Route::apiResource('schedules', 'ScheduleController');
Route::apiResource('permissions', 'PermissionController');
Route::apiResource('roles', 'RoleController');
Route::apiResource('services', 'ServiceController');
Route::apiResource('specifications', 'SpecificationController');
Route::apiResource('contributions', 'ContributionController');
Route::apiResource('transactions', 'TransactionController');
Route::apiResource('wallets', 'WalletController');

// URL
Route::post('assign/member/role', 'RoleController@addMember');

// Loan Checker
Route::post('category/budget/check', 'ExpenditureController@budgetChecker');


Route::post('login', 'LoginController@login');
