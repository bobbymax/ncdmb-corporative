<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('loans/{loan}/calculator', 'ExpenditureController@loanCalculator');

Route::get('dashboard/details', 'DashboardController@index');
Route::post('get/transactions', 'DashboardController@adminDisplay');

// Payment Endpoints
Route::post('online/deposit', 'PaymentController@onlineDeposit');
Route::post('bank/deposit', 'PaymentController@bankDeposit');
Route::post('verify/member/payment', 'PaymentController@verifyPayment');


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
Route::apiResource('deposits', 'DepositController');
Route::apiResource('agents', 'AgentController');
Route::apiResource('projects', 'ProjectController');

// URL
Route::post('assign/member/role', 'RoleController@addMember');
Route::post('grant/member/loan', 'LoanController@grantStat');

// Loan Checker
Route::post('category/budget/check', 'ExpenditureController@budgetChecker');


Route::post('login', 'LoginController@login');

// Route::get('transactions/filter/{type}', 'TransactionController@transactionType');
Route::get('transactions/filter/{type}', 'DashboardController@display');

// Approval endpoint
Route::apiResource('approvals', 'ApprovalController');
Route::post('approval/levels', 'ApprovalController@approveLoan');

// update membership number
Route::prefix('members/membership')->group(function () {
    Route::get('/generate', 'MemberController@generateNumber');
    Route::patch('/assign', 'MemberController@assignNumber');
});

// Dashboard endpoint
Route::get('dashboard/all', 'DashboardController@index');
Route::get('dashboard', 'DashboardController@userDashboard');

Route::get('loan/approvals','LoanController@loanApprovalList');

// Route::post('notification/message', 'NotificationController@message');
Route::post('notification/message', function () {
    return NotificationController::message(['+2349031892712'], 'hello');
});

Route::post('budgets/status/{status}', 'BudgetController@status');

// Route::fallback(function(){
//     return response()->json([
//         'message' => 'Page Not Found. If error persists, contact info@ncdmb.com'], 404);
// });
