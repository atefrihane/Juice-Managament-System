<?php

Route::group(['module' => 'Mixture', 'middleware' => ['auth:api'], 'namespace' => 'App\Modules\Mixture\Controllers\api'], function() {

//    Route::resource('Mixture', 'MixtureController');
    route::post('api/mixtures', 'MixtureController@store');
    route::post('api/mixture/delete/{id}', 'MixtureController@handleDeleteMixture');
    route::get('api/mixtures', 'MixtureController@handleGetMixtures');
});
