<?php

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

// route to render the member list view
Route::get('/', function () {
    return view('members_list');
})->name('member.list');

// route to render the adding member  view
Route::get('/add/member', function () {
    return view('add_member');
})->name('add.member.view');

// route to render the edit member  view
Route::get('/edit/member/{id}', function () {
    return view('add_member');
})->name('edit.member.view');
