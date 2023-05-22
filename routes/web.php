<?php

use App\Facades\Invoice;
use App\Http\Controllers\UserController;
use App\Mail\WelcomeMail;
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

Route::get('/', [UserController::class, 'allUsers']);
Route::get('/users/{user}', [UserController::class, 'showUser'])->name('user.show');


//route for mailing
Route::get('/email',function(){
    return new WelcomeMail();
});
