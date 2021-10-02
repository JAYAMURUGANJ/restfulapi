<?php

use App\Http\Controllers\PostsApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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


// get the loged user details after successfull login
Route::middleware('auth:sanctum')->get('/user',function(Request $request){
    return $request->user();
});


//creating new token for the particular login if the user is valide
Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

// for delete all token to the particular user after logout
Route::middleware('auth:sanctum')->get('/user/revoke',function(Request $request){

    $user = $request->user();
    $user->tokens()->delete();
    return "Tokens are deleted";
});



//Route::resource('/posts',PostsApiController::class);
// Route::get('/posts/search/{title}', [PostsApiController::class, 'search']);

// Route::get('/posts', [PostsApiController::class, 'index']);
// Route::post('/posts', [PostsApiController::class, 'store']);
// Route::put('/posts/{post}', [PostsApiController::class, 'update']);
// Route::delete('/posts/{post}', [PostsApiController::class, 'destroy']);
