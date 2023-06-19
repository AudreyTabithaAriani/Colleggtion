<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TransactionController;
// use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnimalController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

#Home
Route::get('/', [HomeController::class, 'index']);


#Login
Route::get('login', [LoginController::class, 'index']);

Route::get('auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('login/google', [LoginController::class, 'googleCallback']);
Route::get('logout', [LoginController::class, 'logout']);

#Transaction
Route::get('buy', [TransactionController::class, 'index']);
Route::post('sellCoins', [TransactionController::class, 'sellCoin']);
Route::post('buyCoins', [TransactionController::class, 'buyCoin']);
Route::post('deposit', [TransactionController::class, 'deposit']);
Route::post('withdraw', [TransactionController::class, 'withdraw']);

#Admin
// Route::get('admin', [AdminController::class, 'index']);

#Animals
Route::post('buyEgg', [AnimalController::class, 'buyEgg']);
Route::post('hatch', [AnimalController::class, 'hatch']);
Route::post('burn', [AnimalController::class, 'burn']);
Route::get('breed', [AnimalController::class, 'breedIndex']);
Route::post('breed', [AnimalController::class, 'breed']);

// Route::get('admin', [AdminController::class, 'index']);
// Route::post('admin', [AdminController::class, 'handleForm']);
