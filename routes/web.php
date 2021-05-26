<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('/users', 'UserController@index');
Route::get('/roles', 'Admin\RoleController@index')->name('roles.index');
Route::get('roles/store', 'Admin\RoleController@store')->name('roles.store');
Route::get('roles/user', 'Admin\RoleController@giveRoleUser')->name('roles.user');
Auth::routes();
Route::group(['middleware' => 'auth',], function () {

    Route::get('/friends', 'FollowController@index')->name('user.friend');
    Route::get('/suggests', 'FollowController@suggestUsersFollow')->name('user.suggest');
    Route::get('notification', 'SendNotification@create')->name('notification.create');
    Route::post('notification', 'SendNotification@store')->name('notification.store');

    Route::redirect('/', '/home');
    Route::get('/home', 'HomeController@index')->name('home.index');

    Route::group(['namespace' => 'Admin', 'middleware' => ['role:admin'], 'prefix' => 'admin'], function () {

        Route::resource('divisions', 'DivisionController');
        Route::resource('manager-users', 'UserController');

        Route::resource('positions', 'PositionController');
        Route::resource('position-division', 'PositionDivisionController');
        Route::resource('user-division', 'UserDivisionController');
        Route::get('user-report', 'UserReportController@index')->name('user-report.index');
    });

    Route::group(['namespace' => 'User', 'middleware' => ['role:user']], function () {
        Route::get('/user-reports/list', 'ReportController@index')->name('user-reports.index');
        Route::get('/user-reports/{id}/edit', 'ReportController@edit')->name('user-reports.edit');
        Route::get('/user-reports/{id}', 'ReportController@show')->name('user-reports.show');
        Route::get('/user-report/listReports','ReportController@showReportDivision')->name('report-division');
    });

    Route::group(['namespace' => 'Manager', 'middleware' => ['role:manager'], 'prefix' => 'manager'], function () {
        Route::resource('reports', 'ReportController');
        Route::resource('users', 'UserController');
    });

    
    Route::resource('profiles', 'ProfileController');
});


Route::group(['namespace' => 'Auth'], function () {
    //social
    Route::get('login/{provider}', 'SocialController@redirectToProvider')
        ->name('social.login');
    Route::get('login/{provider}/callback', 'SocialController@handleProviderCallback')
        ->name('social.callback');
});

