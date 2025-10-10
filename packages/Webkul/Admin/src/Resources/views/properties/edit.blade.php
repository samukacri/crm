<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::properties.edit.title')
    </x-slot>

    {!! view_render_event('admin.properties.edit.form.before') !!}

    <x-admin::form
        :action="route('admin.properties.update', $property->id)"
        encType="multipart/form-data"
        method="PUT"
    >
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <!-- Breadcrumbs -->
                    <x-admin::breadcrumbs
                        name="properties.edit"
                        :entity="$property"
                     />

                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::properties.edit.title')
                    </div>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <div class="flex items-center gap-x-2.5">
                        {!! view_render_event('admin.properties.edit.create_button.before', ['property' => $property]) !!}
                        
                        <!-- Edit button for Property -->
                        <button
                            type="submit"
                            class="primary-button"
                        >
                            @lang('admin::properties.edit.save-btn')
                        </button>

                        {!! view_render_event('admin.properties.edit.create_button.after', ['property' => $property]) !!}
                    </div>
                </div>
            </div>

            <div class="flex gap-2.5 max-xl:flex-wrap">
                <!-- Left sub-component -->
                <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                    <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                        <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                            @lang('admin::properties.edit.general')
                        </p>

                        {!! view_render_event('admin.properties.edit.attributes.before', ['property' => $property]) !!}

                        <x-admin::attributes
                            :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                'entity_type' => 'properties',
                                ['code', 'NOTIN', ['price', 'quantity']],
                            ])"
                            :entity="$property"
                        />

                        {!! view_render_event('admin.properties.edit.attributes.after', ['property' => $property]) !!}
                    </div>
                </div>

                <!-- Right sub-component -->
                <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                    {!! view_render_event('admin.properties.edit.accordion.before', ['property' => $property]) !!}

                    <x-admin::accordion >
                        <x-slot:header>
                            {!! view_render_event('admin.properties.edit.accordion.header.before', ['property' => $property]) !!}

                            <div class="flex items-center justify-between">
                                <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                    @lang('admin::properties.edit.price')
                                </p>
                            </div>

                            {!! view_render_event('admin.properties.edit.accordion.header.after', ['property' => $property]) !!}
                        </x-slot>

                        <x-slot:content>
                            {!! view_render_event('admin.properties.edit.accordion.content.attributes.before', ['property' => $property]) !!}

                            <x-admin::attributes
                                :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'properties',
                                    ['code', 'IN', ['price', 'quantity']],
                                ])"
                                :entity="$property"
                            />

                            {!! view_render_event('admin.properties.edit.accordion.content.attributes.after', ['property' => $property]) !!}
                        </x-slot>
                    </x-admin::accordion>

                    {!! view_render_event('admin.properties.edit.accordion.after', ['property' => $property]) !!}
                </div>
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('admin.properties.edit.form.after') !!}
</x-admin::layouts>