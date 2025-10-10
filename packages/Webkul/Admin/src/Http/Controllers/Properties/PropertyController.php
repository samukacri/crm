<?php

namespace Webkul\Admin\Http\Controllers\Properties;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Prettus\Repository\Criteria\RequestCriteria;
use Webkul\Admin\DataGrids\Property\PropertyDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Requests\AttributeForm;
use Webkul\Admin\Http\Requests\MassDestroyRequest;
use Webkul\Admin\Http\Resources\PropertyResource;
use Webkul\Property\Repositories\PropertyRepository;

class PropertyController extends Controller
{
    public function __construct(protected PropertyRepository $propertyRepository)
    {
        request()->request->add(['entity_type' => 'properties']);
    }

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(PropertyDataGrid::class)->process();
        }

        return view('admin::properties.index');
    }

    public function create(): View
    {
        return view('admin::properties.create');
    }

    public function store(AttributeForm $request)
    {
        Event::dispatch('property.create.before');

        $property = $this->propertyRepository->create($request->all());

        Event::dispatch('property.create.after', $property);

        session()->flash('success', trans('admin::app.properties.index.create-success'));

        return redirect()->route('admin.properties.index');
    }

    public function view(int $id): View
    {
        $property = $this->propertyRepository->findOrFail($id);

        return view('admin::properties.view', compact('property'));
    }

    public function edit(int $id): View|JsonResponse
    {
        $property = $this->propertyRepository->findOrFail($id);

        $inventories = $property->inventories()
            ->with('location')
            ->get()
            ->map(function ($inventory) {
                return [
                    'id'                    => $inventory->id,
                    'name'                  => $inventory->location->name,
                    'warehouse_id'          => $inventory->warehouse_id,
                    'warehouse_location_id' => $inventory->warehouse_location_id,
                    'in_stock'              => $inventory->in_stock,
                    'allocated'             => $inventory->allocated,
                ];
            });

        return view('admin::properties.edit', compact('property', 'inventories'));
    }

    public function update(AttributeForm $request, int $id)
    {
        Event::dispatch('property.update.before', $id);

        $property = $this->propertyRepository->update($request->all(), $id);

        Event::dispatch('property.update.after', $property);

        if (request()->ajax()) {
            return response()->json([
                'message' => trans('admin::app.properties.index.update-success'),
            ]);
        }

        session()->flash('success', trans('admin::app.properties.index.update-success'));

        return redirect()->route('admin.properties.index');
    }

    public function storeInventories(int $id, ?int $warehouseId = null): JsonResponse
    {
        $this->validate(request(), [
            'inventories'                         => 'array',
            'inventories.*.warehouse_location_id' => 'required',
            'inventories.*.warehouse_id'          => 'required',
            'inventories.*.in_stock'              => 'required|integer|min:0',
            'inventories.*.allocated'             => 'required|integer|min:0',
        ]);

        $property = $this->propertyRepository->findOrFail($id);

        Event::dispatch('property.update.before', $id);

        $this->propertyRepository->saveInventories(request()->all(), $id, $warehouseId);

        Event::dispatch('property.update.after', $property);

        return new JsonResponse([
            'message' => trans('admin::app.properties.index.update-success'),
        ], 200);
    }

    public function search(): JsonResource
    {
        $properties = $this->propertyRepository
            ->pushCriteria(app(RequestCriteria::class))
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return PropertyResource::collection($properties);
    }

    public function warehouses(int $id): JsonResponse
    {
        $warehouses = $this->propertyRepository->getInventoriesGroupedByWarehouse($id);

        return response()->json(array_values($warehouses));
    }

    public function destroy(int $id): JsonResponse
    {
        $property = $this->propertyRepository->findOrFail($id);

        try {
            Event::dispatch('settings.properties.delete.before', $id);

            $property->delete($id);

            Event::dispatch('settings.properties.delete.after', $id);

            return new JsonResponse([
                'message' => trans('admin::app.properties.index.delete-success'),
            ], 200);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => trans('admin::app.properties.index.delete-failed'),
            ], 400);
        }
    }

    public function massDestroy(MassDestroyRequest $massDestroyRequest): JsonResponse
    {
        $indices = $massDestroyRequest->input('indices');

        foreach ($indices as $index) {
            Event::dispatch('property.delete.before', $index);

            $this->propertyRepository->delete($index);

            Event::dispatch('property.delete.after', $index);
        }

        return new JsonResponse([
            'message' => trans('admin::app.properties.index.delete-success'),
        ]);
    }
}