<?php

namespace Webkul\Property\Providers;

use Webkul\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        \Webkul\Property\Models\Property::class,
        \Webkul\Property\Models\PropertyInventory::class,
    ];
}