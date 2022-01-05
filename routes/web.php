<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdvertisingController;
use App\Http\Controllers\UniversityController;
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

Route::get('/login',[AdministratorController::class,'loginView'])->name('login.view')->middleware('guest');
Route::post('/login',[AdministratorController::class,'login'])->name('login')->middleware('guest');

Route::middleware(['auth',])->group(function () {
    Route::get('/dashboard',[AdministratorController::class,'dashboard'])->name('dashboard');

    Route::post('/logout',[AdministratorController::class,'logout'])->name('logout');

    Route::get('/subject/index',[SubjectController::class,'index'])->name('subject.index');
    Route::get('/subject/create',[SubjectController::class,'create'])->name('subject.create');
    Route::post('/subject/store',[SubjectController::class,'store'])->name('subject.store');
    Route::get('/subject/edit/{subject}',[SubjectController::class,'edit'])->name('subject.edit');
    Route::post('/subject/update/{subject}',[SubjectController::class,'update'])->name('subject.update');
    Route::post('/subject/destroy/{subject}',[SubjectController::class,'destroy'])->name('subject.destroy');

    Route::get('/university/index',[UniversityController::class,'index'])->name('university.index');
    Route::get('/university/create',[UniversityController::class,'create'])->name('university.create');
    Route::post('/university/store',[UniversityController::class,'store'])->name('university.store');
    Route::get('/university/edit/{university}',[UniversityController::class,'edit'])->name('university.edit');
    Route::post('/university/update/{university}',[UniversityController::class,'update'])->name('university.update');
    Route::post('/university/destroy/{university}',[UniversityController::class,'destroy'])->name('university.destroy');

    Route::get('/school/index',[SchoolController::class,'index'])->name('school.index');
    Route::get('/school/create',[SchoolController::class,'create'])->name('school.create');
    Route::post('/school/store',[SchoolController::class,'store'])->name('school.store');
    Route::get('/school/edit/{school}',[SchoolController::class,'edit'])->name('school.edit');
    Route::post('/school/update/{school}',[SchoolController::class,'update'])->name('school.update');
    Route::get('/school/subjects/{school}',[SchoolController::class,'subjects'])->name('school.subjects');
    Route::post('/school/subjects/update/{school}',[SchoolController::class,'updateSubjects'])->name('school.subjects.update');
    Route::post('/school/destroy/{school}',[SchoolController::class,'destroy'])->name('school.destroy');

    Route::get('/subscription/all',[SubscriptionController::class,'all'])->name('subscription.all');
    Route::get('/subscription/index',[SubscriptionController::class,'index'])->name('subscription.index');
    Route::get('/subscription/show/{subscription}',[SubscriptionController::class,'show'])->name('subscription.show');
    Route::post('/subscription/accept/{subscription}',[SubscriptionController::class,'accept'])->name('subscription.accept');
    Route::post('/subscription/reject/{subscription}',[SubscriptionController::class,'reject'])->name('subscription.reject');

    Route::get('/advertising/index',[AdvertisingController::class,'index'])->name('advertising.index');
    Route::get('/advertising/create',[AdvertisingController::class,'create'])->name('advertising.create');
    Route::post('/advertising/store',[AdvertisingController::class,'store'])->name('advertising.store');
    Route::get('/advertising/edit/{advertising}',[AdvertisingController::class,'edit'])->name('advertising.edit');
    Route::post('/advertising/update/{advertising}',[AdvertisingController::class,'update'])->name('advertising.update');
    Route::post('/advertising/destroy/{advertising}',[AdvertisingController::class,'destroy'])->name('advertising.destroy');

    Route::get('/subscription/teacher/{teacher}',[SubscriptionController::class,'showTeacher'])->name('subscription.teacher.show');
});
