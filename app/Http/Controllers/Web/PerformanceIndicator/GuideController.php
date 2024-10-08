<?php

namespace App\Http\Controllers\Web\PerformanceIndicator;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRequestByName;
use App\Http\Requests\Web\Guide\StoreGuideRequest;
use App\Http\Requests\Web\Guide\UpdateGuideRequest;
use App\Libraries\Helpers\RouteHelper;
use App\Models\PerformanceIndicator\Guide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequestByName $request)
    {
        $filters = [];

        $resources = Guide::filterResource($request, ['name', 'description'], $filters)
            ->orderBy($request->get('sort', 'name'), $request->get('order', 'asc'))
            ->paginate($request->per_page);

        return Inertia::render('Guide/Index', [
            'title'         => 'Panduan',
            'resources'     => $resources,
            'requestQuery'  => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Guide/Create', [
            'title'         => 'Create Panduan',
            'pageTitle'     => 'Panduan',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuideRequest $request)
    {
        $guide = new Guide();
        $guide->fill($request->validated());
        $guide->file = $request->hasFile('file') ?
            $request->file->storeAs('guide-files', $request->file('file')->getClientOriginalName(), 'public') :
            RouteHelper::ImageUrlToDb($request->file);
        $guide->save();

        return redirect()->route('guides.index')->with('success', 'Data saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Guide $guide)
    {
        return Inertia::render('Guide/Show', [
            'title'         => 'Detail Panduan',
            'pageTitle'     => 'Panduan',
            'resource'      => $guide
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guide $guide)
    {
        return Inertia::render('Guide/Edit', [
            'title'         => 'Edit Panduan',
            'pageTitle'     => 'Panduan',
            'resource'      => $guide,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuideRequest $request, Guide $guide)
    {
        $guide->fill($request->validated());
        $guide->file = $request->hasFile('file') ?
            $request->file->storeAs('guide-files', $request->file('file')->getClientOriginalName(), 'public') :
            RouteHelper::ImageUrlToDb($request->file);
        $guide->save();

        return redirect()->route('guides.index')->with('success', 'Data updated successfully');   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guide $guide)
    {
        // TODO : check data usage
        $guide->delete();

        return redirect()->route('guides.index')->with('success', 'Data deleted successfully');
    }
}
