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

