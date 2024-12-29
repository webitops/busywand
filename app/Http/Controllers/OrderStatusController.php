<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = OrderStatus::with('allowedNextStatuses')->orderBy('order_column')->get();

        return Inertia::render('OrderStatuses/Index', [
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('OrderStatuses/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:order_statuses,name',
            'description' => 'nullable|string',
            'is_paid' => 'boolean',
            'is_delivered' => 'boolean',
            'is_cancelled' => 'boolean',
            'is_refunded' => 'boolean',
            'allowed_next_statuses' => 'array',
            'allowed_next_statuses.*' => 'exists:order_statuses,id',
        ]);

        $status = OrderStatus::create($validated);

        if (isset($validated['allowed_next_statuses'])) {
            $status->allowedNextStatuses()->sync($validated['allowed_next_statuses']);
        }

        return redirect()->route('order-statuses.index')->with('success', 'Status created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderStatus $orderStatus)
    {
        return Inertia::render('OrderStatuses/Edit', [
            'status' => $orderStatus->load('allowedNextStatuses'),
            'allStatuses' => OrderStatus::orderBy('order_column')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderStatus $orderStatus)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:order_statuses,name,'.$orderStatus->id,
            'description' => 'nullable|string',
            'is_paid' => 'boolean',
            'is_delivered' => 'boolean',
            'is_cancelled' => 'boolean',
            'is_refunded' => 'boolean',
            'allowed_next_statuses' => 'array',
            'allowed_next_statuses.*' => 'exists:order_statuses,id',
        ]);

        $orderStatus->update($validated);

        if (isset($validated['allowed_next_statuses'])) {
            $orderStatus->allowedNextStatuses()->sync($validated['allowed_next_statuses']);
        }

        return redirect()->route('order-statuses.index')->with('success', 'Status updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderStatus $orderStatus)
    {
        $orderStatus->allowedNextStatuses()->detach(); // Clean up pivot
        $orderStatus->delete();

        return redirect()->route('order-statuses.index')->with('success', 'Status deleted.');
    }
}
