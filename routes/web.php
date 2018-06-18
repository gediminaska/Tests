<?php

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

Route::get('/', 'PagesController@welcome')->name('welcome');
Route::post('/{id}', ['as' => 'attempt.begin', 'uses' => 'AttemptsController@begin']);

Route::get('/attempt/{token}', ['as' => 'attempt.show', 'uses' => 'AttemptsController@show']);
Route::get('/attempt/{token}/finished', ['as' => 'attempt.finished', 'uses' => 'AttemptsController@finished']);
Route::get('/attempt/{token}/results', ['as' => 'attempt.results', 'uses' => 'AttemptsController@results']);
Route::post('/attempt/{token}/reset', ['as' => 'attempt.reset', 'uses' => 'AttemptsController@reset']);
Route::post('/attempt/{token}', ['as' => 'attempt.submit', 'uses' => 'AttemptsController@submit']);
Route::post('/attempt/{token}/save', ['as' => 'attempt.save', 'uses' => 'AttemptsController@saveScore']);

