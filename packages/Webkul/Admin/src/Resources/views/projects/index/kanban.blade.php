{!! view_render_event('admin.projects.index.kanban.before') !!}

<!-- Kanban Vue Component -->
<v-projects-kanban ref="projectsKanban">
    <div class="flex flex-col gap-4">
        <!-- Shimmer -->
        <x-admin::shimmer.leads.index.kanban />
    </div>
</v-projects-kanban>

{!! view_render_event('admin.projects.index.kanban.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-projects-kanban-template"
    >
        <template v-if="isLoading">
            <div class="flex flex-col gap-4">
                <x-admin::shimmer.leads.index.kanban />
            </div>
        </template>

        <template v-else>
            <div class="flex flex-col gap-4">
                @include('admin::projects.index.kanban.toolbar')

                {!! view_render_event('admin.projects.index.kanban.content.before') !!}

                <div class="flex gap-2.5 overflow-x-auto">

            <!-- Kanban Stages -->
            <div
                class="flex min-w-80 max-w-80 flex-col rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900"
                v-for="(stageProjects, index) in stageProjects"
                :key="index"
            >
                {!! view_render_event('admin.projects.index.kanban.content.stage.before') !!}

                <!-- Stage Header -->
                <div class="flex items-center justify-between border-b border-gray-200 p-4 dark:border-gray-800">
                    <div class="flex items-center gap-2.5">
                        <h3 class="text-base font-semibold dark:text-white">
                            @{{ stageProjects.stage.name }}
                        </h3>

                        <span class="rounded-full bg-gray-200 px-2 py-1 text-xs font-medium dark:bg-gray-800 dark:text-white">
                            @{{ stageProjects.projects.data.length }}
                        </span>
                    </div>

                    @if (bouncer()->hasPermission('projects.create'))
                        <a
                            :href="'{{ route('admin.projects.create') }}?stage_id=' + stageProjects.stage.id"
                            class="flex h-7 w-7 cursor-pointer items-center justify-center rounded-md border border-transparent text-brandColor transition-all hover:bg-gray-100 dark:hover:bg-gray-950"
                        >
                            <i class="icon-add text-md"></i>
                        </a>
                    @endif
                </div>

                <!-- Stage Body -->
                <div class="flex flex-1 flex-col gap-2 p-4">
                    {!! view_render_event('admin.projects.index.kanban.content.stage.body.before') !!}

                    <!-- Project Card -->
                    <div
                        class="project-item flex cursor-pointer flex-col gap-3 rounded-md border border-gray-100 bg-gray-50 p-3 dark:border-gray-400 dark:bg-gray-400"
                        v-for="project in stageProjects.projects.data"
                        :key="project.id"
                    >
                        {!! view_render_event('admin.projects.index.kanban.content.stage.body.card.before') !!}

                        <a
                            :href="'{{ route('admin.projects.show', 'replaceId') }}'.replace('replaceId', project.id)"
                            class="flex flex-col gap-3"
                        >
                            {!! view_render_event('admin.projects.index.kanban.content.stage.body.card.header.before') !!}

                            <!-- Header -->
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-2">
                                    <x-admin::avatar ::name="project.name" />

                                    <div class="flex flex-col gap-0.5">
                                        <p class="text-xs font-medium dark:text-white">
                                            @{{ project.name }}
                                        </p>

                                        <p class="text-xs text-gray-500 dark:text-gray-300" v-if="project.organization">
                                            @{{ project.organization.name }}
                                        </p>
                                    </div>
                                </div>

                                <div class="relative" v-if="project.status">
                                    <span
                                        class="rounded-full px-2 py-1 text-xs font-medium"
                                        :class="{
                                            'bg-green-100 text-green-800': project.status === 'active',
                                            'bg-blue-100 text-blue-800': project.status === 'completed',
                                            'bg-red-100 text-red-800': project.status === 'cancelled'
                                        }"
                                    >
                                        @{{ project.status }}
                                    </span>
                                </div>
                            </div>

                            {!! view_render_event('admin.projects.index.kanban.content.stage.body.card.header.after') !!}

                            {!! view_render_event('admin.projects.index.kanban.content.stage.body.card.title.before') !!}

                            <!-- Project Description -->
                            <p class="text-xs text-gray-600 dark:text-gray-300" v-if="project.description">
                                @{{ project.description }}
                            </p>

                            {!! view_render_event('admin.projects.index.kanban.content.stage.body.card.title.after') !!}

                            <div class="flex flex-wrap gap-1">
                                <div
                                    class="flex items-center gap-1 rounded-xl bg-gray-200 px-2 py-1 text-xs font-medium dark:bg-gray-800 dark:text-white"
                                    v-if="project.user"
                                >
                                    <span class="icon-settings-user text-sm"></span>

                                    @{{ project.user.name }}
                                </div>

                                <div
                                    class="flex items-center gap-1 rounded-xl bg-gray-200 px-2 py-1 text-xs font-medium dark:bg-gray-800 dark:text-white"
                                    v-if="project.product"
                                >
                                    <span class="icon-product text-sm"></span>

                                    @{{ project.product.name }}
                                </div>

                                <div
                                    class="flex items-center gap-1 rounded-xl bg-gray-200 px-2 py-1 text-xs font-medium dark:bg-gray-800 dark:text-white"
                                    v-for="tag in project.tags"
                                    :key="tag.id"
                                >
                                    <span class="icon-tag text-sm"></span>

                                    @{{ tag.name }}
                                </div>
                            </div>
                        </a>

                        {!! view_render_event('admin.projects.index.kanban.content.stage.body.card.after') !!}
                    </div>

                    {!! view_render_event('admin.projects.index.kanban.content.stage.body.after') !!}
                </div>

                {!! view_render_event('admin.projects.index.kanban.content.stage.after') !!}
            </div>

                {!! view_render_event('admin.projects.index.kanban.content.after') !!}
                </div>
            </div>
        </template>
    </script>

    <script type="module">
        app.component('v-projects-kanban', {
            template: '#v-projects-kanban-template',

            data() {
                return {
                    isLoading: true,
                    stageProjects: {},
                    available: {},
                    applied: [],
                };
            },

            mounted() {
                this.get();
            },

            methods: {
                /**
                 * Get projects for kanban.
                 *
                 * @param {object} params - The parameters to be passed.
                 * @returns {void}
                 */
                get(params = {}) {
                    this.isLoading = true;
                    
                    return this.$axios.get('{{ route('admin.projects.get') }}', {
                        params: {
                            ...params,
                        }
                    })
                        .then(response => {
                            this.stageProjects = response.data;
                            this.isLoading = false;
                            return response;
                        })
                        .catch(error => {
                            console.error('Error fetching projects:', error);
                            this.isLoading = false;
                        });
                },

                /**
                 * Appends the projects to the stage.
                 *
                 * @param {object} params - The parameters to be appended.
                 * @returns {void}
                 */
                append(params) {
                    this.get(params)
                        .then(response => {
                            for (let [sortOrder, data] of Object.entries(response.data)) {
                                if (! this.stageProjects[sortOrder]) {
                                    this.stageProjects[sortOrder] = data;
                                } else {
                                    this.stageProjects[sortOrder].projects.data = this.stageProjects[sortOrder].projects.data.concat(data.projects.data);

                                    this.stageProjects[sortOrder].projects.meta = data.projects.meta;
                                }
                            }
                        });
                },

                /**
                 * Search projects.
                 *
                 * @param {object} params - The search parameters.
                 * @returns {void}
                 */
                search(params) {
                    this.get(params);
                },

                /**
                 * Filter projects.
                 *
                 * @param {object} params - The filter parameters.
                 * @returns {void}
                 */
                filter(params) {
                    this.get(params);
                },
            },
        });
    </script>
@endPushOnce

{!! view_render_event('admin.projects.index.kanban.after') !!}