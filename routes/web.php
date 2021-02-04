<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

use App\Models\Loan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $loan = Loan::with('guarantors')->where('code', 'lnawIfdV1c')->first();

    $counter = $loan->guarantors()->wherePivot('status', 'approved')->get();


    // $counter = 0;
    // foreach ($loan->guarantors as $guarantor) {
    //     if ($guarantor->pivot->status === "approved") {
    //         $counter++;
    //     }
    // }

    dd(config('corporative.approvals'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
