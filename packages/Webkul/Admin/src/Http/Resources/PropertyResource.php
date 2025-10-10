<?php

namespace Webkul\Admin\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'sku'         => $this->sku,
            'name'        => $this->name,
            'description' => $this->description,
            'quantity'    => $this->quantity,
            'price'       => $this->price,
            'tags'        => $this->tags ? $this->tags->pluck('name')->toArray() : [],
            'warehouses'  => $this->warehouses ? $this->warehouses->map(function ($warehouse) {
                return [
                    'id'   => $warehouse->id,
                    'name' => $warehouse->name,
                ];
            }) : [],
            'locations'   => $this->locations ? $this->locations->map(function ($location) {
                return [
                    'id'   => $location->id,
                    'name' => $location->name,
                ];
            }) : [],
            'inventories' => $this->inventories ? $this->inventories->map(function ($inventory) {
                return [
                    'id'                     => $inventory->id,
                    'quantity'               => $inventory->quantity,
                    'warehouse_id'           => $inventory->warehouse_id,
                    'warehouse_location_id'  => $inventory->warehouse_location_id,
                ];
            }) : [],
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}