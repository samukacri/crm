<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Dashboard > Projects
Breadcrumbs::for('projects.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push(trans('project::app.projects'), route('admin.projects.index'));
});

// Dashboard > Projects > Create
Breadcrumbs::for('projects.create', function (BreadcrumbTrail $trail) {
    $trail->parent('projects.index');
    $trail->push(trans('project::app.add-project'), route('admin.projects.create'));
});

// Dashboard > Projects > Edit
Breadcrumbs::for('projects.edit', function (BreadcrumbTrail $trail, $project) {
    $trail->parent('projects.index');
    $trail->push(trans('project::app.edit'), route('admin.projects.edit', $project->id));
});

// Dashboard > Projects > View
Breadcrumbs::for('projects.view', function (BreadcrumbTrail $trail, $project) {
    $trail->parent('projects.index');
    $trail->push('#'.$project->id, route('admin.projects.show', $project->id));
});