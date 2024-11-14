<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Login.login');
});
Route::post('login',[LoginController::class,'login'])->name('login');
Route::get('loginpage',[LoginController::class,'loginpage'])->name('loginpage');
Route::get('registerpage',[LoginController::class,'registerpage'])->name('registerpage');
Route::post('register',[LoginController::class,'register'])->name('register');
Route::post('logout',[LoginController::class,'logout'])->name('logout');
Route::post('confirmation',[LoginController::class,'confirmation'])->name('confirmation');
Route::get('confirmation',[LoginController::class,'confirmation']);

Route::get('post',[PostController::class,'post'])->name('post');
Route::get('postcreate',[PostController::class,'postcreate'])->name('postcreate');
Route::post('poststore',[PostController::class,'store'])->name('poststore');
Route::get('postedit/{post}',[PostController::class,'postedit'])->name('postedit');
Route::get('postdelete/{post}',[PostController::class,'delete'])->name('postdelete');
Route::post('postupdate/{post}',[PostController::class,'update'])->name('postupdate');