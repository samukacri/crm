{!! view_render_event('admin.projects.index.table.before') !!}

<x-admin::datagrid :src="route('admin.projects.index')">
    <!-- DataGrid Shimmer -->
    <x-admin::shimmer.datagrid />

    <x-slot:toolbar-right-after>
        @include('project::projects.index.view-switcher')
    </x-slot>
</x-admin::datagrid>

{!! view_render_event('admin.projects.index.table.after') !!}