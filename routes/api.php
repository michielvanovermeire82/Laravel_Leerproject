<?php


use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\Api\RestApiController;
use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/about', [AboutController::class, 'getAbout']);

Route::post('/v1/sum_numbers', [CalculatorController::class, 'getSum']);

Route::get('v1/test/visma/{uri}', [RestApiController::class, 'testVismaRestApi2']);




