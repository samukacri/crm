<?php

namespace Webkul\Property\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Property\Contracts\PropertyInventory as PropertyInventoryContract;
use Webkul\Warehouse\Models\LocationProxy;
use Webkul\Warehouse\Models\WarehouseProxy;

class PropertyInventory extends Model implements PropertyInventoryContract
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'in_stock',
        'allocated',
        'property_id',
        'warehouse_id',
        'warehouse_location_id',
    ];

    /**
     * Interact with the name.
     */
    protected function onHand(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->in_stock - $this->allocated,
            set: fn ($value) => $this->in_stock - $this->allocated
        );
    }

    /**
     * Get the property that owns the property inventory.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(PropertyProxy::modelClass());
    }

    /**
     * Get the property attribute family that owns the property.
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(WarehouseProxy::modelClass());
    }

    /**
     * Get the property attribute family that owns the property.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationProxy::modelClass(), 'warehouse_location_id');
    }
}