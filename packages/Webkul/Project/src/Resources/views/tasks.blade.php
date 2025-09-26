<x-admin::layouts>
    <x-slot:title>
        {{ __('project::app.filter-tasks') }}
    </x-slot>

    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('project::app.filter-tasks') }}</h1>
            </div>
        </div>
        
        <div class="page-content">
            <!-- Filter Form -->
            <div class="panel mb-4">
                <div class="panel-header">
                    <h3>{{ __('project::app.filter') }}</h3>
                </div>
                
                <div class="panel-body">
                    <form method="GET" action="{{ route('admin.projects.tasks.filter') }}">
                        <div class="form-group">
                            <label for="product_id">{{ __('project::app.product') }}</label>
                            <select class="control" id="product_id" name="product_id">
                                <option value="">{{ __('project::app.all-products') }}</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="organization_id">{{ __('project::app.organization') }}</label>
                            <select class="control" id="organization_id" name="organization_id">
                                <option value="">{{ __('project::app.all-organizations') }}</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ request('organization_id') == $organization->id ? 'selected' : '' }}>
                                        {{ $organization->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            {{ __('project::app.filter') }}
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Tasks Table -->
            <div class="panel">
                <div class="panel-header">
                    <h3>{{ __('project::app.tasks') }}</h3>
                </div>
                
                <div class="panel-body">
                    @if($tasks->count())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('project::app.title') }}</th>
                                        <th>{{ __('project::app.project') }}</th>
                                        <th>{{ __('project::app.status') }}</th>
                                        <th>{{ __('project::app.priority') }}</th>
                                        <th>{{ __('project::app.due-date') }}</th>
                                        <th>{{ __('project::app.organization') }}</th>
                                        <th>{{ __('project::app.product') }}</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->project->name }}</td>
                                            <td>
                                                <span class="label-{{ $task->status === 'done' ? 'active' : ($task->status === 'in-progress' ? 'warning' : 'info') }}">
                                                    {{ ucfirst(__("project::app.{$task->status}")) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="label-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning' : 'info') }}">
                                                    {{ ucfirst(__("project::app.{$task->priority}")) }}
                                                </span>
                                            </td>
                                            <td>{{ $task->due_date ? date('d/m/Y', strtotime($task->due_date)) : '-' }}</td>
                                            <td>{{ $task->organization ? $task->organization->name : '-' }}</td>
                                            <td>{{ $task->product ? $task->product->name : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>{{ __('project::app.no-records-found') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts>