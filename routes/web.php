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

	// Member routes
	Route::group(['prefix' => 'member'], function ($router) {
		Route::get('index', 'MemberController@index')->name('member.index');
		Route::get('create', 'MemberController@create')->name('member.create');
		Route::post('store', 'MemberController@store')->name('member.store');
		Route::get('edit', 'MemberController@edit')->name('member.edit');
		Route::post('update', 'MemberController@update')->name('member.update');
		Route::post('destroy', 'MemberController@destroy')->name('member.destroy');
		Route::get('autocomplete', 'MemberController@autocomplete')->name('member.autocomplete');
	});

	// Borrower routes
	Route::group(['prefix' => 'borrower'], function ($router) {
		Route::get('index', 'BorrowerController@index')->name('borrower.index');
		Route::get('create', 'BorrowerController@create')->name('borrower.create');
		Route::post('store', 'BorrowerController@store')->name('borrower.store');
		Route::get('edit', 'BorrowerController@edit')->name('borrower.edit');
		Route::post('update', 'BorrowerController@update')->name('borrower.update');
		Route::post('destroy', 'BorrowerController@destroy')->name('borrower.destroy');
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
	});

});

Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

