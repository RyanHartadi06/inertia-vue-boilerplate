<?php

namespace App\Http\Controllers\Web\PerformanceIndicator;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\Web\Period\StorePeriodRequest;
use App\Http\Requests\Web\Period\UpdatePeriodRequest;
use App\Models\PerformanceIndicator\Period;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $filters = [];

        $resources = Period::filterResource($request, ['year', 'weight', 'direction_weight'], $filters)
            ->orderBy($request->get('sort', 'year'), $request->get('order', 'asc'))
            ->paginate($request->per_page);

        return Inertia::render('Period/Index', [
            'title'         => 'Periode',
            'resources'     => $resources,
            'requestQuery'  => $request->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $yearStart  = 2020;
        $yearEnd    = date('Y') + 5;
        $years      = range($yearStart, $yearEnd);
        $years      = collect($years)->map(function ($item) {
            return [
                'value' => $item,
                'label' => $item,
            ];
        });

        return Inertia::render('Period/Create', [
            'title'         => 'Create Periode',
            'pageTitle'     => 'Periode',
            'years'         => $years
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePeriodRequest $request)
    {
        $activePeriod = Period::active()->first();

        $period = new Period();
        $period->fill($request->validated());
        $period->status = $activePeriod ? 0 : 1;
        $period->save();

        return redirect()->route('periods.index')->with('success', 'Data saved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Period $period)
    {
        $yearStart  = 2020;
        $yearEnd    = date('Y') + 5;
        $years      = range($yearStart, $yearEnd);
        $years      = collect($years)->map(function ($item) {
            return [
                'value' => $item,
                'label' => $item,
            ];
        });

        return Inertia::render('Period/Edit', [
            'title'         => 'Edit Periode',
            'pageTitle'     => 'Periode',
            'resource'      => $period,
            'years'         => $years
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeriodRequest $request, Period $period)
    {
        $period->fill($request->validated());
        $period->save();

        return redirect()->route('periods.index')->with('success', 'Data updated successfully');   
    }

    /**
     * Update status
     */
    public function updateStatus(Request $request, Period $period)
    {
        try {
            DB::beginTransaction();
            $period->status = $request->status ?? 0;
            $period->save();
    
            Period::where('id', '!=', $period->id)->update([
                'status' => 0
            ]);
    
            $activePeriod = Period::active()->first();
            if (!$activePeriod) {
                Period::first()->update(['status' => 1]);
            }
    
            DB::commit();

            return redirect()->route('periods.index')->with('success', 'Data updated successfully');   
        } catch (Exception $e) {
            DB::rollBack();
            
            return redirect()->route('periods.index')->with('error', 'Data failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Period $period)
    {
        try {
            DB::beginTransaction();

            // TODO : check data usage
            $period->delete();

            $activePeriod = Period::active()->first();
            if (!$activePeriod) {
                Period::first()->update(['status' => 1]);
            }

            DB::commit();

            return redirect()->route('periods.index')->with('success', 'Data deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            
            return redirect()->route('periods.index')->with('error', 'Data failed to delete');
        }
    }
}
