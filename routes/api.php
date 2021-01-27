<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
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
Route::post('grant/member/loan', 'LoanController@grantStat');

// Loan Checker
Route::post('category/budget/check', 'ExpenditureController@budgetChecker');


Route::post('login', 'LoginController@login');

Route::get('transactions/filter/{type}', 'TransactionController@transactionType');

// Approval endpoint
Route::apiResource('approvals', 'ApprovalController');
// Route::post('approvals/accept', 'ApprovalController@acceptApproval');
// Route::post('approvals/reject', 'ApprovalController@rejectApproval');