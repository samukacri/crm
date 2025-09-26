<?php

namespace Webkul\Project\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Project\Models\Project;
use Webkul\Project\Models\ProjectTemplate;
use Webkul\Project\Models\Task;
use Webkul\Contact\Models\Organization;
use Webkul\Product\Models\Product;
use Webkul\User\Models\User;
use Webkul\Project\Repositories\ProjectRepository;
use Webkul\Contact\Repositories\OrganizationRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\User\Repositories\UserRepository;
use Webkul\Tag\Repositories\TagRepository;
use Webkul\Project\DataGrids\ProjectDataGrid;

use Webkul\Lead\Repositories\StageRepository;

class ProjectController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected ProjectRepository $projectRepository,
        protected OrganizationRepository $organizationRepository,
        protected ProductRepository $productRepository,
        protected UserRepository $userRepository,
        protected TagRepository $tagRepository,
        protected StageRepository $stageRepository
    ) {
        request()->request->add(['entity_type' => 'projects']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(ProjectDataGrid::class)->process();
        }

        return view('admin::projects.index', [
            'columns'  => $this->getKanbanColumns(),
        ]);
    }

    /**
     * Get projects for kanban view.
     */
    public function get($pipelineId = null): JsonResponse
    {
        try {
            // Para projetos, vamos usar stages fixos por enquanto
            $stages = [
                ['id' => 1, 'name' => 'Novo', 'code' => 'new'],
                ['id' => 2, 'name' => 'Em Progresso', 'code' => 'in_progress'],
                ['id' => 3, 'name' => 'Em Revisão', 'code' => 'review'],
                ['id' => 4, 'name' => 'Concluído', 'code' => 'completed'],
                ['id' => 5, 'name' => 'Cancelado', 'code' => 'cancelled']
            ];

            \Log::info('Iniciando busca de projetos');

            $params = request()->all();

            $projects = $this->projectRepository
                ->with(['user', 'organization', 'product', 'tags'])
                ->when(isset($params['search']), function ($query) use ($params) {
                    $searchTerms = explode(';', rtrim($params['search'], ';'));
                    foreach ($searchTerms as $term) {
                        if (empty($term)) continue;
                        
                        [$field, $values] = explode(':', $term);
                        $values = explode(',', $values);
                        
                        if ($field === 'name') {
                            $query->whereIn('projects.name', $values);
                        } elseif ($field === 'status') {
                            $query->whereIn('projects.status', $values);
                        } elseif ($field === 'organization_id') {
                            $query->whereIn('projects.organization_id', $values);
                        } elseif ($field === 'product_id') {
                            $query->whereIn('projects.product_id', $values);
                        } elseif ($field === 'user_id') {
                            $query->whereIn('projects.owner_id', $values);
                        } elseif ($field === 'start_date') {
                            $query->whereDate('projects.start_date', '>=', $values[0]);
                        } elseif ($field === 'end_date') {
                            $query->whereDate('projects.end_date', '<=', $values[0]);
                        }
                    }
                })
                ->get();

            $data = [];
            
            foreach ($stages as $index => $stage) {
                // Para demonstração, vamos distribuir os projetos pelos stages
                // Em uma implementação real, você teria um campo 'stage' na tabela projects
                $stageProjects = $projects->filter(function($project, $key) use ($index, $stages) {
                    return $key % count($stages) == $index;
                });
                
                $data[$index + 1] = [
                    'stage' => (object) $stage,
                    'projects' => [
                        'data' => $stageProjects->values(),
                        'meta' => [
                            'current_page' => 1,
                            'from' => 1,
                            'last_page' => 1,
                            'per_page' => $stageProjects->count(),
                            'to' => $stageProjects->count(),
                            'total' => $stageProjects->count(),
                        ],
                    ],
                ];
            }

            \Log::info('Dados dos projetos:', ['data' => $data]);
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Erro ao buscar projetos: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get kanban projects.
     *
     * @return array
     */
    private function getKanbanProjects()
    {
        $params = request()->all();
        
        $projects = $this->projectRepository
            ->with(['user', 'organization', 'product'])
            ->when(isset($params['search']), function ($query) use ($params) {
                $searchTerms = explode(';', rtrim($params['search'], ';'));
                foreach ($searchTerms as $term) {
                    if (empty($term)) continue;
                    
                    [$field, $values] = explode(':', $term);
                    $values = explode(',', $values);
                    
                    if ($field === 'name') {
                        $query->whereIn('projects.name', $values);
                    } elseif ($field === 'status') {
                        $query->whereIn('projects.status', $values);
                    } elseif ($field === 'organization_id') {
                        $query->whereIn('projects.organization_id', $values);
                    } elseif ($field === 'product_id') {
                        $query->whereIn('projects.product_id', $values);
                    } elseif ($field === 'user_id') {
                        $query->whereIn('projects.owner_id', $values);
                    }
                }
            })
            ->get();

        $groupedProjects = [
            'active' => $projects->where('status', 'active')->values(),
            'completed' => $projects->where('status', 'completed')->values(),
            'cancelled' => $projects->where('status', 'cancelled')->values(),
        ];

        return $groupedProjects;
    }

    /**
     * Kanban lookup.
     */
    public function kanbanLookup()
    {
        $params = $this->validate(request(), [
            'type'   => ['required', 'in:organizations,products,users'],
            'search' => ['required', 'min:2'],
        ]);

        switch ($params['type']) {
            case 'organizations':
                return $this->organizationRepository
                    ->select(['name as label', 'id as value'])
                    ->where('name', 'LIKE', '%'.$params['search'].'%')
                    ->limit(10)
                    ->get()
                    ->map
                    ->only('label', 'value');
                
            case 'products':
                return $this->productRepository
                    ->select(['name as label', 'id as value'])
                    ->where('name', 'LIKE', '%'.$params['search'].'%')
                    ->limit(10)
                    ->get()
                    ->map
                    ->only('label', 'value');
                
            case 'users':
                return $this->userRepository
                    ->select(['name as label', 'id as value'])
                    ->where('name', 'LIKE', '%'.$params['search'].'%')
                    ->limit(10)
                    ->get()
                    ->map
                    ->only('label', 'value');
        }
    }

    /**
     * Get columns for the kanban view.
     */
    private function getKanbanColumns(): array
    {
        return [
            [
                'index'                 => 'id',
                'label'                 => trans('project::app.id'),
                'type'                  => 'integer',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => null,
                'filterable_options'    => [],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'name',
                'label'                 => trans('project::app.name'),
                'type'                  => 'string',
                'searchable'            => true,
                'search_field'          => 'like',
                'filterable'            => true,
                'filterable_type'       => null,
                'filterable_options'    => [],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'status',
                'label'                 => trans('project::app.status'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => 'dropdown',
                'filterable_options'    => [
                    ['label' => 'Active', 'value' => 'active'],
                    ['label' => 'Completed', 'value' => 'completed'],
                    ['label' => 'Cancelled', 'value' => 'cancelled'],
                ],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'organization_id',
                'label'                 => trans('project::app.organization'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => 'searchable_dropdown',
                'filterable_options'    => [
                    'repository' => OrganizationRepository::class,
                    'column'     => [
                        'label' => 'name',
                        'value' => 'id',
                    ],
                ],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'product_id',
                'label'                 => trans('project::app.product'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => 'searchable_dropdown',
                'filterable_options'    => [
                    'repository' => ProductRepository::class,
                    'column'     => [
                        'label' => 'name',
                        'value' => 'id',
                    ],
                ],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'owner_id',
                'label'                 => trans('project::app.sales-person'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => 'searchable_dropdown',
                'filterable_options'    => [
                    'repository' => UserRepository::class,
                    'column'     => [
                        'label' => 'name',
                        'value' => 'id',
                    ],
                ],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
            [
                'index'                 => 'tag_name',
                'label'                 => trans('project::app.tags'),
                'type'                  => 'string',
                'searchable'            => false,
                'search_field'          => 'in',
                'filterable'            => true,
                'filterable_type'       => 'searchable_dropdown',
                'filterable_options'    => [
                    'repository' => TagRepository::class,
                    'column'     => [
                        'label' => 'name',
                        'value' => 'name',
                    ],
                ],
                'allow_multiple_values' => true,
                'sortable'              => true,
                'visibility'            => true,
            ],
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $templates = ProjectTemplate::where('is_active', true)->get();
        $organizations = Organization::all();
        $products = Product::all();
        $users = User::all();
        
        return view('project::create', compact('templates', 'organizations', 'products', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'organization_id' => 'nullable|exists:organizations,id',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'organization_id' => $request->organization_id ?: null,
            'product_id' => $request->product_id ?: null,
            'owner_id' => auth()->user()->id,
            'status' => 'active',
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $project = Project::with(['user', 'organization', 'product', 'tasks' => function($query) {
            $query->orderBy('status')->orderBy('priority');
        }])->findOrFail($id);
        
        return view('project::show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $organizations = Organization::all();
        $products = Product::all();
        $users = User::all();
        
        return view('project::edit', compact('project', 'organizations', 'products', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'organization_id' => 'nullable|exists:organizations,id',
            'product_id' => 'nullable|exists:products,id',
            'status' => 'required|string|in:active,completed,cancelled',
        ]);

        $project = Project::findOrFail($id);
        
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'organization_id' => $request->organization_id ?: null,
            'product_id' => $request->product_id ?: null,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.projects.show', $id)->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully.');
    }

    /**
     * Create a project from a template.
     *
     * @param  int  $templateId
     * @return \Illuminate\View
     */
    public function createFromTemplate($templateId)
    {
        $template = ProjectTemplate::findOrFail($templateId);
        $organizations = Organization::all();
        $products = Product::all();
        $users = User::all();
        
        return view('project::create-from-template', compact('template', 'organizations', 'products', 'users'));
    }

    /**
     * Store a project created from a template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $templateId
     * @return \Illuminate\Http\Response
     */
    public function storeFromTemplate(Request $request, $templateId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'organization_id' => 'nullable|exists:organizations,id',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $template = ProjectTemplate::findOrFail($templateId);

        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description ?? $template->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'organization_id' => $request->organization_id ?: null,
            'product_id' => $request->product_id ?: null,
            'owner_id' => auth()->user()->id,
            'status' => 'active',
        ]);

        // TODO: Create tasks from template

        return redirect()->route('admin.projects.show', $project->id)->with('success', 'Project created from template successfully.');
    }

    /**
     * Filter tasks by product and organization.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function filterTasks(Request $request)
    {
        $query = Task::with(['project', 'organization', 'product']);
        
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }
        
        if ($request->has('organization_id') && $request->organization_id) {
            $query->where('organization_id', $request->organization_id);
        }
        
        $tasks = $query->get();
        
        $organizations = Organization::all();
        $products = Product::all();
        
        return view('project::tasks', compact('tasks', 'organizations', 'products'));
    }
}