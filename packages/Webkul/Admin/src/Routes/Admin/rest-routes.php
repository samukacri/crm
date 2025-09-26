<?php

use Illuminate\Support\Facades\Route;
use Webkul\Admin\Http\Controllers\DashboardController;
use Webkul\Admin\Http\Controllers\DataGrid\SavedFilterController;
use Webkul\Admin\Http\Controllers\DataGridController;
use Webkul\Admin\Http\Controllers\TinyMCEController;
use Webkul\Admin\Http\Controllers\User\AccountController;
use Webkul\Project\Http\Controllers\ProjectController;

/**
 * Dashboard routes.
 */
Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
    Route::get('', 'index')->name('admin.dashboard.index');

    Route::get('stats', 'stats')->name('admin.dashboard.stats');
});

/**
 * DataGrid routes.
 */
Route::prefix('datagrid')->group(function () {
    /**
     * Saved filter routes.
     */
    Route::controller(SavedFilterController::class)->prefix('datagrid/saved-filters')->group(function () {
        Route::post('', 'store')->name('admin.datagrid.saved_filters.store');

        Route::get('', 'get')->name('admin.datagrid.saved_filters.index');

        Route::put('{id}', 'update')->name('admin.datagrid.saved_filters.update');

        Route::delete('{id}', 'destroy')->name('admin.datagrid.saved_filters.destroy');
    });

    /**
     * Lookup routes.
     */
    Route::get('datagrid/look-up', [DataGridController::class, 'lookUp'])->name('admin.datagrid.look_up');
});

/**
 * Tinymce file upload handler.
 */
Route::post('tinymce/upload', [TinyMCEController::class, 'upload'])->name('admin.tinymce.upload');

/**
 * User profile routes.
 */
Route::controller(AccountController::class)->prefix('account')->group(function () {
    Route::get('', 'edit')->name('admin.user.account.edit');

    Route::put('update', 'update')->name('admin.user.account.update');
});

/**
 * Project routes.
 */
Route::controller(ProjectController::class)->prefix('projects')->group(function () {
    Route::get('', 'index')->name('admin.projects.index');
    Route::get('get', 'get')->name('admin.projects.get');
    Route::get('kanban/lookup', 'kanbanLookup')->name('admin.projects.kanban.lookup');
    Route::get('create', 'create')->name('admin.projects.create');
    Route::post('', 'store')->name('admin.projects.store');
    Route::get('{id}/edit', 'edit')->name('admin.projects.edit');
    Route::put('{id}', 'update')->name('admin.projects.update');
    Route::get('{id}', 'show')->name('admin.projects.show');
    Route::delete('{id}', 'destroy')->name('admin.projects.destroy');
});
