<?php

use App\Http\Controllers\User\Auth\AuthController as UserAuthController;
use App\Http\Controllers\User\BookmarkController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\PostViewHistoryController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\User\UserController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('register', [UserAuthController::class, 'register']);
    Route::get('logout', [UserAuthController::class, 'logout']);
    Route::post('forget-password', [UserAuthController::class, 'forgetPassword']);
    Route::post('reset-password', [UserAuthController::class, 'resetPassword']);
    Route::get('verify-email', [UserAuthController::class, 'verifyEmail']);
    // Route::post('refresh', 'AuthController@refresh');
    Route::get('profile', [UserAuthController::class, 'profile']);
    Route::group(['prefix' => 'account'], function () {
        Route::put('update-profile', [UserAuthController::class, 'updateProfile']);
        Route::put('update-password', [UserAuthController::class, 'updatePassword']);
        Route::put('delete-account', [UserAuthController::class, 'deleteAccount']);
    });
    
});

Route::get('unauth', [UserAuthController::class, 'unauth'])->name('unauth');
Route::group(['prefix' => 'post'], function () {
    Route::get('/detail/{id}', [PostController::class, 'get'])->name('getPostDetail');
    Route::get('/location', [PostController::class, 'locationRealEstate']);
    Route::get('/suggested-post', [PostController::class, 'suggestedPostByHistory']);
    Route::get('/list', [PostController::class, 'getList']);
    Route::get('/user/list', [PostController::class, 'listUserPost']);
    Route::group(['prefix' => 'history'], function () {
        Route::get('/', [PostViewHistoryController::class, 'listPostViewHistory']);
        Route::post('/create', [PostViewHistoryController::class, 'createHistory']);
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/detail/{id}', [UserController::class, 'get'])->name('getUserDetail');
});

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'post'], function () {
        Route::post('/create', [PostController::class, 'create'])->name('createPost');
        Route::put('/update/{id}', [PostController::class, 'update']);
        Route::get('/list-owner', [PostController::class, 'listOwnerPost']);
        Route::delete('/delete/{id}', [PostController::class, 'delete']);
    });
    Route::group(['prefix' => 'bookmark'], function () {
        Route::post('/create', [BookmarkController::class, 'createOrDelete'])->name('bookmark');
        Route::get('/', [BookmarkController::class, 'listPost'])->name('listBookmark');
    });
});

Route::get('/post', [PostController::class, 'getList']);
Route::post('/suggested-post-filter', [PostController::class, 'suggestedPostByFilter']);

Route::get('/list-request', [AdminPostController::class, 'getListRequest']);
Route::put('/reject-request/{id}', [AdminPostController::class, 'rejectRequest']);
Route::put('/accept-request/{id}', [AdminPostController::class, 'acceptRequest']);







