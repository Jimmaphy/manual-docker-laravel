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

// The route for the home page
Route::get('/', function () {
    return view('welcome');
});

// The route for the github-accounts page
Route::resource('github-accounts', 'GithubAccountController');