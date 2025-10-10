{!! view_render_event('admin.properties.view.attributes.before', ['property' => $property]) !!}

<div class="flex w-full flex-col gap-4 border-b border-gray-200 p-4 dark:border-gray-800 dark:text-white">
    <x-admin::accordion  class="select-none !border-none">
        <x-slot:header class="!p-0">
            <h4 class="font-semibold dark:text-white">
                @lang('admin::properties.view.attributes.about-property')
            </h4>
        </x-slot>

        <x-slot:content class="mt-4 !px-0 !pb-0">
            {!! view_render_event('admin.properties.view.attributes.view.before', ['property' => $property]) !!}
    
            <!-- Attributes Listing -->
            <div>
                <!-- Default Attributes --> 
                <x-admin::attributes.view
                    :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                        'entity_type' => 'properties',
                        ['code', 'IN', ['SKU', 'price', 'quantity', 'status']]
                    ])->sortBy('sort_order')"
                    :entity="$property"
                    :url="route('admin.properties.update', $property->id)"   
                    :allow-edit="true"
                />
        
                <!-- Custom Attributes --> 
                <x-admin::attributes.view
                    :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                        'entity_type' => 'properties',
                        ['code', 'NOTIN', ['SKU', 'price', 'quantity', 'status']]
                    ])->sortBy('sort_order')"
                    :entity="$property"
                    :url="route('admin.properties.update', $property->id)"   
                    :allow-edit="true"
                />
            </div>
            
            {!! view_render_event('admin.properties.view.attributes.view.after', ['property' => $property]) !!}
        </x-slot>
    </x-admin::accordion>
</div>

{!! view_render_event('admin.properties.view.attributes.before', ['property' => $property]) !!}