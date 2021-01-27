<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

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
    // return Hash::make(123456);

    // $car = range(1, 100000);

    // for ($i = 1; in_array($i, $car); $i++);
    // 	return $i;
    $S = "0 - 22 1985--324";
    $strip = preg_replace("/[^\d]/","",$S);

    if(strlen($strip) >= 2) {
       return preg_replace("/^a?(\d{3})(\d{3})(\d{3})(\d{3})(\d{2})$/", "$1-$2-$3-$4-$5", $strip);
    }
	
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
