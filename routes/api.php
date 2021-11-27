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

//login registeration 
Route::post('/register', [AuthController::class, 'register']);
//login user and creating token
Route::post('/login', [AuthController::class, 'login']);
//getting all the users details
Route::post('/users', [AuthController::class, 'getAllUsers']);






//PROTECTED routes
Route::group(['middleware' =>['auth:sanctum']], function () {

    //getting specific user by post id
    Route::get('/findUserByPost', [PostsApiController::class, 'findUserByPost']);

    //getting specific user posts
    Route::get('/userbasedposts', [AuthController::class, 'userbasedposts']);

    //getting posts list like a pagination with limit
    Route::get('/posts', [PostsApiController::class, 'pagniatedList']);

    //search posts with title or content and id
    Route::get('/posts/search/{Title-or-Content}', [PostsApiController::class, 'searchByTitle']);
    Route::get('/posts/search/{id}', [PostsApiController::class, 'searchById']);
   

    //basic CRUD operations
    Route::get('/posts', [PostsApiController::class, 'getAllPosts']);
    Route::post('/posts', [PostsApiController::class, 'store']);
    Route::put('/posts/{id}', [PostsApiController::class, 'update']);
    Route::delete('/posts/{id}', [PostsApiController::class, 'destroy']);

    //logout the current user and delete the current user current token
    Route::post('/logout', [AuthController::class, 'logout']);
});



//getting image from the public 
Route::get('/get/image',[PostsApiController::class, 'getImage']);
Route::Post('/store/image',[PostsApiController::class, 'storeImage']);

