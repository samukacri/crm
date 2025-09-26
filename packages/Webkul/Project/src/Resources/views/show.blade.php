<x-admin::layouts>
    <x-slot:title>
        {{ __('project::app.view-project') }}
    </x-slot>

    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                <x-admin::breadcrumbs
                    name="projects.view"
                    :entity="$project"
                />

                <div class="text-xl font-bold dark:text-white">
                    {{ $project->name }}
                </div>
            </div>

            <div class="flex items-center gap-x-2.5">
                <a 
                    href="{{ route('admin.projects.edit', $project->id) }}" 
                    class="primary-button"
                >
                    {{ __('project::app.edit') }}
                </a>
            </div>
        </div>

        <div class="box-shadow flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <div class="grid grid-cols-2 gap-4">
                <!-- Nome do Projeto -->
                <div class="flex flex-col gap-1.5">
                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('project::app.name') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $project->name }}
                    </p>
                </div>

                <!-- Descrição -->
                <div class="flex flex-col gap-1.5">
                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('project::app.description') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $project->description ?? '-' }}
                    </p>
                </div>

                <!-- Status -->
                <div class="flex flex-col gap-1.5">
                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('project::app.status') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <span class="badge badge-{{ $project->status }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </p>
                </div>

                <!-- Data de Início -->
                <div class="flex flex-col gap-1.5">
                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('project::app.start-date') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $project->start_date ? date('d/m/Y', strtotime($project->start_date)) : '-' }}
                    </p>
                </div>

                <!-- Data de Término -->
                <div class="flex flex-col gap-1.5">
                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('project::app.end-date') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $project->end_date ? date('d/m/Y', strtotime($project->end_date)) : '-' }}
                    </p>
                </div>

                <!-- Organização -->
                <div class="flex flex-col gap-1.5">
                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('project::app.organization') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $project->organization ? $project->organization->name : '-' }}
                    </p>
                </div>

                <!-- Produto -->
                <div class="flex flex-col gap-1.5">
                    <p class="text-sm font-medium text-gray-800 dark:text-white">
                        {{ __('project::app.product') }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $project->product ? $project->product->name : '-' }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Tasks Section -->
        <div class="box-shadow flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <div class="flex items-center justify-between">
                <p class="text-base font-medium text-gray-800 dark:text-white">
                    {{ __('project::app.tasks') }}
                </p>
                
                <a href="#" class="primary-button">
                    {{ __('project::app.add-task') }}
                </a>
            </div>
            
            <div class="overflow-auto">
                @if($project->tasks->count())
                    <x-admin::datagrid
                        :rows="$project->tasks"
                        class="border-none"
                    >
                        <x-slot:header>
                            <x-admin::table.thead>
                                <x-admin::table.thead.tr>
                                    <x-admin::table.th>{{ __('project::app.title') }}</x-admin::table.th>
                                    <x-admin::table.th>{{ __('project::app.status') }}</x-admin::table.th>
                                    <x-admin::table.th>{{ __('project::app.priority') }}</x-admin::table.th>
                                    <x-admin::table.th>{{ __('project::app.due-date') }}</x-admin::table.th>
                                    <x-admin::table.th>{{ __('project::app.assignee') }}</x-admin::table.th>
                                    <x-admin::table.th>{{ __('project::app.actions') }}</x-admin::table.th>
                                </x-admin::table.thead.tr>
                            </x-admin::table.thead>
                        </x-slot:header>
                        
                        <x-slot:body>
                            <x-admin::table.tbody>
                                @foreach($project->tasks as $task)
                                    <x-admin::table.tbody.tr>
                                        <x-admin::table.td>{{ $task->title }}</x-admin::table.td>
                                        <x-admin::table.td>
                                            <span class="badge badge-{{ $task->status }}">
                                                {{ ucfirst(__('project::app.' . $task->status)) }}
                                            </span>
                                        </x-admin::table.td>
                                        <x-admin::table.td>
                                            <span class="badge badge-{{ $task->priority }}">
                                                {{ ucfirst(__('project::app.' . $task->priority)) }}
                                            </span>
                                        </x-admin::table.td>
                                        <x-admin::table.td>{{ $task->due_date ? date('d/m/Y', strtotime($task->due_date)) : '-' }}</x-admin::table.td>
                                        <x-admin::table.td>{{ $task->assignee ? $task->assignee->name : '-' }}</x-admin::table.td>
                                        <x-admin::table.td>
                                            <a href="#" class="text-blue-600 hover:underline">
                                                {{ __('project::app.view') }}
                                            </a>
                                        </x-admin::table.td>
                                    </x-admin::table.tbody.tr>
                                @endforeach
                            </x-admin::table.tbody>
                        </x-slot:body>
                    </x-admin::datagrid>
                @else
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('project::app.no-records-found') }}</p>
                @endif
            </div>
        </div>
    </div>
</x-admin::layouts>