<?php

use Illuminate\Support\Facades\Route;
use Webkul\Project\Http\Controllers\ProjectController;

Route::group(['middleware' => ['web', 'admin_locale', 'user'], 'prefix' => config('app.admin_path')], function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('admin.projects.index');
    Route::get('/projects/get/{pipelineId?}', [ProjectController::class, 'get'])->name('admin.projects.get');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('admin.projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('admin.projects.show');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('admin.projects.destroy');
    
    // Template routes
    Route::get('/projects/create-from-template/{templateId}', [ProjectController::class, 'createFromTemplate'])->name('admin.projects.create.from.template');
    Route::post('/projects/create-from-template/{templateId}', [ProjectController::class, 'storeFromTemplate'])->name('admin.projects.store.from.template');
    
    // Task filtering
    Route::get('/projects/tasks/filter', [ProjectController::class, 'filterTasks'])->name('admin.projects.tasks.filter');
    
    // Kanban lookup
    Route::get('/projects/kanban/lookup', [ProjectController::class, 'kanbanLookup'])->name('admin.projects.kanban.lookup');
});