<?php

namespace App\Http\Controllers\Web\PerformanceIndicator;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\IndexRequestByName;
use App\Http\Requests\Web\IndicatorUnit\StoreIndicatorUnitRequest;
use App\Http\Requests\Web\IndicatorUnit\UpdateIndicatorUnitRequest;
use App\Models\PerformanceIndicator\IndicatorUnit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndicatorUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequestByName $request)
    {
        $filters = [];

        $resources = IndicatorUnit::filterResource($request, ['name'], $filters)
            ->orderBy($request->get('sort', 'name'), $request->get('order', 'asc'))
            ->paginate($request->per_page);

        return Inertia::render('IndicatorUnit/Index', [
            'title'         => 'Satuan Indikator',
            'resources'     => $resources,
            'requestQuery'  => $request->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('IndicatorUnit/Create', [
            'title'         => 'Create Satuan Indikator',
            'pageTitle'     => 'Satuan Indikator',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndicatorUnitRequest $request)
    {
        $unit = new IndicatorUnit();
        $unit->fill($request->validated());
        $unit->save();

        return redirect()->route('indicator-units.index')->with('success', 'Data saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndicatorUnit $unit)
    {
        return Inertia::render('IndicatorUnit/Edit', [
            'title'         => 'Edit Satuan Indikator',
            'pageTitle'     => 'Satuan Indikator',
            'resource'      => $unit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIndicatorUnitRequest $request, IndicatorUnit $unit)
    {
        $unit->fill($request->validated());
        $unit->save();

        return redirect()->route('indicator-units.index')->with('success', 'Data updated successfully');   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndicatorUnit $unit)
    {
        // TODO : check data usage
        $unit->delete();

        return redirect()->route('indicator-units.index')->with('success', 'Data deleted successfully');
    }
}
