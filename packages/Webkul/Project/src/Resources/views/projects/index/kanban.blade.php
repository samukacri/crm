<x-admin::layouts>
    <x-slot:title>
        @lang('project::app.projects')
    </x-slot>

    <v-project-kanban>
        <!-- Toolbar -->
        @include('project::index.kanban.toolbar')

        <!-- Kanban Board -->
        <div class="flex gap-4 overflow-x-auto pb-4">
            <div 
                v-for="(projects, status) in kanbanProjects" 
                :key="status"
                class="min-w-[300px] flex-1 rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900"
            >
                <div class="border-b border-gray-200 px-4 py-3 dark:border-gray-800">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold capitalize dark:text-white">
                            @{{ status.replace('_', ' ') }}
                        </h3>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            @{{ projects.length }} @lang('project::app.projects')
                        </span>
                    </div>
                </div>

                <div class="p-4">
                    <div 
                        v-if="projects.length === 0" 
                        class="text-center text-gray-500 dark:text-gray-400 py-8"
                    >
                        @lang('project::app.no-projects-found')
                    </div>

                    <div 
                        v-for="project in projects" 
                        :key="project.id"
                        class="mb-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900"
                    >
                        <div class="mb-2 flex items-start justify-between">
                            <h4 class="font-medium text-gray-800 dark:text-white">
                                <a :href="`{{ route('admin.projects.show', '') }}/${project.id}`" class="hover:text-blue-600">
                                    @{{ project.name }}
                                </a>
                            </h4>
                            <span 
                                :class="{
                                    'bg-green-100 text-green-600': project.status === 'active',
                                    'bg-blue-100 text-blue-600': project.status === 'completed',
                                    'bg-red-100 text-red-600': project.status === 'cancelled'
                                }"
                                class="inline-flex rounded-full px-2 py-1 text-xs font-medium"
                            >
                                @{{ project.status }}
                            </span>
                        </div>

                        <p v-if="project.description" class="mb-3 text-sm text-gray-600 dark:text-gray-400">
                            @{{ project.description.substring(0, 100) }}
                            <span v-if="project.description.length > 100">...</span>
                        </p>

                        <div class="flex flex-wrap gap-2 text-xs text-gray-600 dark:text-gray-400">
                            <span v-if="project.organization" class="flex items-center gap-1">
                                <span class="icon-building text-sm"></span>
                                @{{ project.organization.name }}
                            </span>
                            
                            <span v-if="project.product" class="flex items-center gap-1">
                                <span class="icon-product text-sm"></span>
                                @{{ project.product.name }}
                            </span>
                            
                            <span v-if="project.user" class="flex items-center gap-1">
                                <span class="icon-user text-sm"></span>
                                @{{ project.user.name }}
                            </span>
                        </div>

                        <div v-if="project.start_date || project.end_date" class="mt-3 flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                            <span v-if="project.start_date" class="flex items-center gap-1">
                                <span class="icon-calendar text-sm"></span>
                                @{{ new Date(project.start_date).toLocaleDateString() }}
                            </span>
                            
                            <span v-if="project.end_date" class="flex items-center gap-1">
                                <span class="icon-calendar-deadline text-sm"></span>
                                @{{ new Date(project.end_date).toLocaleDateString() }}
                            </span>
                        </div>

                        <div class="mt-3 flex justify-end gap-2">
                            <a 
                                :href="`{{ route('admin.projects.edit', '') }}/${project.id}`"
                                class="text-blue-600 hover:text-blue-800 text-sm"
                            >
                                @lang('project::app.edit')
                            </a>
                            
                            <a 
                                :href="`{{ route('admin.projects.show', '') }}/${project.id}`"
                                class="text-green-600 hover:text-green-800 text-sm"
                            >
                                @lang('project::app.view')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </v-project-kanban>

    @pushOnce('scripts')
        <script type="text/x-template" id="v-project-kanban-template">
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                    <div class="flex flex-col gap-2">
                        <x-admin::breadcrumbs name="projects.index" />

                        <p class="text-xl font-bold dark:text-white">
                            @lang('project::app.projects')
                        </p>
                    </div>

                    <div class="flex items-center gap-x-2.5">
                        <a href="{{ route('admin.projects.create') }}" class="primary-button">
                            @lang('project::app.add-project')
                        </a>
                    </div>
                </div>

                <!-- Toolbar -->
                <v-project-kanban-toolbar
                    :is-loading="isLoading"
                    :available="available"
                    :applied="applied"
                    @search="search($event)"
                    @filter="filter($event)"
                ></v-project-kanban-toolbar>

                <!-- Kanban Board -->
                <div class="flex gap-4 overflow-x-auto pb-4">
                    <div 
                        v-for="(projects, status) in kanbanProjects" 
                        :key="status"
                        class="min-w-[300px] flex-1 rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900"
                    >
                        <div class="border-b border-gray-200 px-4 py-3 dark:border-gray-800">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold capitalize dark:text-white">
                                    @{{ status.replace('_', ' ') }}
                                </h3>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    @{{ projects.length }} @lang('project::app.projects')
                                </span>
                            </div>
                        </div>

                        <div class="p-4">
                            <div 
                                v-if="projects.length === 0" 
                                class="text-center text-gray-500 dark:text-gray-400 py-8"
                            >
                                @lang('project::app.no-projects-found')
                            </div>

                            <div 
                                v-for="project in projects" 
                                :key="project.id"
                                class="mb-3 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900"
                            >
                                <div class="mb-2 flex items-start justify-between">
                                    <h4 class="font-medium text-gray-800 dark:text-white">
                                        <a :href="`{{ route('admin.projects.show', '') }}/${project.id}`" class="hover:text-blue-600">
                                            @{{ project.name }}
                                        </a>
                                    </h4>
                                    <span 
                                        :class="{
                                            'bg-green-100 text-green-600': project.status === 'active',
                                            'bg-blue-100 text-blue-600': project.status === 'completed',
                                            'bg-red-100 text-red-600': project.status === 'cancelled'
                                        }"
                                        class="inline-flex rounded-full px-2 py-1 text-xs font-medium"
                                    >
                                        @{{ project.status }}
                                    </span>
                                </div>

                                <p v-if="project.description" class="mb-3 text-sm text-gray-600 dark:text-gray-400">
                                    @{{ project.description.substring(0, 100) }}
                                    <span v-if="project.description.length > 100">...</span>
                                </p>

                                <div class="flex flex-wrap gap-2 text-xs text-gray-600 dark:text-gray-400">
                                    <span v-if="project.organization" class="flex items-center gap-1">
                                        <span class="icon-building text-sm"></span>
                                        @{{ project.organization.name }}
                                    </span>
                                    
                                    <span v-if="project.product" class="flex items-center gap-1">
                                        <span class="icon-product text-sm"></span>
                                        @{{ project.product.name }}
                                    </span>
                                    
                                    <span v-if="project.user" class="flex items-center gap-1">
                                        <span class="icon-user text-sm"></span>
                                        @{{ project.user.name }}
                                    </span>
                                </div>

                                <div v-if="project.start_date || project.end_date" class="mt-3 flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                    <span v-if="project.start_date" class="flex items-center gap-1">
                                        <span class="icon-calendar text-sm"></span>
                                        @{{ new Date(project.start_date).toLocaleDateString() }}
                                    </span>
                                    
                                    <span v-if="project.end_date" class="flex items-center gap-1">
                                        <span class="icon-calendar-deadline text-sm"></span>
                                        @{{ new Date(project.end_date).toLocaleDateString() }}
                                    </span>
                                </div>

                                <div class="mt-3 flex justify-end gap-2">
                                    <a 
                                        :href="`{{ route('admin.projects.edit', '') }}/${project.id}`"
                                        class="text-blue-600 hover:text-blue-800 text-sm"
                                    >
                                        @lang('project::app.edit')
                                    </a>
                                    
                                    <a 
                                        :href="`{{ route('admin.projects.show', '') }}/${project.id}`"
                                        class="text-green-600 hover:text-green-800 text-sm"
                                    >
                                        @lang('project::app.view')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            app.component('v-project-kanban', {
                template: '#v-project-kanban-template',

                data() {
                    return {
                        isLoading: false,
                        
                        kanbanProjects: {
                            active: [],
                            completed: [],
                            cancelled: []
                        },

                        available: {
                            columns: []
                        },

                        applied: {
                            filters: {
                                columns: []
                            }
                        },

                        searchTerm: ''
                    };
                },

                mounted() {
                    this.getColumns();
                    this.get();
                },

                methods: {
                    /**
                     * Get kanban columns.
                     */
                    getColumns() {
                        this.$axios.get("{{ route('admin.projects.kanban.columns') }}")
                            .then(response => {
                                this.available.columns = response.data;
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    },

                    /**
                     * Get projects.
                     */
                    get(requestedParams = {}) {
                        this.isLoading = true;

                        let params = {
                            search: '',
                            searchFields: '',
                            view_type: 'kanban',
                            limit: 10,
                        };

                        // Add search term
                        if (this.searchTerm) {
                            params['search'] = `name:${this.searchTerm};`;
                            params['searchFields'] = 'name:like;';
                        }

                        this.applied.filters.columns.forEach((column) => {
                            if (column.index === 'all') {
                                if (! column.value.length) {
                                    return;
                                }

                                params['search'] += `name:${column.value.join(',')};`;
                                params['searchFields'] += `name:like;`;

                                return;
                            }

                            params['search'] += column.filterable_type === 'searchable_dropdown'
                                ? `${column.index}:${column.value.map(option => option.value).join(',')};`
                                : `${column.index}:${column.value.join(',')};`;

                            params['searchFields'] += `${column.index}:${column.search_field};`;
                        });

                        return this.$axios
                            .get("{{ route('admin.projects.get') }}", {
                                params: {
                                    ...params,
                                    ...requestedParams,
                                }
                            })
                            .then(response => {
                                this.isLoading = false;
                                this.kanbanProjects = response.data;
                                return response;
                            })
                            .catch(error => {
                                this.isLoading = false;
                                console.error(error);
                            });
                    },

                    /**
                     * Filter projects.
                     */
                    filter(filters) {
                        this.applied.filters.columns = [
                            ...(this.applied.filters.columns.filter((column) => column.index === 'all')),
                            ...filters.columns,
                        ];

                        this.get();
                    },

                    /**
                     * Search projects.
                     */
                    search(filters) {
                        this.applied.filters.columns = [
                            ...(this.applied.filters.columns.filter((column) => column.index !== 'all')),
                            ...filters.columns,
                        ];

                        this.get();
                    },

                    /**
                     * Clear search.
                     */
                    clear() {
                        this.searchTerm = '';
                        this.get();
                    },

                    /**
                     * Clear all filters.
                     */
                    clearAllFilters() {
                        this.applied.filters.columns = [];
                        this.searchTerm = '';
                        this.get();
                    },

                    /**
                     * Add filter.
                     */
                    addFilter(index, value, type, searchField) {
                        const existingFilter = this.applied.filters.columns.find(column => column.index === index);
                        
                        if (existingFilter) {
                            existingFilter.value = value;
                        } else {
                            this.applied.filters.columns.push({
                                index: index,
                                value: value,
                                filterable_type: type,
                                search_field: searchField
                            });
                        }

                        this.get();
                    }
                }
            });
        </script>
    @endPushOnce
</x-admin::layouts>