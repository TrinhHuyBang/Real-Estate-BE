<?php

use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Enterprise\ProjectController;
use App\Http\Controllers\User\AdviceRequestController;
use App\Http\Controllers\User\Auth\AuthController as UserAuthController;
use App\Http\Controllers\User\BookmarkController;
use App\Http\Controllers\User\BrokerController;
use App\Http\Controllers\User\EnterpriseController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\PostViewHistoryController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserProjectController;
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
    Route::post('enterprise-register', [UserAuthController::class, 'enterpriseRegister']);
    Route::post('broker-register', [UserAuthController::class, 'brokerRegister']);
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

Route::group(['prefix' => 'project'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::post('/create', [ProjectController::class, 'create']);
        Route::get('/list-owner', [ProjectController::class, 'listOwnerProject']);
    });
    Route::get('/', [UserProjectController::class, 'listProject']);
    Route::get('/list-project-options', [UserProjectController::class, 'listProjectOptions']);
    Route::get('/detail/{id}', [UserProjectController::class, 'get']);
});

Route::group(['prefix' => 'enterprise'], function () {
    Route::get('/list-search', [EnterpriseController::class, 'getList']);
    Route::get('/detail/{id}', [EnterpriseController::class, 'getDetail']);

});

Route::group(['prefix' => 'broker'], function () {
    Route::get('/list', [BrokerController::class, 'getList']);
    Route::get('/detail/{id}', [BrokerController::class, 'getDetail']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/detail/{id}', [UserController::class, 'get'])->name('getUserDetail');
});

Route::group(['prefix' => 'review'], function () {
    Route::get('/avg-rating', [ReviewController::class, 'getAvgRating']);
    Route::post('/create-update', [ReviewController::class, 'createOrUpdate']);
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
    Route::group(['prefix' => 'advice-request'], function () {
        Route::get('/', [AdviceRequestController::class, 'getListRequest']);
        Route::get('/list-owner', [AdviceRequestController::class, 'getListOwnerRequest']);
        Route::post('/create', [AdviceRequestController::class, 'createRequest']);
        Route::put('/delete/{id}', [AdviceRequestController::class, 'deleteRequest']);
        Route::put('/update/{id}', [AdviceRequestController::class, 'updateRequest']);
        Route::post('/broker-apply', [AdviceRequestController::class, 'apply']);
        Route::get('/detail/{id}', [AdviceRequestController::class, 'detail']);
        Route::get('/broker-accepted/{id}', [AdviceRequestController::class, 'getBrokerAccepted']);
        Route::get('/list-broker-applied/{id}', [AdviceRequestController::class, 'listBrokerApplied']);
        Route::put('/delete-broker', [AdviceRequestController::class, 'deleteBroker']);
        Route::put('/accept-broker', [AdviceRequestController::class, 'acceptBroker']);
        Route::get('/broker/applied-request-list', [AdviceRequestController::class, 'listAppliedRequest']);
    });
});

Route::get('/post', [PostController::class, 'getList']);
Route::post('/suggested-post-filter', [PostController::class, 'suggestedPostByFilter']);

Route::get('/list-request', [AdminPostController::class, 'getListRequest']);
Route::put('/reject-request/{id}', [AdminPostController::class, 'rejectRequest']);
Route::put('/accept-request/{id}', [AdminPostController::class, 'acceptRequest']);







