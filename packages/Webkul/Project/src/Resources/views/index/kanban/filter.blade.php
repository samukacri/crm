{!! view_render_event('admin.projects.index.kanban.filter.before') !!}

<!-- Filter -->
<div class="relative">
    <x-admin::dropdown position="bottom-left">
        <x-slot:toggle>
            <button class="transparent-button px-1.5 py-1.5 hover:bg-gray-200 dark:hover:bg-gray-800">
                <span class="icon-filter text-2xl"></span>
            </button>
        </x-slot>

        <x-slot:content class="!p-0">
            <div class="w-full min-w-[300px] rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-center justify-between p-4">
                    <p class="text-base font-semibold text-gray-800 dark:text-white">
                        @lang('project::app.filters')
                    </p>

                    <p
                        class="cursor-pointer text-xs font-medium text-blue-600 transition-all hover:underline"
                        @click="clearAllFilters"
                    >
                        @lang('project::app.clear-all')
                    </p>
                </div>

                <div class="border-t border-gray-200 p-4 dark:border-gray-800">
                    <div class="flex flex-col gap-2">
                        <!-- Organization Filter -->
                        <div class="mb-4">
                            <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                                @lang('project::app.organization')
                            </label>

                            <v-kanban-searchable-dropdown
                                :url="'{{ route('admin.projects.kanban.lookup', ['type' => 'organizations']) }}'"
                                :placeholder="'@lang('project::app.select-organization')'"
                                :value="applied.filters.columns.find(column => column.index === 'organization_id')?.value || []"
                                @on-selected="(value) => addFilter('organization_id', value, 'searchable_dropdown', 'eq')"
                            ></v-kanban-searchable-dropdown>
                        </div>

                        <!-- Product Filter -->
                        <div class="mb-4">
                            <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                                @lang('project::app.product')
                            </label>

                            <v-kanban-searchable-dropdown
                                :url="'{{ route('admin.projects.kanban.lookup', ['type' => 'products']) }}'"
                                :placeholder="'@lang('project::app.select-product')'"
                                :value="applied.filters.columns.find(column => column.index === 'product_id')?.value || []"
                                @on-selected="(value) => addFilter('product_id', value, 'searchable_dropdown', 'eq')"
                            ></v-kanban-searchable-dropdown>
                        </div>

                        <!-- Status Filter -->
                        <div class="mb-4">
                            <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                                @lang('project::app.status')
                            </label>

                            <select
                                class="w-full rounded-lg border bg-white px-3 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                @change="addFilter('status', [$event.target.value], 'dropdown', 'eq')"
                            >
                                <option value="">@lang('project::app.all-statuses')</option>
                                <option value="active">@lang('project::app.active')</option>
                                <option value="completed">@lang('project::app.completed')</option>
                                <option value="cancelled">@lang('project::app.cancelled')</option>
                            </select>
                        </div>

                        <!-- User Filter -->
                        <div class="mb-4">
                            <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                                @lang('project::app.assigned-to')
                            </label>

                            <v-kanban-searchable-dropdown
                                :url="'{{ route('admin.projects.kanban.lookup', ['type' => 'users']) }}'"
                                :placeholder="'@lang('project::app.select-user')'"
                                :value="applied.filters.columns.find(column => column.index === 'user_id')?.value || []"
                                @on-selected="(value) => addFilter('user_id', value, 'searchable_dropdown', 'eq')"
                            ></v-kanban-searchable-dropdown>
                        </div>

                        <!-- Date Range Filter -->
                        <div class="mb-4">
                            <label class="mb-1.5 block text-xs font-medium text-gray-800 dark:text-white">
                                @lang('project::app.date-range')
                            </label>

                            <div class="flex gap-2">
                                <input
                                    type="date"
                                    class="w-full rounded-lg border bg-white px-3 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                    @change="addFilter('start_date', [$event.target.value], 'date_range', 'gte')"
                                    placeholder="@lang('project::app.start-date')"
                                >

                                <input
                                    type="date"
                                    class="w-full rounded-lg border bg-white px-3 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                                    @change="addFilter('end_date', [$event.target.value], 'date_range', 'lte')"
                                    placeholder="@lang('project::app.end-date')"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-admin::dropdown>
</div>

{!! view_render_event('admin.projects.index.kanban.filter.after') !!}