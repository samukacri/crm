<x-admin::layouts>
    <x-slot:title>
        @lang('project::app.projects.index.title')
    </x-slot>

    <!-- Header -->
    {!! view_render_event('admin.projects.index.header.before') !!}

    <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
        {!! view_render_event('admin.projects.index.header.left.before') !!}

        <div class="flex flex-col gap-2">
            <!-- Breadcrumb's -->
            <x-admin::breadcrumbs name="projects" />

            <div class="text-xl font-bold dark:text-white">
                @lang('project::app.projects.index.title')
            </div>
        </div>

        {!! view_render_event('admin.projects.index.header.left.after') !!}

        {!! view_render_event('admin.projects.index.header.right.before') !!}

        <div class="flex items-center gap-x-2.5">
            @if ((request()->view_type ?? "kanban") == "table")
                <!-- Export Modal -->
                <x-admin::datagrid.export :src="route('admin.projects.index')" />
            @endif

            <!-- Create button for Projects -->
            <div class="flex items-center gap-x-2.5">
                @if (bouncer()->hasPermission('projects.create'))
                    <a
                        href="{{ route('admin.projects.create') }}"
                        class="primary-button"
                    >
                        @lang('project::app.projects.index.create-btn')
                    </a>
                @endif
            </div>
        </div>

        {!! view_render_event('admin.projects.index.header.right.after') !!}
    </div>

    {!! view_render_event('admin.projects.index.header.after') !!}

    {!! view_render_event('admin.projects.index.content.before') !!}

    <!-- Content -->
    <div class="[&>*>*>*.toolbarRight]:max-lg:w-full [&>*>*>*.toolbarRight]:max-lg:justify-between [&>*>*>*.toolbarRight]:max-md:gap-y-2 [&>*>*>*.toolbarRight]:max-md:flex-wrap mt-3.5 [&>*>*:nth-child(1)]:max-lg:!flex-wrap">
        @if ((request()->view_type ?? "kanban") == "table")
            @include('project::projects.index.table')
        @else
            @include('project::projects.index.kanban')
        @endif
    </div>

    {!! view_render_event('admin.projects.index.content.after') !!}
</x-admin::layouts>