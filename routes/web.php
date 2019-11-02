<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// PROPERTIES
Route::group(['prefix' => 'property', 'middleware' => ['auth']], function() {
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
Route::group(['prefix' => 'tenants', 'middleware' => ['auth']], function() {
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

});

// MAINTENANCE
Route::group(['prefix' => 'maintenance', 'middleware' => ['auth']], function() {
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
Route::group(['prefix' => 'users', 'middleware' => ['auth']], function() {
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
Route::group(['prefix' => 'feedback', 'middleware' => ['auth']], function() {
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
Route::group(['prefix' => 'community', 'middleware' => ['auth']], function() {
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

// BILLING
Route::group(['prefix' => 'settings/billing', 'middleware' => ['auth']], function() {
  $c = 'BillingController';

  Route::get('', [
    'uses' => "$c@index",
    'as' => 'settings.billing.index'
  ]);

  Route::get('create', [
    'uses' => "$c@create",
    'as' => 'settings.billing.create'
  ]);

  Route::post('create', [
    'uses' => "$c@store",
    'as' => 'settings.billing.add'
  ]);

  Route::get('createCard', [
    'uses' => "$c@createCard",
    'as' => 'settings.billing.createCard'
  ]);

  Route::post('createCard', [
    'uses' => "$c@storeCard",
    'as' => 'settings.billing.addCard'
  ]);

  Route::get('createACH', [
    'uses' => "$c@createACH",
    'as' => 'settings.billing.createACH'
  ]);

  Route::post('createACH', [
    'uses' => "$c@storeACH",
    'as' => 'settings.billing.addACH'
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

});

