<?php

namespace Webkul\Property\Repositories;

use Webkul\Core\Eloquent\Repository;

class PropertyInventoryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'Webkul\Property\Contracts\PropertyInventory';
    }
}