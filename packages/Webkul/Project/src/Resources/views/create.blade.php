<x-admin::layouts>
    <x-slot:title>
        {{ __('project::app.add-project') }}
    </x-slot>

    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                <x-admin::breadcrumbs
                    name="projects.create"
                />

                <div class="text-xl font-bold dark:text-white">
                    {{ __('project::app.add-project') }}
                </div>
            </div>

            <div class="flex items-center gap-x-2.5">
                <a 
                    href="{{ route('admin.projects.index') }}" 
                    class="secondary-button"
                >
                    {{ __('admin::app.account.edit.back') }}
                </a>
            </div>
        </div>
        
        @if($templates->count())
            <div class="box-shadow flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <p class="text-base font-medium text-gray-800 dark:text-white">
                    {{ __('project::app.templates') }}
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($templates as $template)
                        <div class="flex flex-col gap-2 rounded-lg border border-gray-200 p-4 dark:border-gray-800">
                            <p class="text-base font-medium text-gray-800 dark:text-white">
                                {{ $template->name }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ Str::limit($template->description, 100) }}
                            </p>
                            <a href="{{ route('admin.projects.create.from.template', $template->id) }}" class="primary-button mt-2 self-start">
                                {{ __('project::app.create-from-template') }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
            
            <div class="box-shadow flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <p class="text-base font-medium text-gray-800 dark:text-white">
                    {{ __('project::app.create-project') }}
                </p>
                
                <x-admin::form
                    :action="route('admin.projects.store')"
                >
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            {{ __('project::app.name') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            name="name"
                            :value="old('name')"
                            rules="required"
                            :label="__('project::app.name')"
                            :placeholder="__('project::app.name')"
                        />

                        <x-admin::form.control-group.error
                            control-name="name"
                        />
                    </x-admin::form.control-group>
                    
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            {{ __('project::app.description') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            name="description"
                            :value="old('description')"
                            :label="__('project::app.description')"
                            :placeholder="__('project::app.description')"
                        />

                        <x-admin::form.control-group.error
                            control-name="description"
                        />
                    </x-admin::form.control-group>
                    
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            {{ __('project::app.start-date') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="date"
                            name="start_date"
                            :value="old('start_date')"
                            :label="__('project::app.start-date')"
                        />

                        <x-admin::form.control-group.error
                            control-name="start_date"
                        />
                    </x-admin::form.control-group>
                    
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            {{ __('project::app.end-date') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="date"
                            name="end_date"
                            :value="old('end_date')"
                            :label="__('project::app.end-date')"
                        />

                        <x-admin::form.control-group.error
                            control-name="end_date"
                        />
                    </x-admin::form.control-group>
                    
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            {{ __('project::app.organization') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="select"
                            name="organization_id"
                            :value="old('organization_id')"
                            :label="__('project::app.organization')"
                        >
                            <option value="">{{ __('project::app.select-organization') }}</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="organization_id"
                        />
                    </x-admin::form.control-group>
                    
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            {{ __('project::app.product') }}
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="select"
                            name="product_id"
                            :value="old('product_id')"
                            :label="__('project::app.product')"
                        >
                            <option value="">{{ __('project::app.select-product') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error
                            control-name="product_id"
                        />
                    </x-admin::form.control-group>
                    
                    <div class="flex justify-start">
                        <button type="submit" class="primary-button">
                            {{ __('project::app.save') }}
                        </button>
                    </div>
                </x-admin::form>
            </div>
        </div>
    </div>
</x-admin::layouts>