{!! view_render_event('admin.projects.index.kanban.search.before') !!}

<!-- Search Panel -->
<div class="flex w-full items-center gap-x-1.5 max-md:flex-wrap">
    <div class="relative w-full">
        <div class="relative w-full">
            <div class="icon-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xl text-gray-600 dark:text-gray-300"></div>

            <input
                type="text"
                class="w-full rounded-lg border bg-white px-10 py-2.5 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
                placeholder="@lang('project::app.search-here')"
                v-model.lazy="searchTerm"
                v-debounce="500"
            >

            <div
                class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2"
                v-if="isLoading"
            >
                <div class="icon-spinner mx-auto h-5 w-5 animate-spin text-2xl"></div>
            </div>

            <div
                class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2"
                v-if="! isLoading && searchTerm.length"
            >
                <div
                    class="icon-cross cursor-pointer text-2xl"
                    @click="clear"
                ></div>
            </div>
        </div>
    </div>
</div>

{!! view_render_event('admin.projects.index.kanban.search.after') !!}