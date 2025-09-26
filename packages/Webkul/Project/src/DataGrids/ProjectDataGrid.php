<?php

namespace Webkul\Project\DataGrids;

use Webkul\Admin\DataGrids\DataGrid;
use Webkul\Project\Repositories\ProjectRepository;
use Webkul\Contact\Repositories\OrganizationRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\User\Repositories\UserRepository;
use Webkul\Tag\Repositories\TagRepository;
class ProjectDataGrid extends DataGrid
{
    public function __construct(
        protected ProjectRepository $projectRepository,
        protected OrganizationRepository $organizationRepository,
        protected ProductRepository $productRepository,
        protected UserRepository $userRepository,
        protected TagRepository $tagRepository
    ) {
        parent::__construct();
    }

    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        $queryBuilder = $this->projectRepository
            ->leftJoin('organizations', 'projects.organization_id', '=', 'organizations.id')
            ->leftJoin('products', 'projects.product_id', '=', 'products.id')
            ->leftJoin('users', 'projects.owner_id', '=', 'users.id')
            ->leftJoin('project_tags', 'projects.id', '=', 'project_tags.project_id')
            ->leftJoin('tags', 'project_tags.tag_id', '=', 'tags.id')
            ->select(
                'projects.id',
                'projects.name',
                'projects.description',
                'projects.status',
                'projects.start_date',
                'projects.end_date',
                'organizations.name as organization_name',
                'organizations.id as organization_id',
                'products.name as product_name',
                'products.id as product_id',
                'users.name as user_name',
                'users.id as owner_id',
                'tags.name as tag_name'
            )
            ->groupBy('projects.id');

        $this->addFilter('organization_name', 'organizations.name');
        $this->addFilter('product_name', 'products.name');
        $this->addFilter('user_name', 'users.name');
        $this->addFilter('tag_name', 'tags.name');

        return $queryBuilder;
    }

    /**
     * Add columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('project::app.id'),
            'type'       => 'integer',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('project::app.name'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'description',
            'label'      => trans('project::app.description'),
            'type'       => 'string',
            'searchable' => true,
            'filterable' => false,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('project::app.status'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'dropdown',
            'filterable_options' => [
                ['label' => 'Active', 'value' => 'active'],
                ['label' => 'Completed', 'value' => 'completed'],
                ['label' => 'Cancelled', 'value' => 'cancelled'],
            ],
            'sortable'   => true,
            'closure'    => function ($row) {
                $statusClass = match($row->status) {
                    'active' => 'bg-green-100 text-green-600',
                    'completed' => 'bg-blue-100 text-blue-600',
                    'cancelled' => 'bg-red-100 text-red-600',
                    default => 'bg-gray-100 text-gray-600'
                };
                
                return '<span class="inline-flex px-2 py-1 rounded-md ' . $statusClass . '">' . ucfirst($row->status) . '</span>';
            },
        ]);

        $this->addColumn([
            'index'      => 'start_date',
            'label'      => trans('project::app.start-date'),
            'type'       => 'date',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'end_date',
            'label'      => trans('project::app.end-date'),
            'type'       => 'date',
            'searchable' => false,
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'organization_name',
            'label'      => trans('project::app.organization'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => OrganizationRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'id',
                ],
            ],
            'sortable'   => true,
            'closure'    => function ($row) {
                return $row->organization_name ?? '--';
            },
        ]);

        $this->addColumn([
            'index'      => 'product_name',
            'label'      => trans('project::app.product'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => ProductRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'id',
                ],
            ],
            'sortable'   => true,
            'closure'    => function ($row) {
                return $row->product_name ?? '--';
            },
        ]);

        $this->addColumn([
            'index'      => 'user_name',
            'label'      => trans('project::app.sales-person'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => UserRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'id',
                ],
            ],
            'sortable'   => true,
            'closure'    => function ($row) {
                return $row->user_name ?? '--';
            },
        ]);

        $this->addColumn([
            'index'      => 'tag_name',
            'label'      => trans('project::app.tags'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => TagRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'name',
                ],
            ],
            'closure'    => function ($row) {
                return $row->tag_name ?? '--';
            },
        ]);


    }

    /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'index'  => 'view',
            'icon'   => 'icon-eye',
            'title'  => trans('project::app.view'),
            'method' => 'GET',
            'url'    => function ($row) {
                return route('admin.projects.show', $row->id);
            },
        ]);

        $this->addAction([
            'index'  => 'edit',
            'icon'   => 'icon-edit',
            'title'  => trans('project::app.edit'),
            'method' => 'GET',
            'url'    => function ($row) {
                return route('admin.projects.edit', $row->id);
            },
        ]);

        $this->addAction([
            'index'  => 'delete',
            'icon'   => 'icon-delete',
            'title'  => trans('project::app.delete'),
            'method' => 'DELETE',
            'url'    => function ($row) {
                return route('admin.projects.destroy', $row->id);
            },
        ]);
    }
}