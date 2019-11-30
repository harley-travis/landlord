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

Route::get('/', function () {
	
	if( auth()->check() == null ) {
		return redirect('/login');
	} else {

		return view('dashboard');
	}
    
});

Auth::routes();

Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});

// Route::get('/', 'HomeController@index')->name('dashboard.index')->middleware('auth', 'trial');

Route::get('/home', function () {
	
	if( Auth::user()->stripe_id === null && Auth::user()->role === 3 ) {
		return view('settings.billing.trial.begin');
	} else if(Auth::user()->role === 0) {
    return view('tenants.billing');
  } else {
		return view('dashboard');
	}
    
})->name('home')->middleware('verified');



// PROPERTIES
Route::group(['prefix' => 'property', 'middleware' => ['auth', 'trial']], function() {
    $c = 'PropertyController';

    Route::get('', [
      'uses' => "$c@index",
      'as' => 'property.index'
    ]);

    Route::get('create', [
      'uses' => "$c@create",
      'as' => 'property.create'
    ]);

    Route::post('create', [
      'uses' => "$c@store",
      'as' => 'property.add'
    ]);

    Route::get('edit/{id}', [
      'uses'	=> "$c@edit",
      'as'	=> 'property.edit'
    ]);

	  Route::post('edit', [
      'uses'	=> "$c@update",
      'as'	=> 'property.update'
    ]);
    
    Route::get('delete/{id}', [
      'uses'	=> "$c@destroy",
      'as'	=> 'property.delete'
    ]);

});

// TENANTS
Route::group(['prefix' => 'tenants', 'middleware' => ['auth', 'trial']], function() {
    $c = 'TenantController';

    Route::get('', [
        'uses' => "$c@index",
        'as' => 'tenants.index'
    ]);

    Route::get('show/{id}', [
      'uses' => "$c@show",
      'as' => 'tenants.show'
    ]);

    Route::get('create', [
      'uses' => "$c@create",
      'as' => 'tenants.create'
    ]);

    Route::post('create', [
      'uses' => "$c@store",
      'as' => 'tenants.add'
    ]);

    Route::get('edit/{id}', [
      'uses'	=> "$c@edit",
      'as'	=> 'tenants.edit'
    ]);

	  Route::post('edit', [
      'uses'	=> "$c@update",
      'as'	=> 'tenants.update'
    ]);
    
    Route::get('archive/{id}', [
      'uses'	=> "$c@archive",
      'as'	=> 'tenants.archive'
    ]);
    
    Route::get('archived', [
      'uses'	=> "$c@showArchive",
      'as'	=> 'tenants.archived'
    ]);

    Route::post('assignProperty', [
      'uses'	=> "$c@assignProperty",
      'as'	=> 'tenants.assignProperty'
    ]);

    Route::post('unassignProperty', [
      'uses'	=> "$c@unassignProperty",
      'as'	=> 'tenants.unassignProperty'
    ]);

    Route::get('billing', [
      'uses' => "$c@showPayIndex",
      'as' => 'tenants.billing.index'
    ]);

    Route::get('billing/pay', [
      'uses' => "$c@showPay",
      'as' => 'tenants.billing.pay'
    ]);

    Route::get('billing/review', [
      'uses' => "$c@showReview",
      'as' => 'tenants.billing.review'
    ]);

    Route::get('billing/confirmation', [
      'uses' => "$c@showPaymentConfirmation",
      'as' => 'tenants.billing.confirmation'
    ]);
    
});

// MAINTENANCE
Route::group(['prefix' => 'maintenance', 'middleware' => ['auth', 'trial']], function() {
    $c = 'MaintenanceController';

    Route::get('', [
      'uses' => "$c@index",
      'as' => 'maintenance.index'
    ]);

    Route::get('show/{id}', [
      'uses' => "$c@show",
      'as' => 'maintenance.show'
    ]);

    Route::get('create', [
      'uses' => "$c@create",
      'as' => 'maintenance.create'
    ]);

    Route::post('create', [
      'uses' => "$c@store",
      'as' => 'maintenance.add'
    ]);

    Route::get('edit/{id}', [
      'uses'	=> "$c@edit",
      'as'	=> 'maintenance.edit'
	  ]);

	  Route::post('edit', [
      'uses'	=> "$c@update",
      'as'	=> 'maintenance.update'
    ]);
    
    Route::get('archive/{id}', [
      'uses'	=> "$c@archive",
      'as'	=> 'maintenance.archive'
    ]);
    
    Route::get('archived', [
      'uses'	=> "$c@showArchive",
      'as'	=> 'maintenance.archived'
    ]);
    
    Route::get('progression/{id}', [
      'uses'	=> "$c@progression",
      'as'	=> 'maintenance.progression'
    ]);
    
});

// USERS
Route::group(['prefix' => 'users', 'middleware' => ['auth', 'trial']], function() {
  $c = 'UserRoleController';

  Route::get('', [
    'uses' => "$c@index",
    'as' => 'users.index'
  ]);

  Route::get('show/{id}', [
    'uses' => "$c@show",
    'as' => 'users.show'
  ]);

  Route::get('create', [
    'uses' => "$c@create",
    'as' => 'users.create'
  ]);

  Route::post('create', [
    'uses' => "$c@store",
    'as' => 'users.add'
  ]);

  Route::get('edit/{id}', [
    'uses'	=> "$c@edit",
    'as'	=> 'users.edit' 
  ]);

  Route::post('edit', [
    'uses'	=> "$c@update",
    'as'	=> 'users.update'
  ]);
  
  Route::get('archive/{id}', [
    'uses'	=> "$c@archive",
    'as'	=> 'users.archive'
  ]);
  
  Route::get('archived', [
    'uses'	=> "$c@showArchive",
    'as'	=> 'users.archived'
  ]);
  
});

// FEEDBACK
Route::group(['prefix' => 'feedback', 'middleware' => ['auth', 'trial']], function() {
  $c = 'FeedbackController';

  Route::get('', [
    'uses' => "$c@index",
    'as' => 'feedback.index'
  ]);

  Route::get('show/{id}', [
    'uses' => "$c@show",
    'as' => 'feedback.show'
  ]);

  Route::get('create', [
    'uses' => "$c@create",
    'as' => 'feedback.create'
  ]);

  Route::post('create', [
    'uses' => "$c@store",
    'as' => 'feedback.add'
  ]);

  Route::get('edit/{id}', [
    'uses'	=> "$c@edit",
    'as'	=> 'feedback.edit'
  ]);

  Route::post('edit', [
    'uses'	=> "$c@update",
    'as'	=> 'feedback.update'
  ]);
  
  Route::get('archive/{id}', [
    'uses'	=> "$c@archive",
    'as'	=> 'feedback.archive'
  ]);
  
  Route::get('archived', [
    'uses'	=> "$c@showArchive",
    'as'	=> 'feedback.archived'
  ]);
  
  Route::get('progression/{id}', [
    'uses'	=> "$c@progression",
    'as'	=> 'feedback.progression'
  ]);
  
});

// COMMUNITIES
Route::group(['prefix' => 'community', 'middleware' => ['auth', 'trial']], function() {
  $c = 'CommunityController';

  Route::get('', [
    'uses' => "$c@index",
    'as' => 'community.index'
  ]);

  Route::get('create', [
    'uses' => "$c@create",
    'as' => 'community.create'
  ]);

  Route::post('create', [
    'uses' => "$c@store",
    'as' => 'community.add'
  ]);

  Route::get('edit/{id}', [
    'uses'	=> "$c@edit",
    'as'	=> 'community.edit'
  ]);

  Route::post('edit', [
    'uses'	=> "$c@update",
    'as'	=> 'community.update'
  ]);
  
  Route::get('delete/{id}', [
    'uses'	=> "$c@destroy",
    'as'	=> 'community.delete'
  ]);

});

// STORAGE RENTALS
Route::group(['prefix' => 'storage-rentals', 'middleware' => ['auth', 'trial']], function() {
  $c = 'StorageRentalController';

  Route::get('', [
    'uses' => "$c@index",
    'as' => 'storage-rentals.index'
  ]);

  Route::get('create', [
    'uses' => "$c@create",
    'as' => 'storage-rentals.create'
  ]);

  Route::post('create', [
    'uses' => "$c@store",
    'as' => 'storage-rentals.add'
  ]);

  Route::get('edit/{id}', [
    'uses'	=> "$c@edit",
    'as'	=> 'storage-rentals.edit'
  ]);

  Route::post('edit', [
    'uses'	=> "$c@update",
    'as'	=> 'storage-rentals.update'
  ]);
  
  Route::get('delete/{id}', [
    'uses'	=> "$c@destroy",
    'as'	=> 'storage-rentals.delete'
  ]);

});

// BILLING
Route::group(['prefix' => 'settings/billing', 'middleware' => ['auth']], function() {
  $c = 'BillingController';

  Route::get('', [
    'uses' => "$c@index",
    'as' => 'settings.billing.index'
  ]);

  Route::get('create', [
    'uses' => "$c@create",
    'as' => 'settings.billing.subscription.create'
  ]);

  Route::post('subscribe', [
    'uses' => "$c@store",
    'as' => 'settings.billing.subscribe'
  ]);

  Route::get('ach/create', [
    'uses' => "$c@createACH",
    'as' => 'settings.billing.ach.create'
  ]);

  Route::post('ach/create', [
    'uses' => "$c@storeACH",
    'as' => 'settings.billing.ach.add'
  ]);

  Route::get('ach/verify/{id}', [
    'uses' => "$c@verifyACH",
    'as' => 'settings.billing.ach.verify'
  ]);

  Route::post('ach/verify', [
    'uses' => "$c@storeVerifyACH",
    'as' => 'settings.billing.ach.verifyCheck'
  ]);

  Route::get('ach/delete/{id}', [
    'uses'	=> "$c@destroyACH",
    'as'	=> 'settings.billing.ach.delete'
  ]);

  Route::get('edit/{id}', [
    'uses'	=> "$c@edit",
    'as'	=> 'settings.billing.edit'
  ]);

  Route::post('edit', [
    'uses'	=> "$c@update",
    'as'	=> 'settings.billing.update'
  ]);
  
  Route::get('delete/{id}', [
    'uses'	=> "$c@destroy",
    'as'	=> 'settings.billing.delete'
  ]);

  Route::get('trial/begin', [
    'uses'	=> "$c@getTrialBeginView",
    'as'	=> 'settings.billing.trial.begin'
  ]);

  Route::get('trial/end', [
    'uses'	=> "$c@getTrialEndView",
    'as'	=> 'settings.billing.trial.end'
  ]);

  Route::post('trial/activate', [
    'uses'	=> "$c@activateTrial",
    'as'	=> 'settings.billing.trial.activate'
  ]);

  Route::get('authorize/{id}', [
    'uses'	=> "$c@createOwnerSubscription",
    'as'	=> 'settings.billing.ach.authorize'
  ]);

  Route::get('setDefault/{id}', [
		'uses'	=> "$c@setDefaultPaymentMethod", 
		'as'	=> 'settings.billing.setDefault'
  ]);
  
  Route::get('confirmation', [
    'uses'	=> "$c@showConfirmation",
    'as'	=> 'settings.billing.confirmation'
  ]);

  Route::post('expressConnection', [
    'uses'	=> "$c@completeExpressConnection",
    'as'	=> 'settings.billing.expressConnection'
  ]); 

});

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');