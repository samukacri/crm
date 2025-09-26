{!! view_render_event('admin.projects.index.kanban.toolbar.before') !!}

<div class="flex justify-between gap-2 max-md:flex-wrap">
    <div class="flex w-full items-center gap-x-1.5 max-md:justify-between">
        {!! view_render_event('admin.projects.index.kanban.toolbar.search.before') !!}

        <!-- Search Panel -->
        @include('project::index.kanban.search')

        {!! view_render_event('admin.projects.index.kanban.toolbar.search.after') !!}

        {!! view_render_event('admin.projects.index.kanban.toolbar.filter.before') !!}

        <!-- Filter -->
        @include('project::index.kanban.filter')

        {!! view_render_event('admin.projects.index.kanban.toolbar.filter.after') !!}

        <div class="z-10 hidden w-full divide-y divide-gray-100 rounded bg-white shadow dark:bg-gray-900"></div>
    </div>

    {!! view_render_event('admin.projects.index.kanban.toolbar.switcher.before') !!}

    <!-- View Switcher -->
    <div class="flex items-center gap-x-1.5">
        <a 
            href="{{ route('admin.projects.index', ['view_type' => 'table']) }}"
            class="transparent-button px-1.5 py-1.5 {{ request('view_type', 'table') == 'table' ? 'active' : '' }}"
        >
            <span class="icon-list text-2xl"></span>
        </a>

        <a 
            href="{{ route('admin.projects.index', ['view_type' => 'kanban']) }}"
            class="transparent-button px-1.5 py-1.5 {{ request('view_type', 'table') == 'kanban' ? 'active' : '' }}"
        >
            <span class="icon-kanban text-2xl"></span>
        </a>
    </div>

    {!! view_render_event('admin.projects.index.kanban.toolbar.switcher.after') !!}
</div>

{!! view_render_event('admin.projects.index.kanban.toolbar.after') !!}