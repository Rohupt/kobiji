<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/logout', 'HomeController@logout')->name('logout');

    Route::middleware(['admin.only'])->group(function () {
        Route::get('subjects/{subject}/edit', 'SubjectController@edit')->name('subjects.edit');
        Route::put('subjects/{subject}', 'SubjectController@update')->name('subjects.update');
    });

    Route::middleware(['manager.only'])->group(function () {
        Route::get('/subjects/grading', 'SubjectController@grading')->name('subjects.grading');
        Route::get('/subjects/grading/{subject}', 'SubjectController@gradingDetail')->name('subjects.grading.detail');
        Route::put('/subjects/grading/{subject}', 'SubjectController@gradingSubmit')->name('subjects.grading.submit');

        Route::get('/subjects/registration', 'SubjectController@registration')->name('subjects.registration');
        Route::get('/subjects/registration/{subject}', 'SubjectController@registrationDetail')->name('subjects.registration.detail');
        Route::put('/subjects/registration/{subject}', 'SubjectController@registrationSubmit')->name('subjects.registration.submit');

        Route::get('/subjects', 'SubjectController@index')->name('subjects.index');
        Route::get('subjects/create', 'SubjectController@create')->name('subjects.create');
        Route::post('subjects', 'SubjectController@store')->name('subjects.store');
        Route::get('subjects/{subject}', 'SubjectController@show')->name('subjects.show');

        Route::get('/users/view/{role}', 'UserController@index')->name('users.index');
        Route::get('/users/toggle/{user}', 'UserController@toggle')->name('users.toggle');
    });

    Route::resource('users', UserController::class)->except(['index']);
    Route::get('/users/edit-password/{user}', 'UserController@editPassword')->name('users.edit.password');
    Route::put('/users/update-password/{user}', 'UserController@updatePassword')->name('users.update.password');
});


