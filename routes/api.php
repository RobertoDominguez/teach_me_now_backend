<?php

use App\Http\Controllers\MemoController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\SubscriptionAPIController;
use App\Http\Controllers\TeachController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
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

Route::prefix('teacher')->group(function () {
    Route::post('/login', [TeacherController::class, 'login']);
    Route::post('/signup', [TeacherController::class, 'signup']);

    Route::middleware(['auth:sanctum', 'ability:teacher'])->group(function () {
        Route::post('/logout', [TeacherController::class, 'logout']);
        Route::post('/logout/all', [TeacherController::class, 'logoutAll']);

        Route::post('/update/image',[TeacherController::class,'updateImage']);
        Route::post('/update',[TeacherController::class,'update']);
        Route::post('/update/password',[TeacherController::class,'updatePassword']);

        Route::post('/study/index',[StudyController::class,'index']);
        Route::post('/study/store',[StudyController::class,'store']);
        Route::post('/study/destroy',[StudyController::class,'destroy']);

        Route::post('/teach/index',[TeachController::class,'index']);
        Route::post('/teach/store',[TeachController::class,'store']);
        Route::post('/teach/destroy',[TeachController::class,'destroy']);

        Route::prefix('subscription')->group(function () {
            Route::middleware('subscription')->group(function () {
                Route::post('days', [SubscriptionAPIController::class,'days']);
                Route::post('index', [SubscriptionAPIController::class,'index']);
            });
            Route::post('store', [SubscriptionAPIController::class,'store']);
        });
    });
});


Route::prefix('user')->group(function () {
    Route::post('universities', [UserController::class, 'universities']);
    Route::post('schools', [UserController::class, 'schools']);
    Route::post('subjects', [UserController::class, 'subjects']);
    Route::post('teachers', [UserController::class, 'teachers']);

    Route::post('academics', [UserController::class, 'academics']);
    Route::post('studies', [UserController::class, 'studies']);
    Route::post('teaches', [UserController::class, 'teaches']);
    Route::post('advertisings', [UserController::class, 'advertisings']);
    Route::post('system', [UserController::class, 'system']);
});
