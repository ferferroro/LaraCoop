<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

	// Menu routes
	Route::group(['prefix' => 'menu'], function ($router) {
		Route::post('setup', 'MenuController@setup')->name('menu.setup');
		Route::get('setup_view', 'MenuController@setup_view')->name('menu.setup_view');
		Route::get('index', 'MenuController@index')->name('menu.index');
		Route::get('create', 'MenuController@create')->name('menu.create');
		Route::post('store', 'MenuController@store')->name('menu.store');
		Route::get('edit', 'MenuController@edit')->name('menu.edit');
		Route::post('update', 'MenuController@update')->name('menu.update');
		Route::post('destroy', 'MenuController@destroy')->name('menu.destroy');
	});

	// Member routes
	Route::group(['prefix' => 'member'], function ($router) {
		Route::get('index', 'MemberController@index')->name('member.index');
		Route::get('create', 'MemberController@create')->name('member.create');
		Route::post('store', 'MemberController@store')->name('member.store');
		Route::get('edit', 'MemberController@edit')->name('member.edit');
		Route::post('update', 'MemberController@update')->name('member.update');
		Route::post('destroy', 'MemberController@destroy')->name('member.destroy');
		Route::get('autocomplete', 'MemberController@autocomplete')->name('member.autocomplete');
		Route::get('contributions', 'MemberController@contributions')->name('member.contributions');
	});

	// Borrower routes
	Route::group(['prefix' => 'borrower'], function ($router) {
		Route::get('index', 'BorrowerController@index')->name('borrower.index');
		Route::get('create', 'BorrowerController@create')->name('borrower.create');
		Route::post('store', 'BorrowerController@store')->name('borrower.store');
		Route::get('edit', 'BorrowerController@edit')->name('borrower.edit');
		Route::post('update', 'BorrowerController@update')->name('borrower.update');
		Route::post('destroy', 'BorrowerController@destroy')->name('borrower.destroy');
		Route::get('get_borrower', 'BorrowerController@get_borrower')->name('borrower.get_borrower');
	});

	// Company routes
	Route::group(['prefix' => 'company'], function ($router) {
		Route::get('index', 'CompanyController@index')->name('company.index');
		Route::get('create', 'CompanyController@create')->name('company.create');
		Route::post('store', 'CompanyController@store')->name('company.store');
		Route::get('edit', 'CompanyController@edit')->name('company.edit');
		Route::post('update', 'CompanyController@update')->name('company.update');
	});

	// Contribution routes
	Route::group(['prefix' => 'contribution'], function ($router) {
		Route::get('index', 'ContributionController@index')->name('contribution.index');
		Route::get('create', 'ContributionController@create')->name('contribution.create');
		Route::post('store', 'ContributionController@store')->name('contribution.store');
		Route::get('edit', 'ContributionController@edit')->name('contribution.edit');
		Route::post('update', 'ContributionController@update')->name('contribution.update');
		Route::post('destroy', 'ContributionController@destroy')->name('contribution.destroy');
		Route::post('approve', 'ContributionController@approve')->name('contribution.approve');
	});

	// Loan routes
	Route::group(['prefix' => 'loan'], function ($router) {
		Route::get('index', 'LoanController@index')->name('loan.index');
		Route::get('create', 'LoanController@create')->name('loan.create');
		Route::post('store', 'LoanController@store')->name('loan.store');
		Route::get('edit', 'LoanController@edit')->name('loan.edit');
		Route::post('update', 'LoanController@update')->name('loan.update');
		Route::post('destroy', 'LoanController@destroy')->name('loan.destroy');		
		Route::post('approve', 'LoanController@approve')->name('loan.approve');

		Route::group(['prefix' => 'detail'], function ($router) {
			Route::post('pay', 'LoanDetailController@pay')->name('loan.detail.pay');
		});
	});

	// Pages Default routes
	Route::group(['prefix' => 'page'], function ($router) {
		Route::get('not_found', 'PageController@not_found')->name('page.not_found');
	});

	// System Users routes
	Route::group(['prefix' => 'system_user'], function ($router) {
		Route::get('index', 'SystemUserController@index')->name('system_user.index');
		Route::get('create', 'SystemUserController@create')->name('system_user.create');
		Route::post('store', 'SystemUserController@store')->name('system_user.store');
		Route::get('edit', 'SystemUserController@edit')->name('system_user.edit');
		Route::post('update', 'SystemUserController@update')->name('system_user.update');
		// Route::post('destroy', 'SystemUserController@destroy')->name('system_user.destroy');
	});

});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

