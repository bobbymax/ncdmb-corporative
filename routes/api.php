<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['cors']], function () {
    Route::apiResource('members', 'MemberController');
    Route::apiResource('budgets', 'BudgetController');
    Route::apiResource('expenditures', 'ExpenditureController');
    Route::apiResource('categories', 'CategoryController');
    Route::apiResource('groups', 'GroupController');
    Route::apiResource('guarantors', 'GuarantorController');
    Route::apiResource('investments', 'InvestmentController');
    Route::apiResource('loans', 'LoanController');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('schedules', 'ScheduleController');
    Route::apiResource('permissions', 'PermissionController');
    Route::apiResource('services', 'ServiceController');
    Route::apiResource('specifications', 'SpecificationController');
    Route::apiResource('c', 'ContributionController');
    Route::apiResource('transactions', 'TransactionController');
    Route::apiResource('wallets', 'WalletController');
});

Route::post('login', [LoginController::class, 'login']);