<?php

use App\Http\Controllers\PostsApiController;
use App\Http\Controllers\AuthController;
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
//public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/posts', [PostsApiController::class, 'index']);
Route::get('/posts/{id}', [PostsApiController::class, 'show']);
Route::get('/posts/search/{title}', [PostsApiController::class, 'search']);



//PROTECTED routes
Route::group(['middleware' =>['auth:sanctum']], function () {
    Route::post('/posts', [PostsApiController::class, 'store']);
    Route::put('/posts/{id}', [PostsApiController::class, 'update']);
    Route::delete('/posts/{id}', [PostsApiController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


//Route::resource('/posts',PostsApiController::class);
// Route::get('/posts/search/{title}', [PostsApiController::class, 'search']);

// Route::get('/posts', [PostsApiController::class, 'index']);
// Route::post('/posts', [PostsApiController::class, 'store']);
// Route::put('/posts/{post}', [PostsApiController::class, 'update']);
// Route::delete('/posts/{post}', [PostsApiController::class, 'destroy']);
