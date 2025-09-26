<x-admin::layouts>
    <x-slot:title>
        {{ __('project::app.create-from-template') }}
    </x-slot>

    <div class="content full-page">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.projects.create') }}'"></i>
                    {{ __('project::app.create-from-template') }}
                </h1>
            </div>
        </div>
        
        <div class="page-content">
            <div class="form-container">
                <div class="panel">
                    <div class="panel-header">
                        <h3>{{ __('project::app.create-project') }} - {{ $template->name }}</h3>
                    </div>
                    
                    <div class="panel-body">
                        <form method="POST" action="{{ route('admin.projects.store.from.template', $template->id) }}">
                            @csrf
                            
                            <div class="form-group">
                                <label for="name">{{ __('project::app.name') }}</label>
                                <input type="text" class="control" id="name" name="name" value="{{ old('name', $template->name) }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="description">{{ __('project::app.description') }}</label>
                                <textarea class="control" id="description" name="description">{{ old('description', $template->description) }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="start_date">{{ __('project::app.start-date') }}</label>
                                <input type="date" class="control" id="start_date" name="start_date" value="{{ old('start_date') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="end_date">{{ __('project::app.end-date') }}</label>
                                <input type="date" class="control" id="end_date" name="end_date" value="{{ old('end_date') }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="organization_id">{{ __('project::app.organization') }}</label>
                                <select class="control" id="organization_id" name="organization_id">
                                    <option value="">{{ __('project::app.select-organization') }}</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}" {{ old('organization_id') == $organization->id ? 'selected' : '' }}>
                                            {{ $organization->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="product_id">{{ __('project::app.product') }}</label>
                                <select class="control" id="product_id" name="product_id">
                                    <option value="">{{ __('project::app.select-product') }}</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-lg btn-primary">
                                {{ __('project::app.save') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin::layouts>