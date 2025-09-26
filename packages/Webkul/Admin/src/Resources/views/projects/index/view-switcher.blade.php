{!! view_render_event('admin.projects.index.view_switcher.before') !!}

<div class="flex items-center gap-4 max-md:w-full max-md:!justify-between">
    <!-- View Type Switcher -->
    <div class="flex items-center gap-x-1 rounded-md border border-gray-200 bg-white p-1 dark:border-gray-800 dark:bg-gray-900">
        {!! view_render_event('admin.projects.index.view_switcher.kanban.before') !!}

        <!-- Kanban View -->
        <a
            href="{{ route('admin.projects.index', ['view_type' => 'kanban'] + request()->all()) }}"
            class="flex cursor-pointer items-center gap-1.5 rounded px-1.5 py-1 text-xs font-medium transition-all hover:bg-gray-100 dark:hover:bg-gray-800 {{ (request()->view_type ?? 'kanban') == 'kanban' ? 'bg-brandColor text-white' : 'text-gray-600 dark:text-gray-300' }}"
        >
            <span class="icon-kanban text-lg"></span>

            @lang('admin::app.projects.index.view-switcher.kanban')
        </a>

        {!! view_render_event('admin.projects.index.view_switcher.kanban.after') !!}

        {!! view_render_event('admin.projects.index.view_switcher.table.before') !!}

        <!-- Table View -->
        <a
            href="{{ route('admin.projects.index', ['view_type' => 'table'] + request()->all()) }}"
            class="flex cursor-pointer items-center gap-1.5 rounded px-1.5 py-1 text-xs font-medium transition-all hover:bg-gray-100 dark:hover:bg-gray-800 {{ request()->view_type == 'table' ? 'bg-brandColor text-white' : 'text-gray-600 dark:text-gray-300' }}"
        >
            <span class="icon-table text-lg"></span>

            @lang('admin::app.projects.index.view-switcher.table')
        </a>

        {!! view_render_event('admin.projects.index.view_switcher.table.after') !!}
    </div>
</div>

{!! view_render_event('admin.projects.index.view_switcher.after') !!}