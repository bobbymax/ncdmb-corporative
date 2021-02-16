<?php

namespace App\Http\Controllers;

use App\Models\LoanCategory;
use App\Models\Loan;
use Illuminate\Http\Request;
use App\Helpers\LoanCalculator;
use App\Helpers\BudgetChecker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ExpenditureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function budgetChecker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|integer',
            'amount' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => $validator->errors(),
                'status' => 'error',
                'message' => 'Please fix these errors:'
            ], 505);
        }

        $loanCategory = LoanCategory::find($request->category);

        if (! $loanCategory) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This input was invalid'
            ], 422);
        }

        $results = (new BudgetChecker($loanCategory, $request->amount))->init();

        return response()->json([
            'data' => $results,
            'status' => 'success',
            'message' => 'Data collection!'
        ], 200);
    }

    public function loanCalculator(Request $request, $loan)
    {
        $loan = Loan::where('code', $loan)->first();

        if (! $loan) {
            return response()->json([
                'data' => null,
                'status' => 'error',
                'message' => 'This input was invalid'
            ], 404);
        }

        $values = (new LoanCalculator($loan, $request->all()))->init();

        return response()->json([
            'data' => $values,
            'status' => 'success',
            'message' => 'Schedule done successfully!'
        ], 200);
    }
}
