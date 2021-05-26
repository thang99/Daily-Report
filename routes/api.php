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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {

    Route::apiResource('reports', 'ManagerReportController');
    Route::prefix('reports')->group(function () {
        Route::post('/filterByDay', 'ManagerReportController@filterByDay');
        Route::post('/filterByMonth', 'ManagerReportController@filterByMonth');
        Route::post('/filterAll', 'ManagerReportController@filterAll');
        Route::post('/feedback','ManagerReportController@feedback');
    });
    Route::patch('reports/{id}', 'ManagerReportController@update');

    Route::apiResource('users', 'ManagerUserController');
    Route::put('/users/{id}/edit','ManagerUserController@updatePosition');
    Route::put('/users/remove/{id}','ManagerUserController@removeUserInDivision');
    Route::prefix('users/create')->group(function () {
        Route::get('/loadPosition', 'ManagerUserController@loadPosition');
        Route::get('/loadDivision', 'ManagerUserController@loadDivision');
        Route::get('/loadUser', 'ManagerUserController@loadUser');
        Route::put('/{id}', 'ManagerUserController@update');
    });
    Route::prefix('users')->group(function () {
        Route::put('/{id}', 'ManagerReportController@update');
        Route::post('/search', 'ManagerUserController@search');
    });

    Route::prefix('follows')->group(function () {
        Route::get('/{id}', 'FollowController@getUsersFollow');
        Route::post('/follow', 'FollowController@followUser');
        Route::post('/unfollow', 'FollowController@unFollowUser');
    });
    Route::get('suggests_follow/{id}', 'FollowController@suggestUsersFollow');

    Route::prefix('/user-reports')->group(function () {
//        Route::post('/store', 'ReportController@store')->name('user.report.store');
        Route::prefix('/list')->group(function () {
            Route::get('', 'ReportController@index')->name('user-reports.index');
            Route::post('', 'ReportController@store');
            Route::get('/loadManager', 'ReportController@loadManager');
            // Route::delete('/{id}','ReportController@delete');
            Route::get('/{id}','ReportController@edit');
        });
        Route::put('/{id}', 'ReportController@update')->name('user-reports.edit');
        Route::post('/searchByTitle', 'ReportController@searchByTitle');
        Route::post('/filterByDate', 'ReportController@searchByDate');
        Route::post('/searchByTitleAndDate', 'ReportController@searchReportByTitleAndDate');
        Route::get('/listReportsDivision','ReportController@getReportOfUsersSameDivision');
        Route::post('/searchReportBySender', 'ReportController@searchReportBySender');
        Route::post('/searchReportByDateSender','ReportController@searchReportByDateSender');
        Route::post('/searchReportByDateAndNameSender','ReportController@searchReportByDateAndNameSender');
    });

    //notification
    Route::post('/mark-as-read', 'NotificationController@markAsReadNotify')->name('noti.mark');
    Route::get('/notification-list', 'NotificationController@getListNotification')->name('noti.list');
    Route::get('/notification/unReadCount', 'NotificationController@countUnreadNotify')->name('noti.unread.count');

    Route::apiResource('/profiles', 'ProfileController')->except('update');
    Route::put('/profiles/password/{id}', 'ProfileController@updatePassword');
    Route::put('/profiles/{id}', 'ProfileController@updateProfile');
    Route::get('/loadFollow', 'ProfileController@loadFollow');
    Route::post('/followUser', 'ProfileController@followUser');
    Route::post('/unfollowUser', 'ProfileController@unfollowUser');
});


//admin
Route::group(['namespace' => 'Api', 'prefix' => 'admin'], function () {
    //position
    Route::apiResource('positions', 'PositionController');
    Route::get('positions-all', 'PositionController@getAllPosition');
    Route::post('positions-search', 'PositionController@postSearchPosition');
    Route::get('positions-all-no-paginate', 'PositionController@getAllPositionNoPaginate');

    //division
    Route::apiResource('divisions', 'DivisionController');
    Route::get('divisions-all', 'DivisionController@getAllDivision');
    Route::post('divisions-search', 'DivisionController@postSearchDivision');
    Route::get('divisions-all-no-condition', 'DivisionController@getAllDivisionNoCondition');
    Route::post('divisions-search-all', 'DivisionController@postSearchDivisionNoPaginate');

    //position-division
    Route::apiResource('positions-divisions', 'PositionDivisionController');
    Route::post('positions-divisions-search/{id}', 'PositionDivisionController@postSearch');
    Route::get('positions-divisions-all/{id}', 'PositionDivisionController@getAllPositionNoPaginate');
    Route::post('positions-divisions-search-all/{id}', 'PositionDivisionController@postSearchNoPaginate');

    //user
    Route::get('user-manager', 'UserController@getAllManager');
    Route::get('user-edit-manager/{id}', 'UserController@getEditManager');
    Route::apiResource('users', 'UserController');
    Route::put('user-change-pass/{id}', 'UserController@changePass');
    Route::post('user-search-paginate', 'UserController@postUserSearchPaginate');
    Route::get('user-all', 'UserController@getAllUser');
    Route::get('user-manager-division/{id}','UserController@getInfoManagerDivision');

    //user-division
    Route::get('user-division/{search}', 'UserDivisionController@getUserByDivision');
    Route::put('user-change-pass/{id}', 'UserController@changePass');
    Route::get('all-role-user', 'UserController@getAllRoleUser');
    Route::post('user-search', 'UserController@postUserSearch');

    //user-division
    Route::get('user-division/{search}', 'UserDivisionController@getUserByDivision');

    //user-report
    Route::get('user-report', 'ReportController@getReportLimit');
    Route::post('user-report-search', 'ReportController@postReportSearch');
    Route::get('/get-users', 'UserController@getAllUser');
    Route::get('/get-reports', 'ReportController@getAllReport');
});

// Route::get('list', 'ReportController@getDivisionReports')->name('user.report.division');
// Route::get('/{id}', 'ReportController@getReportUser')->name('user.report');
//Route::post('/store', 'ReportController@store')->name('user.report.store');
// Route::get('/{id}/edit', 'ReportController@edit')->name('user.report.edit');
// Route::put('/{id}/update', 'ReportController@update')->name('user.report.update');
// Route::delete('/{id}/delete', 'ReportController@delete')->name('user.report.delete');

