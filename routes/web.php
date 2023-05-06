<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\LeaderBoardController::class,'index'])->name('leader_board');

Route::get('/members/delete/{id}',[\App\Http\Controllers\MemberController::class,'destroy'])->name('members.delete');
Route::resource('members',\App\Http\Controllers\MemberController::class);
