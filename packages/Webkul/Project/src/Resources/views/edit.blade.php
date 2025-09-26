<x-admin::layouts>
    <x-slot:title>
        {{ __('project::app.edit-project') }}
    </x-slot>

    <!-- Edit Project Form -->
    <x-admin::form
        :action="route('admin.projects.update', $project->id)"
        method="PUT"
    >
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <x-admin::breadcrumbs
                        name="projects.edit"
                        :entity="$project"
                    />

                    <div class="text-xl font-bold dark:text-white">
                        {{ __('project::app.edit-project') }}
                    </div>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <!-- Save button for Editing Project -->
                    <button
                        type="submit"
                        class="primary-button"
                    >
                        {{ __('project::app.save') }}
                    </button>
                </div>
            </div>

            <div class="box-shadow flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Nome do Projeto -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label for="name" class="required">
                            {{ __('project::app.name') }}
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control
                            type="text"
                            id="name"
                            name="name"
                            :value="old('name', $project->name)"
                            rules="required"
                            :label="__('project::app.name')"
                            :placeholder="__('project::app.name')"
                        />
                        <x-admin::form.control-group.error control-name="name" />
                    </x-admin::form.control-group>

                    <!-- Descrição -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label for="description">
                            {{ __('project::app.description') }}
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control
                            type="textarea"
                            id="description"
                            name="description"
                            :value="old('description', $project->description)"
                            :label="__('project::app.description')"
                            :placeholder="__('project::app.description')"
                        />
                        <x-admin::form.control-group.error control-name="description" />
                    </x-admin::form.control-group>

                    <!-- Status -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label for="status">
                            {{ __('project::app.status') }}
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control
                            type="select"
                            id="status"
                            name="status"
                            :value="old('status', $project->status)"
                        >
                            <option value="active" {{ old('status', $project->status) === 'active' ? 'selected' : '' }}>
                                {{ __('project::app.active') }}
                            </option>
                            <option value="completed" {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}>
                                {{ __('project::app.completed') }}
                            </option>
                            <option value="cancelled" {{ old('status', $project->status) === 'cancelled' ? 'selected' : '' }}>
                                {{ __('project::app.cancelled') }}
                            </option>
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="status" />
                    </x-admin::form.control-group>

                    <!-- Data de Início -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label for="start_date">
                            {{ __('project::app.start-date') }}
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control
                            type="date"
                            id="start_date"
                            name="start_date"
                            :value="old('start_date', $project->start_date)"
                            :label="__('project::app.start-date')"
                        />
                        <x-admin::form.control-group.error control-name="start_date" />
                    </x-admin::form.control-group>

                    <!-- Data de Término -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label for="end_date">
                            {{ __('project::app.end-date') }}
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control
                            type="date"
                            id="end_date"
                            name="end_date"
                            :value="old('end_date', $project->end_date)"
                            :label="__('project::app.end-date')"
                        />
                        <x-admin::form.control-group.error control-name="end_date" />
                    </x-admin::form.control-group>

                    <!-- Organização -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label for="organization_id">
                            {{ __('project::app.organization') }}
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control
                            type="select"
                            id="organization_id"
                            name="organization_id"
                            :value="old('organization_id', $project->organization_id)"
                        >
                            <option value="">{{ __('project::app.select-organization') }}</option>
                            @foreach($organizations as $organization)
                                <option value="{{ $organization->id }}" {{ old('organization_id', $project->organization_id) == $organization->id ? 'selected' : '' }}>
                                    {{ $organization->name }}
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="organization_id" />
                    </x-admin::form.control-group>

                    <!-- Produto -->
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label for="product_id">
                            {{ __('project::app.product') }}
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control
                            type="select"
                            id="product_id"
                            name="product_id"
                            :value="old('product_id', $project->product_id)"
                        >
                            <option value="">{{ __('project::app.select-product') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', $project->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>
                        <x-admin::form.control-group.error control-name="product_id" />
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>
    </x-admin::form>
</x-admin::layouts>