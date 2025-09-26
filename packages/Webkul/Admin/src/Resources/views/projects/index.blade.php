<x-admin::layouts>
    <x-slot:title>
        @lang('admin::app.projects.index.title')
    </x-slot>

    <div class="flex flex-col gap-4">
        {!! view_render_event('admin.projects.index.header.before') !!}

        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                <div class="flex cursor-pointer items-center">
                    {!! view_render_event('admin.projects.index.breadcrumbs.before') !!}

                    <!-- Breadcrumbs -->
                    <x-admin::breadcrumbs name="projects.index" />

                    {!! view_render_event('admin.projects.index.breadcrumbs.after') !!}
                </div>

                <div class="text-xl font-bold dark:text-white">
                    @lang('admin::app.projects.index.title')
                </div>
            </div>

            <div class="flex items-center gap-x-2.5">
                {!! view_render_event('admin.projects.index.header.create_button.before') !!}

                <div class="flex items-center gap-x-2.5">
                    <!-- Export Modal -->
                    @if (request('view_type') == 'table')
                        <x-admin::datagrid.export src="{{ route('admin.projects.index') }}" />
                    @endif

                    <!-- Create Project Button -->
                    @if (bouncer()->hasPermission('projects.create'))
                        <a
                            href="{{ route('admin.projects.create') }}"
                            class="primary-button"
                        >
                            @lang('admin::app.projects.index.create-btn')
                        </a>
                    @endif
                </div>

                {!! view_render_event('admin.projects.index.header.create_button.after') !!}
            </div>
        </div>

        {!! view_render_event('admin.projects.index.header.after') !!}

        {!! view_render_event('admin.projects.index.content.before') !!}

        <!-- Content -->
        <div class="[&>*>*>*.toolbarRight]:max-lg:w-full [&>*>*>*.toolbarRight]:max-lg:justify-between [&>*>*>*.toolbarRight]:max-md:gap-y-2 [&>*>*>*.toolbarRight]:max-md:flex-wrap mt-3.5 [&>*>*:nth-child(1)]:max-lg:!flex-wrap">
            @if ((request()->view_type ?? "kanban") == "table")
                @include('admin::projects.index.table')
            @else
                @include('admin::projects.index.kanban')
            @endif
        </div>

        {!! view_render_event('admin.projects.index.content.after') !!}
    </div>
</x-admin::layouts>