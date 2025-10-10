<?php

namespace Webkul\Admin\Http\Controllers\Properties;

use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Property\Repositories\PropertyRepository;

class TagController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected PropertyRepository $propertyRepository) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attach($id)
    {
        Event::dispatch('properties.tag.create.before', $id);

        $property = $this->propertyRepository->findOrFail($id);

        if (! $property->tags->contains(request()->input('tag_id'))) {
            $property->tags()->attach(request()->input('tag_id'));
        }

        Event::dispatch('properties.tag.create.after', $property);

        return response()->json([
            'message' => trans('admin::app.leads.view.tags.create-success'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $propertyId
     * @return \Illuminate\Http\Response
     */
    public function detach($propertyId)
    {
        Event::dispatch('properties.tag.delete.before', $propertyId);

        $property = $this->propertyRepository->find($propertyId);

        $property->tags()->detach(request()->input('tag_id'));

        Event::dispatch('properties.tag.delete.after', $property);

        return response()->json([
            'message' => trans('admin::app.leads.view.tags.destroy-success'),
        ]);
    }
}