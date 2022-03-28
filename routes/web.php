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
    // dd('working');

    $loan = Loan::find(7);

    dd($loan->sponsors->where('status', 'approved')->count());
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
