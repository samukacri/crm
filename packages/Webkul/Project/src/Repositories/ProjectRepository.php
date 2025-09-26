<?php

namespace Webkul\Project\Repositories;

use Illuminate\Container\Container;
use Webkul\Attribute\Repositories\AttributeRepository;
use Webkul\Attribute\Repositories\AttributeValueRepository;
use Webkul\Core\Eloquent\Repository;

class ProjectRepository extends Repository
{
    /**
     * Searchable fields.
     */
    protected $fieldSearchable = [
        'name',
        'description',
        'status',
        'organization_id',
        'organization.name',
        'product_id',
        'product.name',
        'user_id',
        'user.name',
    ];

    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct(
        protected AttributeRepository $attributeRepository,
        protected AttributeValueRepository $attributeValueRepository,
        Container $container
    ) {
        parent::__construct($container);
    }

    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return 'Webkul\Project\Contracts\Project';
    }
}