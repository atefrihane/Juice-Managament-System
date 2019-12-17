<?php

Route::group(['module' => 'Warehouse', 'middleware' => ['web','isAuth'], 'namespace' => 'App\Modules\Warehouse\Controllers'], function() {

   Route::get('/warehouse/products','WarehouseController@showWarehouseProducts')->name('showWarehouseProducts');
   Route::get('/warehouses','WarehouseController@showWarehouses')->name('showWarehouses');
   Route::get('/product/quantity/add','WarehouseController@showAddProductQuantity')->name('showAddProductQuantity');
   Route::post('/product/quantity','WarehouseController@handleAddProductQuantity')->name('handleAddProductQuantity');
   Route::get('/product/quantity/edit/{id}','WarehouseController@showEditProductQuantity')->name('showEditProductQuantity');
   Route::get('/warehouse/add','WarehouseController@showAddWarehouse')->name('showAddWarehouse');
   Route::post('/warehouse/add','WarehouseController@handleAddWarehouse')->name('handleAddWarehouse');
   Route::get('/warehouse/update/{id}','WarehouseController@showUpdateWarehouse')->name('showUpdateWarehouse');
   Route::post('/warehouse/update/{id}','WarehouseController@handleUpdateWarehouse')->name('handleUpdateWarehouse');
   Route::post('/warehouse/{id}/delete','WarehouseController@handleDeleteWarehouse')->name('handleDeleteWarehouse');
   Route::get('/warehouse/{id}','WarehouseController@showWarehouse')->name('showWarehouse');
   Route::get('/warehouse/{id}/stock','WarehouseController@showAddWarehouseStock')->name('showAddWarehouseStock');
   Route::post('/product/quantity/edit/{id}','WarehouseController@handleEditProductQuantity')->name('handleEditProductQuantity');
   Route::post('/product/quantity/{id}/delete/','WarehouseController@handleDeleteProductQuantity')->name('handleDeleteProductQuantity');
   Route::post('/warehouse/quantity/{id}/delete/','WarehouseController@handleDeleteWarehouseQuantity')->name('handleDeleteWarehouseQuantity');
});
