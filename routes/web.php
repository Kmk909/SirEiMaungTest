<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

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

Route::get('/', [ArticleController::class,'index']);

Route::get('/articles',[ArticleController::class,'index']);

Route::get('/articles/details',[ArticleController::class,'details'])->name('article.details');

Route::get('/articles/details/{id}',[ArticleController::class,'detail']);

Route::get('/articles/more',function(){
    return redirect()->route('article.details');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/articles/add',[ArticleController::class,'add']);
Route::post('/articles/add',[ArticleController::class,'create']);
Route::get('/articles/delete/{id}',[ArticleController::class,'delete']);