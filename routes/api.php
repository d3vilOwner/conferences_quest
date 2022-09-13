<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ConferenceController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\SubcategoryController;
use App\Http\Controllers\Api\UserController;
use App\Models\Subcategory;

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

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::prefix('/conference')->group( function () {
        Route::get('/{conference}', [ConferenceController::class, 'show'])->middleware('can:show conferences details');
        Route::post('/store', [ConferenceController::class, 'store'])->middleware('can:create conferences');
        Route::delete('/{conference}', [ConferenceController::class, 'destroy'])->middleware('can:delete conferences');
        Route::put('/{conference}', [ConferenceController::class, 'update'])->middleware('can:edit conferences');
        Route::post('/join/{conference}', [ConferenceController::class, 'joinConference']);
        Route::get('/join/{conference}', [ConferenceController::class, 'getJoined']);
        Route::delete('/join/{conference}', [ConferenceController::class, 'cancelJoining']);
    });
    
    Route::prefix('/report')->group(function () {
        Route::post('/store', [ReportController::class, 'store'])->middleware('can:create reports');
        Route::get('/index', [ReportController::class, 'index']);
        Route::get('/{report}', [ReportController::class, 'show']);
        Route::put('/update/{report}', [ReportController::class, 'update'])->middleware('can:update reports');
        Route::get('/presentation/download/{report}', [ReportController::class, 'download']);
        Route::delete('/delete/{report}', [ReportController::class, 'destroy'])->middleware('can:delete reports');
        Route::delete('/destroy/{report}/{conference_title}', [ReportController::class, 'deleteReport'])->middleware(('can:delete reports'));
    });
    
    Route::prefix('/comment')->group(function() {
        Route::post('/image', [CommentController::class, 'storeImage']);
        Route::post('/store', [CommentController::class, 'store']);
        Route::get('/fetch/{report}', [CommentController::class, 'index']);
        Route::put('/update/{comment}', [CommentController::class, 'update']);
    });

    Route::prefix('/category')->group(function() {
        Route::get('/fetch', [CategoryController::class, 'index']);
        Route::post('/store', [CategoryController::class, 'store'])->middleware('can:create categories');
        Route::put('/conferences/{categoryID}', [CategoryController::class, 'updateConference'])->middleware('can:update categories');
        Route::put('/reports/{categoryID}', [CategoryController::class, 'updateReport'])->middleware('can:update categories');
        Route::delete('/delete/{categoryID}', [CategoryController::class, 'destroy'])->middleware('can:delete categories');
        Route::get('/{categoryID}', [CategoryController::class, 'show']);
        Route::put('/update/{categoryID}', [CategoryController::class, 'update'])->middleware('can:update categories');
        
        Route::post('/subcategory/store', [SubcategoryController::class, 'store'])->middleware('can:create subcategories');
        Route::put('/subcategory/conferences/{categoryID}/{subcategoryID}', [SubcategoryController::class, 'updateConference'])->middleware('can:update subcategories');
        Route::put('/subcategory/reports/{categoryID}/{subcategoryID}', [SubcategoryController::class, 'updateReport'])->middleware('can:update subcategories');
        Route::get('/{categoryID}/subcategory/fetch', [SubcategoryController::class, 'index']);
        Route::get('/subcategory/{subcategoryID}', [SubcategoryController::class, 'show']);
    });

    Route::prefix('/user')->group(function() {
        Route::get('/get-auth', [UserController::class, 'show']);
        Route::put('/update/{userID}', [UserController::class, 'update']);
    });

    Route::prefix('/favorite')->group(function() {
        Route::post('/store', [FavoriteController::class, 'store']);
        Route::get('/show/{reportID}/{userID}', [FavoriteController::class, 'show']);
        Route::delete('/delete/{favoriteID}', [FavoriteController::class, 'destroy']);
        Route::get('/{user_id}', [FavoriteController::class, 'index']);
    });

    Route::prefix('/export')->group(function() {
        Route::get('/conferences', [ConferenceController::class, 'export']);
        Route::get('/reports', [ReportController::class, 'export']);
        Route::get('/listeners/{conferenceID}', [ConferenceController::class, 'exportListeners']);
        Route::get('/comments/{reportID}', [ReportController::class, 'exportComments']);
    });

});

Route::get('/joins', [ConferenceController::class, 'getAllJoins']);
Route::get('/conferences', [ConferenceController::class, 'index']);

Route::apiResources([
    'countries' => CountryController::class,
]);


//Route::controller(AuthController::class)->group(function(){
//    Route::post('login','login');
//    Route::post('register','register');
//});
