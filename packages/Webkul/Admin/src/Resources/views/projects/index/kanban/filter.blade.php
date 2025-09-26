{!! view_render_event('admin.projects.index.kanban.filter.before') !!}

<v-kanban-filter
    :is-loading="isLoading"
    :available="available"
    :applied="applied"
    @applyFilters="filter"
>
</v-kanban-filter>

{!! view_render_event('admin.projects.index.kanban.filter.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-kanban-filter-template"
    >
        {!! view_render_event('admin.projects.index.kanban.filter.drawer.before') !!}

        <x-admin::drawer
            width="350px"
            ref="kanbanFilterDrawer"
        >
            <!-- Drawer Toggler -->
            <x-slot:toggle>
                {!! view_render_event('admin.projects.index.kanban.filter.drawer.toggle_button.before') !!}

                <div class="relative flex cursor-pointer items-center rounded-md bg-sky-100 px-4 py-[9px] font-semibold text-sky-600 dark:bg-brandColor dark:text-white">
                    @lang('admin::app.projects.index.kanban.toolbar.filters.filter')

                    <span
                        class="absolute right-2 top-2 h-1.5 w-1.5 rounded-full bg-sky-600 dark:bg-white"
                        v-if="hasAnyAppliedColumn()"
                    >
                    </span>
                </div>

                {!! view_render_event('admin.projects.index.kanban.filter.drawer.toggle_button.after') !!}
            </x-slot>

            <!-- Drawer Header -->
            <x-slot:header class="p-3.5">
                {!! view_render_event('admin.projects.index.kanban.filter.drawer.header.title.before') !!}

                <div class="grid gap-3">
                    <div class="flex items-center justify-between">
                        <p class="text-xl font-semibold dark:text-white">
                            @lang('admin::app.projects.index.kanban.toolbar.filters.filters')
                        </p>
                    </div>
                </div>

                {!! view_render_event('admin.projects.index.kanban.filter.drawer.header.title.after') !!}
            </x-slot>

            <!-- Drawer Content -->
            <x-slot:content class="p-3.5">
                <div class="grid gap-4">
                    <!-- Name Filter -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                            @lang('admin::app.projects.index.name')
                        </label>
                        <input
                            type="text"
                            class="w-full rounded-lg border bg-white px-3 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                            placeholder="@lang('admin::app.projects.index.name')"
                            @input="addFilter('name', $event.target.value, 'text', 'like')"
                            :value="applied.find(filter => filter.column === 'name')?.value || ''"
                        >
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                            @lang('admin::app.projects.index.status')
                        </label>
                        <select
                            class="w-full rounded-lg border bg-white px-3 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                            @change="addFilter('status', $event.target.value, 'dropdown', 'eq')"
                            :value="applied.find(filter => filter.column === 'status')?.value || ''"
                        >
                            <option value="">@lang('admin::app.projects.index.all-statuses')</option>
                            <option value="active">@lang('admin::app.projects.index.active')</option>
                            <option value="completed">@lang('admin::app.projects.index.completed')</option>
                            <option value="cancelled">@lang('admin::app.projects.index.cancelled')</option>
                        </select>
                    </div>

                    <!-- Organization Filter -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                            @lang('admin::app.projects.index.organization')
                        </label>
                        <v-kanban-searchable-dropdown
                            :url="'{{ route('admin.projects.kanban.lookup', ['type' => 'organizations']) }}'"
                            :placeholder="'@lang('admin::app.projects.index.select-organization')'"
                            :value="applied.find(filter => filter.column === 'organization_id')?.value || []"
                            @on-selected="(value) => addFilter('organization_id', value, 'searchable_dropdown', 'eq')"
                        ></v-kanban-searchable-dropdown>
                    </div>

                    <!-- Product Filter -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                            @lang('admin::app.projects.index.product')
                        </label>
                        <v-kanban-searchable-dropdown
                            :url="'{{ route('admin.projects.kanban.lookup', ['type' => 'products']) }}'"
                            :placeholder="'@lang('admin::app.projects.index.select-product')'"
                            :value="applied.find(filter => filter.column === 'product_id')?.value || []"
                            @on-selected="(value) => addFilter('product_id', value, 'searchable_dropdown', 'eq')"
                        ></v-kanban-searchable-dropdown>
                    </div>

                    <!-- Assigned To Filter -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                            @lang('admin::app.projects.index.assigned-to')
                        </label>
                        <v-kanban-searchable-dropdown
                            :url="'{{ route('admin.projects.kanban.lookup', ['type' => 'users']) }}'"
                            :placeholder="'@lang('admin::app.projects.index.select-user')'"
                            :value="applied.find(filter => filter.column === 'owner_id')?.value || []"
                            @on-selected="(value) => addFilter('owner_id', value, 'searchable_dropdown', 'eq')"
                        ></v-kanban-searchable-dropdown>
                    </div>

                    <!-- Date Range Filter -->
                    <div>
                        <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                            @lang('admin::app.projects.index.date-range')
                        </label>
                        <div class="flex gap-2">
                            <input
                                type="date"
                                class="w-full rounded-lg border bg-white px-3 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                @change="addFilter('start_date', $event.target.value, 'date_range', 'gte')"
                                :value="applied.find(filter => filter.column === 'start_date')?.value || ''"
                                placeholder="@lang('admin::app.projects.index.start-date')"
                            >
                            <input
                                type="date"
                                class="w-full rounded-lg border bg-white px-3 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                @change="addFilter('end_date', $event.target.value, 'date_range', 'lte')"
                                :value="applied.find(filter => filter.column === 'end_date')?.value || ''"
                                placeholder="@lang('admin::app.projects.index.end-date')"
                            >
                        </div>
                    </div>
                </div>
            </x-slot>
        </x-admin::drawer>

        {!! view_render_event('admin.projects.index.kanban.filter.drawer.after') !!}
    </script>

    <script type="module">
        app.component('v-kanban-filter', {
            template: '#v-kanban-filter-template',

            props: ['isLoading', 'available', 'applied'],

            emits: ['applyFilters'],

            methods: {
                hasAnyAppliedColumn() {
                    return this.applied.length > 0;
                },
            },
        });
    </script>
@endPushOnce