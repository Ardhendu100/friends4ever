<?php

use App\Facades\Invoice;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\FileManagerItemsController;
use App\Http\Controllers\PageBuilderController;
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

Route::post('/login', [UserController::class, 'login']);
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');

Route::get('/page-builder', [PageBuilderController::class,'index']);
Route::post('/page-builder/save',[PageBuilderController::class,'save']);


//route for mailing
Route::get('/email',function(){
    
    return new WelcomeMail();
});
Route::get('filemanager', [FileManagerController::class, 'index']);

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
	\UniSharp\LaravelFilemanager\Lfm::routes();
	Route::get('/jsonitems', [FileManagerItemsController::class, 'getItems']);
    Route::get('/download', [FileManagerItemsController::class, 'download']);

});
