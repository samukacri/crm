<x-admin::layouts>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::properties.create.title')
    </x-slot>

    {!! view_render_event('admin.properties.create.form.before') !!}

    <x-admin::form
        :action="route('admin.properties.store')"
        method="POST"
    >
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    {!! view_render_event('admin.properties.create.breadcrumbs.before') !!}

                    <!-- Breadcrumbs -->
                    <x-admin::breadcrumbs name="properties.create" />

                    {!! view_render_event('admin.properties.create.breadcrumbs.after') !!}
                    
                    <div class="text-xl font-bold dark:text-white">
                        @lang('admin::properties.create.title')
                    </div>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <div class="flex items-center gap-x-2.5">
                        {!! view_render_event('admin.properties.create.save_button.before') !!}

                        <!-- Create button for Property -->
                        @if (bouncer()->hasPermission('settings.user.groups.create'))
                            <button
                                type="submit"
                                class="primary-button"
                            >
                                @lang('admin::properties.create.save-btn')
                            </button>
                        @endif

                        {!! view_render_event('admin.properties.create.save_button.after') !!}
                    </div>
                </div>
            </div>

            <div class="flex gap-2.5 max-xl:flex-wrap">
                <!-- Left sub-component -->
                <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
                    <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                        <p class="mb-4 text-base font-semibold text-gray-800 dark:text-white">
                            @lang('admin::properties.create.general')
                        </p>

                        {!! view_render_event('admin.properties.create.attributes.before') !!}

                        <x-admin::attributes
                            :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                'entity_type' => 'properties',
                                ['code', 'NOTIN', ['price', 'quantity']],
                            ])"
                        />

                        {!! view_render_event('admin.properties.create.attributes.after') !!}
                    </div>
                </div>

                <!-- Right sub-component -->
                <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
                    {!! view_render_event('admin.properties.create.accordion.before') !!}

                    <x-admin::accordion>
                        <x-slot:header>
                            {!! view_render_event('admin.properties.create.accordion.header.before') !!}

                            <div class="flex items-center justify-between">
                                <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                                    @lang('admin::properties.create.price')
                                </p>
                            </div>

                            {!! view_render_event('admin.properties.create.accordion.header.after') !!}
                        </x-slot>

                        <x-slot:content>
                            {!! view_render_event('admin.properties.create.accordion.content.attributes.before') !!}

                            <x-admin::attributes
                                :custom-attributes="app('Webkul\Attribute\Repositories\AttributeRepository')->findWhere([
                                    'entity_type' => 'properties',
                                    ['code', 'IN', ['price', 'quantity']],
                                ])"
                            />

                            {!! view_render_event('admin.properties.create.accordion.content.attributes.after') !!}
                        </x-slot>
                    </x-admin::accordion>

                    {!! view_render_event('admin.properties.create.accordion.before') !!}
                </div>
            </div>
        </div>
    </x-admin::form>

    {!! view_render_event('admin.properties.create.form.after') !!}
</x-admin::layouts>