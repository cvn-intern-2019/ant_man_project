<?php

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

Route::get('/','HomeController@index')->name('home-page');

Route::get('signup','SignUpController@getSignUp')->name('getSignUp');
Route::post('signup','SignUpController@postSignUp')->name('postSignUp');
Route::get('validEmail','SignUpController@validEmail')->name('validEmail');

Route::get('signin',[
	'as' => 'sign-in',
	'uses' => 'SignInController@view'
]);

Route::post('signin',[
	'as' => 'post-signin',
	'uses' => 'SignInController@postSignIn'
]);

Route::prefix('profile')->group(function () {
    Route::middleware(['checkSignIn'])->group(function () {
       	Route::get('information/{id}', [
			'as' => 'information',
			'uses' => 'UserController@getInformation'
		]);

       	Route::post('postInformation', [
			'as' => 'post-information',
			'uses' => 'UserController@postInformation'
		]);
       	Route::get('changepassword/{id}', [
			'as' => 'change-password',
			'uses' => 'UserController@getChangepassword'
		]);

		Route::post('postchangepassword', [
			'as' => 'postchange-password',
			'uses' => 'UserController@postChangepassword'
		]);
    });

});


Route::get('logout',[
	'as'=>'log-out',
	'uses' => 'SignInController@logout'
]);

Route::get('test',function(){
	return view('test');
});





