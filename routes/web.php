<?php

use App\Http\Controllers\FirstTaskController;
use App\Http\Controllers\SecondTaskController;
use App\Http\Controllers\ThirdTaskController;
use Illuminate\Support\Facades\Route;

//route for the view pages directly
Route::view('/', 'pages.firstTask');
Route::view('/task-2', 'pages.secondTask');
Route::view('/task-3', 'pages.thirdTask.thirdTask');


// task-1
//route for first task insert form
Route::post('/multiple-image-upload', [FirstTaskController::class, 'multipleImageUpload']);

// task-2
//create user
Route::post('/create-user', [SecondTaskController::class, 'createUser'])->name('createUser');
//read user
Route::get('/read-user', [SecondTaskController::class, 'readUser'])->name('readUser');
//update user
Route::get('/update-user/{id}', [SecondTaskController::class, 'updateUser'])->name('updateUser');
Route::post('/update-user', [SecondTaskController::class, 'updateUserPost'])->name('updateUserPost');
//delete user
Route::get('/delete-user/{id}', [SecondTaskController::class, 'deleteUser'])->name('deleteUser');

// task-3
//login page view
Route::view('/login', 'pages.thirdTask.login');
Route::post('/login-form', [ThirdTaskController::class, 'userLogin'])->name('userLogin');

//registration page view
Route::view('/registration', 'pages.thirdTask.registration');
Route::post('/registration-form', [ThirdTaskController::class, 'userRegistration'])->name('userRegistration');

Route::view('/home', 'pages.thirdTask.dashboard');
//route for getting email and sending otp
Route::view('/forget-password', 'pages.thirdTask.forgetPassword');
Route::post('/send-otp-code', [ThirdTaskController::class, 'sendOTPCode'])->name('sendOTPCode');
//route for entering otp 
Route::view('/enter-otp', 'pages.thirdTask.enterOtp')->name('enterotp');
Route::post('/enter-password', [ThirdTaskController::class, 'enterPassword'])->name('enterPassword');



