<?php

use App\Http\Controllers\VotingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
});
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/', [VotingController::class, 'store']);
});
Route::get('/', [VotingController::class, 'index']);
Route::get('/import', [VotingController::class, 'importJson']);
Route::get('/token', [VotingController::class, 'token']);
