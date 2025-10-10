<?php

namespace Webkul\Admin\DataGrids\Property;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;
use Webkul\Tag\Repositories\TagRepository;
use Webkul\User\Repositories\UserRepository;

class PropertyDataGrid extends DataGrid
{
    /**
     * Default sort column of datagrid.
     *
     * @var ?string
     */
    protected $sortColumn = 'created_at';

    /**
     * Create data grid instance.
     *
     * @return void
     */
    public function __construct(
        protected TagRepository $tagRepository,
        protected UserRepository $userRepository,
    ) {
        parent::__construct();
    }

    /**
     * Prepare query builder.
     */
    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('properties')
            ->select(
                'properties.id',
                'properties.sku',
                'properties.name',
                'properties.description',
                'properties.quantity',
                'properties.price',
                'properties.created_at',
                'properties.updated_at',
                DB::raw('GROUP_CONCAT(DISTINCT tags.name SEPARATOR ", ") as tags')
            )
            ->leftJoin('property_tags', 'properties.id', '=', 'property_tags.property_id')
            ->leftJoin('tags', 'property_tags.tag_id', '=', 'tags.id')
            ->groupBy('properties.id');

        $this->addFilter('id', 'properties.id');
        $this->addFilter('sku', 'properties.sku');
        $this->addFilter('name', 'properties.name');
        $this->addFilter('description', 'properties.description');
        $this->addFilter('quantity', 'properties.quantity');
        $this->addFilter('price', 'properties.price');
        $this->addFilter('tags', 'tags.name');
        $this->addFilter('created_at', 'properties.created_at');

        return $queryBuilder;
    }

    /**
     * Prepare columns.
     */
    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('property::app.datagrid.id'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'sku',
            'label'      => trans('property::app.datagrid.sku'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('property::app.datagrid.name'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'description',
            'label'      => trans('property::app.datagrid.description'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'quantity',
            'label'      => trans('property::app.datagrid.quantity'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'price',
            'label'      => trans('property::app.datagrid.price'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                return $row->price ? core()->formatPrice($row->price) : '-';
            },
        ]);

        $this->addColumn([
            'index'      => 'tags',
            'label'      => trans('property::app.datagrid.tags'),
            'type'       => 'string',
            'searchable' => false,
            'filterable' => true,
            'filterable_type' => 'searchable_dropdown',
            'filterable_options' => [
                'repository' => TagRepository::class,
                'column'     => [
                    'label' => 'name',
                    'value' => 'id',
                ],
            ],
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('property::app.datagrid.created-at'),
            'type'       => 'date_range',
            'filterable' => true,
            'sortable'   => true,
            'closure'    => function ($row) {
                return core()->formatDate($row->created_at);
            },
        ]);
    }

    /**
     * Prepare actions.
     */
    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('property.view')) {
            $this->addAction([
                'index'  => 'view',
                'icon'   => 'icon-eye',
                'title'  => trans('property::app.datagrid.view'),
                'method' => 'GET',
                'url'    => fn ($row) => route('admin.property.view', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('property.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('property::app.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => route('admin.property.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('property.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('property::app.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => route('admin.property.delete', $row->id),
            ]);
        }
    }

    /**
     * Prepare mass actions.
     */
    public function prepareMassActions(): void
    {
        if (bouncer()->hasPermission('property.mass_delete')) {
            $this->addMassAction([
                'icon'   => 'icon-delete',
                'title'  => trans('property::app.datagrid.mass-delete'),
                'method' => 'POST',
                'url'    => route('admin.property.mass_delete'),
            ]);
        }

        if (bouncer()->hasPermission('property.mass_update')) {
            $this->addMassAction([
                'icon'   => 'icon-edit',
                'title'  => trans('property::app.datagrid.mass-update'),
                'method' => 'POST',
                'url'    => route('admin.property.mass_update'),
            ]);
        }
    }
}