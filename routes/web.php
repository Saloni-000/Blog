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

Route::get('/',[\App\Http\Controllers\welcomeController::class,'index'])->name('home');
Route::get('/blog',[\App\Http\Controllers\blogController::class,'index'])->name('blog');

Route::get('/about', function(){
    return view('about');
})->name('about');
Route::get('/contact',[\App\Http\Controllers\contactController::class,'index'])->name('contact');


//to create blog post
//adding middle ware to avoid access through private mode
Route::get('/blog/create',[\App\Http\Controllers\blogController::class,'create'])->name('blog.create');
//->middleware(auth());



//to show single post but place it after default ones like /create so that route precedance does not occur
Route::get('/blog/{post:slug}',[\App\Http\Controllers\blogController::class,'show'])->name('single-post');

//to edit single-post
Route::get('/blog/{post}/edit',[\App\Http\Controllers\blogController::class,'edit'])->name('blog.edit');

//to update single-post
Route::put('/blog/{post}',[\App\Http\Controllers\blogController::class,'update'])->name('blog.update');

//to update single-post
Route::delete('/blog/{post}',[\App\Http\Controllers\blogController::class,'destroy'])->name('blog.destroy');


//to store blog post

Route::post('/blog',[\App\Http\Controllers\blogController::class,'store'])->name('blog.store');

//Category resource Controller
Route::resource('/categories',\App\Http\Controllers\CategoryController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
