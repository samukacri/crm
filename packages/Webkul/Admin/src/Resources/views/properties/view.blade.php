<x-admin::layouts>
    <x-slot:title>
        @lang ($property->name)
    </x-slot>

    <!-- Content -->
    <div class="flex gap-4 max-lg:flex-wrap">
        <!-- Left Panel -->
        {!! view_render_event('admin.properties.view.left.before', ['property' => $property]) !!}

        <div class="max-lg:min-w-full max-lg:max-w-full [&>div:last-child]:border-b-0 lg:sticky lg:top-[73px] flex min-w-[394px] max-w-[394px] flex-col self-start rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
            <!-- Property Information -->
            <div class="flex w-full flex-col gap-2 border-b border-gray-200 p-4 dark:border-gray-800">
                <!-- Breadcrumbs -->
                <div class="flex items-center justify-between">
                    <x-admin::breadcrumbs name="properties.view" :entity="$property" />
                </div>

                {!! view_render_event('admin.properties.view.left.tags.before', ['property' => $property]) !!}

                <!-- Tags -->
                <x-admin::tags
                    :attach-endpoint="route('admin.properties.tags.attach', $property->id)"
                    :detach-endpoint="route('admin.properties.tags.detach', $property->id)"
                    :added-tags="$property->tags"
                />

                {!! view_render_event('admin.properties.view.left.tags.after', ['property' => $property]) !!}

                <!-- Title -->
                <div class="mb-2 flex flex-col gap-0.5">
                    {!! view_render_event('admin.properties.view.left.title.before', ['property' => $property]) !!}

                    <h3 class="break-words text-lg font-bold dark:text-white">
                        {{ $property->name }}
                    </h3>
                    
                    {!! view_render_event('admin.properties.view.left.title.after', ['property' => $property]) !!}

                    {!! view_render_event('admin.properties.view.left.sku.before', ['property' => $property]) !!}

                    <p class="break-words text-sm font-normal dark:text-white">
                        @lang('admin::app.properties.view.sku') : {{ $property->sku }}
                    </p>

                    {!! view_render_event('admin.properties.view.left.sku.after', ['property' => $property]) !!}
                </div>

                {!! view_render_event('admin.properties.view.left.activity_actions.before', ['property' => $property]) !!}

                <!-- Activity Actions -->
                <div class="flex flex-wrap gap-2">
                    {!! view_render_event('admin.properties.view.left.activity_actions.note.before', ['property' => $property]) !!}

                    <!-- Note Activity Action -->
                    <x-admin::activities.actions.note
                        :entity="$property"
                        entity-control-name="property_id"
                    />

                    {!! view_render_event('admin.properties.view.left.activity_actions.note.after', ['property' => $property]) !!}

                    {!! view_render_event('admin.properties.view.left.activity_actions.file.before', ['property' => $property]) !!}

                    <!-- File Activity Action -->
                    <x-admin::activities.actions.file
                        :entity="$property"
                        entity-control-name="property_id"
                    />

                    {!! view_render_event('admin.properties.view.left.activity_actions.file.after', ['property' => $property]) !!}
                </div>

                {!! view_render_event('admin.properties.view.left.activity_actions.after', ['property' => $property]) !!}
            </div>
            
            <!-- Property Attributes -->
            @include ('admin::properties.view.attributes')
        </div>

        {!! view_render_event('admin.properties.view.left.after', ['property' => $property]) !!}

        {!! view_render_event('admin.properties.view.right.before', ['property' => $property]) !!}
        
        <!-- Right Panel -->
        <div class="flex w-full flex-col gap-4 rounded-lg">
            {!! view_render_event('admin.properties.view.right.activities.before', ['property' => $property]) !!}

            <!-- Activity Navigation -->
            <x-admin::activities
                :endpoint="route('admin.properties.activities.index', $property->id)" 
                :types="[
                    ['name' => 'all', 'label' => trans('admin::app.properties.view.all')],
                    ['name' => 'note', 'label' => trans('admin::app.properties.view.notes')],
                    ['name' => 'file', 'label' => trans('admin::app.properties.view.files')],
                    ['name' => 'system', 'label' => trans('admin::app.properties.view.change-logs')],
                ]"
                :extra-types="[
                    ['name' => 'inventory', 'label' => trans('admin::app.properties.view.inventories')],
                ]"
            >
                <x-slot:inventory>
                    @include('admin::properties.view.inventory')
                </x-slot>
            </x-admin::activities>

            {!! view_render_event('admin.properties.view.right.activities.after', ['property' => $property]) !!}
        </div>

        {!! view_render_event('admin.properties.view.right.after', ['property' => $property]) !!}
    </div>    
</x-admin::layouts>