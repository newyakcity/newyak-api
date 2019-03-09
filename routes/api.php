<?php

use Illuminate\Http\Request;

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

Route::get('/posts', 'PostsController@search');

Route::get('/post/{id}', 'PostsController@get');
Route::get('/post/{id}/comments', 'commentsController@getPostComments');
Route::post('/post', 'PostsController@create');

Route::post('/comment', 'CommentsController@create');