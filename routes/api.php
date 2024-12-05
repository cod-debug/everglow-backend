<?php

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
$version = "v1";

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix($version)->group(function(){
    Route::prefix('moodboard')->group(function(){
        Route::post('', 'MoodBoardController@postMood');
        Route::get('count', 'MoodBoardController@getMoodCount');
    });
    
    Route::prefix('gallery')->group(function(){
        Route::get('', 'PostController@getPosts');
        Route::post('upload', 'PostController@upload');
    });
    
    Route::prefix('session-comment')->group(function(){
        Route::get('', 'SessionCommentController@getComment');
        Route::post('upload', 'SessionCommentController@saveComment');
    });
});
