<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBrokerController;
use App\Http\Controllers\Admin\AdminEnterpriseController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AdminSubAdminController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Enterprise\ProjectController;
use App\Http\Controllers\User\AdviceRequestController;
use App\Http\Controllers\User\Auth\AuthController as UserAuthController;
use App\Http\Controllers\User\BookmarkController;
use App\Http\Controllers\User\BrokerController;
use App\Http\Controllers\User\EmailController;
use App\Http\Controllers\User\EnterpriseController;
use App\Http\Controllers\User\NewsController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\PostViewHistoryController;
use App\Http\Controllers\User\ReportController;
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
    Route::get('/detail-registration', [UserAuthController::class, 'getDetailBrokerRegistration']);
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
        Route::put('/update/{id}', [ProjectController::class, 'update']);
        Route::delete('/delete/{id}', [ProjectController::class, 'delete']);
    });
    Route::get('/', [UserProjectController::class, 'listProject']);
    Route::get('/list-favorite', [UserProjectController::class, 'listFavoriteProject']);
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
    Route::group(['middleware' => 'auth'], function () {
        Route::post('/review', [BrokerController::class, 'createReview']);
        Route::get('/list-review', [BrokerController::class, 'listReview']);
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/detail/{id}', [UserController::class, 'get'])->name('getUserDetail');
});

Route::group(['prefix' => 'review'], function () {
    Route::get('/avg-rating', [ReviewController::class, 'getAvgRating']);
    Route::post('/create-update', [ReviewController::class, 'createOrUpdate']);
});

Route::group(['prefix' => 'news'], function () {
    Route::get('/list-headline', [NewsController::class, 'listHeadline']);
    Route::get('/list', [NewsController::class, 'list']);
    Route::get('/detail/{id}', [NewsController::class, 'detail']);
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
    Route::group(['prefix' => 'notification'], function () {
        Route::get('/', [NotificationController::class, 'list']);
        Route::put('/mark-read/{id}', [NotificationController::class, 'markAsRead']);
        Route::put('/mark-read-list', [NotificationController::class, 'markAsReadList']);
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
        Route::delete('/cancle-registration/{id}', [AdviceRequestController::class, 'cancleRegistration']);
        Route::get('/broker/applied-request-list', [AdviceRequestController::class, 'listAppliedRequest']);
    });
});

Route::group(['prefix' => 'admin'], function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
    
        Route::group(['prefix' => 'auth'], function () {
            Route::get('/profile', [AdminAuthController::class, 'profile']);
            Route::put('/update-profile', [AdminAuthController::class, 'updateProfile']);
            Route::put('/update-password', [AdminAuthController::class, 'updatePassword']);
            Route::get('/logout', [AdminAuthController::class, 'logout']);
        });
        Route::group(['prefix' => 'post'], function () {
            Route::get('/', [AdminPostController::class, 'getList']);
            Route::get('/detail/{id}', [AdminPostController::class, 'get']);
            Route::get('/list-request', [AdminPostController::class, 'getListRequest']);
            Route::put('/reject-request/{id}', [AdminPostController::class, 'rejectRequest']);
            Route::put('/accept-request/{id}', [AdminPostController::class, 'acceptRequest']);
            Route::delete('/delete/{id}', [AdminPostController::class, 'delete']);
        });

        Route::group(['prefix' => 'project'], function () {
            Route::get('/', [AdminProjectController::class, 'getList']);
            Route::get('/detail/{id}', [AdminProjectController::class, 'get']);
            Route::get('/list-request', [AdminProjectController::class, 'getListRequest']);
            Route::put('/reject-request/{id}', [AdminProjectController::class, 'rejectRequest']);
            Route::put('/accept-request/{id}', [AdminProjectController::class, 'acceptRequest']);
            Route::delete('/delete/{id}', [AdminProjectController::class, 'delete']);
        });

        Route::group(['prefix' => 'subadmin'], function () {
            Route::get('/list', [AdminSubAdminController::class, 'list']);
            Route::put('/block/{id}', [AdminSubAdminController::class, 'blockAccount']);
            Route::put('/update-role/{id}', [AdminSubAdminController::class, 'updateRole']);
            Route::post('/create-account', [AdminSubAdminController::class, 'createSubAdmin']);
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/list', [AdminUserController::class, 'list']);
            Route::put('/block/{id}', [AdminUserController::class, 'blockAccount']);
        });

        Route::group(['prefix' => 'enterprise'], function () {
            Route::get('/list', [AdminEnterpriseController::class, 'list']);
            Route::put('/block/{id}', [AdminEnterpriseController::class, 'blockAccount']);
            Route::put('/reject-request/{id}', [AdminEnterpriseController::class, 'rejectRequest']);
            Route::put('/accept-request/{id}', [AdminEnterpriseController::class, 'acceptRequest']);
        });

        Route::group(['prefix' => 'broker'], function () {
            Route::get('/list', [AdminBrokerController::class, 'list']);
            Route::put('/block/{id}', [AdminBrokerController::class, 'blockAccount']);
            Route::put('/reject-request/{id}', [AdminBrokerController::class, 'rejectRequest']);
            Route::put('/accept-request/{id}', [AdminBrokerController::class, 'acceptRequest']);
        });

        Route::group(['prefix' => 'news'], function () {
            Route::get('/list', [AdminNewsController::class, 'list']);
            Route::get('/detail/{id}', [AdminNewsController::class, 'detail']);
            Route::post('/create', [AdminNewsController::class, 'create']);
            Route::put('/update/{id}', [AdminNewsController::class, 'update']);
            Route::delete('/delete/{id}', [AdminNewsController::class, 'delete']);
        });

        Route::group(['prefix' => 'role'], function () {
            Route::get('/', [AdminRoleController::class, 'getList']);
            Route::get('/list-option', [AdminRoleController::class, 'listOption']);
            Route::delete('/delete/{id}', [AdminRoleController::class, 'delete']);
            Route::post('/create', [AdminRoleController::class, 'create']);
            Route::put('/update/{id}', [AdminRoleController::class, 'update']);
        });

        Route::group(['prefix' => 'permission'], function () {
            Route::get('/', [AdminPermissionController::class, 'getList']);
        });

        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/overview', [DashboardController::class, 'overview']);
            Route::get('/list-review', [DashboardController::class, 'listReview']);
        });

        Route::group(['prefix' => 'report'], function () {
            Route::get('/', [AdminReportController::class, 'list']);
            Route::put('/processed/{id}', [AdminReportController::class, 'processed']);
            Route::delete('/delete/{id}', [AdminReportController::class, 'delete']);
        });
});

Route::post('/send-email', [EmailController::class, 'sendContactEmail']);
Route::post('/report/create', [ReportController::class, 'create']);







