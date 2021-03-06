<?php

Route::group(['module' => 'User', 'middleware' => ['auth:api'], 'namespace' => 'App\Modules\User\Controllers\api'], function() {


    route::get('api/user/{id}', "UserController@handleFetchUser");
    route::get('/api/users/show', "UserController@showUsers");
    route::get('/api/preparators/show', "UserController@showPreparators");
    route::get('/api/deliveries/show', "UserController@showDeliveries");
    route::get('/api/stores/user/{user_id}', "UserController@showContactsStores"); // show stores for responsible
    Route::post('/api/contact/save/{id}', 'UserController@storeClient')->name('storeClient');
    Route::post('/api/contact/update/{cid}/{id}', 'UserController@updateClient')->name('updateClient');
});

Route::group(['module' => 'User', 'middleware' => ['api'], 'namespace' => 'App\Modules\User\Controllers\api'], function() {


    route::post('api/login', 'UserController@login');
});

