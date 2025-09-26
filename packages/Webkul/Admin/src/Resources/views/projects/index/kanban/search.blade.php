{!! view_render_event('admin.projects.index.kanban.search.before') !!}

<v-kanban-search
    :is-loading="isLoading"
    :available="available"
    :applied="applied"
    @search="search"
>
</v-kanban-search>

{!! view_render_event('admin.projects.index.kanban.search.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-kanban-search-template"
    >
        <div class="relative flex max-w-[445px] items-center max-md:w-full max-md:max-w-full">
            <div class="icon-search absolute top-1.5 flex items-center text-2xl ltr:left-3 rtl:right-3"></div>

            <input
                type="text"
                name="search"
                class="block w-full rounded-lg border bg-white py-1.5 leading-6 text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400 ltr:pl-10 ltr:pr-3 rtl:pl-3 rtl:pr-10"
                placeholder="@lang('admin::app.projects.index.kanban.toolbar.search.title')"
                autocomplete="off"
                :value="getSearchedValues()"
                @keyup.enter="search"
            >
        </div>
    </script>

    <script type="module">
        app.component('v-kanban-search', {
            template: '#v-kanban-search-template',

            props: ['isLoading', 'available', 'applied'],

            emits: ['search'],

            methods: {
                search(e) {
                    this.$emit('search', {
                        column: 'all',
                        value: e.target.value,
                    });
                },

                getSearchedValues() {
                    const appliedColumn = this.applied.find(column => column.column === 'all');

                    return appliedColumn ? appliedColumn.value : '';
                },
            },
        });
    </script>
@endPushOnce