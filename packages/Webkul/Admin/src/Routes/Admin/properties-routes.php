<?php

use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\Properties\ActivityController;
use Webkul\Admin\Http\Controllers\Properties\PropertyController;
use Webkul\Admin\Http\Controllers\Properties\TagController;

Route::group(['middleware' => ['user']], function () {
    Route::controller(PropertyController::class)->prefix('properties')->group(function () {
        Route::get('', 'index')->name('admin.properties.index');

        Route::get('create', 'create')->name('admin.properties.create');

        Route::post('create', 'store')->name('admin.properties.store');

        Route::get('view/{id}', 'view')->name('admin.properties.view');

        Route::get('edit/{id}', 'edit')->name('admin.properties.edit');

        Route::put('edit/{id}', 'update')->name('admin.properties.update');

        Route::get('search', 'search')->name('admin.properties.search');

        Route::get('{id}/warehouses', 'warehouses')->name('admin.properties.warehouses');

        Route::post('{id}/inventories/{warehouseId?}', 'storeInventories')->name('admin.properties.inventories.store');

        Route::delete('{id}', 'destroy')->name('admin.properties.delete');

        Route::post('mass-destroy', 'massDestroy')->name('admin.properties.mass_delete');

        Route::controller(ActivityController::class)->prefix('{id}/activities')->group(function () {
            Route::get('', 'index')->name('admin.properties.activities.index');
        });

        Route::controller(TagController::class)->prefix('{id}/tags')->group(function () {
            Route::post('', 'attach')->name('admin.properties.tags.attach');

            Route::delete('', 'detach')->name('admin.properties.tags.detach');
        });
    });
});