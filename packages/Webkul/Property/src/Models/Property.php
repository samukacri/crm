<?php

namespace Webkul\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webkul\Activity\Models\ActivityProxy;
use Webkul\Activity\Traits\LogsActivity;
use Webkul\Attribute\Traits\CustomAttribute;
use Webkul\Property\Contracts\Property as PropertyContract;
use Webkul\Tag\Models\TagProxy;
use Webkul\Warehouse\Models\LocationProxy;
use Webkul\Warehouse\Models\WarehouseProxy;

class Property extends Model implements PropertyContract
{
    use CustomAttribute, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'quantity',
        'price',
    ];

    /**
     * Get the property warehouses that owns the property.
     */
    public function warehouses(): BelongsToMany
    {
        return $this->belongsToMany(WarehouseProxy::modelClass(), 'property_inventories');
    }

    /**
     * Get the property locations that owns the property.
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(LocationProxy::modelClass(), 'property_inventories', 'property_id', 'warehouse_location_id');
    }

    /**
     * Get the property inventories that owns the property.
     */
    public function inventories(): HasMany
    {
        return $this->hasMany(PropertyInventoryProxy::modelClass());
    }

    /**
     * The tags that belong to the Properties.
     */
    public function tags()
    {
        return $this->belongsToMany(TagProxy::modelClass(), 'property_tags');
    }

    /**
     * Get the activities.
     */
    public function activities()
    {
        return $this->belongsToMany(ActivityProxy::modelClass(), 'property_activities');
    }
}