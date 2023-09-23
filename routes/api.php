<?php

use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\BookmarkController;
use App\Http\Controllers\User\PostController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/getPostType', [PostController::class, 'getPostTypes']);

Route::post('/create-post', [PostController::class, 'create'])->name('createPost');
Route::get('/post-detail/{id}', [PostController::class, 'get'])->name('getPostDetail');
Route::post('/bookmark', [BookmarkController::class, 'createOrDelete'])->name('bookmark');
Route::post('/list-bookmark', [BookmarkController::class, 'listPost'])->name('listBookmark');
Route::put('/account/updateProfile/{id}', [AccountController::class, 'updateProfile'])->name('updateProfile');
Route::put('/account/update-password/{id}', [AccountController::class, 'updatePassword'])->name('updatePassword');
Route::put('/account/delete-account/{id}', [AccountController::class, 'deleteAccount'])->name('deleteAccount');








