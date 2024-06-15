<?php

use App\Http\Controllers\API\V2\AccuraMemberController;
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
    return $request->user();
});

// accura member routes
Route::get('accura/members/list', [AccuraMemberController::class, 'memberList'])            ->name('accura.member.list');
Route::get('accura/member/{id}', [AccuraMemberController::class, 'memberById'])             ->name('accura.member.by.id');
Route::get('ds/divisions/list', [AccuraMemberController::class, 'getDivisions'])            ->name('divisions.list');
Route::post('add/accura/member', [AccuraMemberController::class, 'addMember'])              ->name('add.accura.member');
Route::post('remove/accura/member/{id}', [AccuraMemberController::class, 'removeMember'])   ->name('remove.accura.member');
Route::post('update/accura/member/{id}', [AccuraMemberController::class, 'updateMember'])   ->name('update.accura.member');


