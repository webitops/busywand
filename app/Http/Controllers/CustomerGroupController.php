<?php

namespace App\Http\Controllers;

use App\Models\CustomerGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerGroupController extends Controller
{
    /**
     * Display a listing of the customer groups.
     */
    public function index(): Response
    {
        $groups = CustomerGroup::withCount('customers')->paginate(10);

        return Inertia::render('CustomerGroups/Index', [
            'groups' => $groups,
        ]);
    }

    /**
     * Show the form for creating a new customer group.
     */
    public function create(): Response
    {
        return Inertia::render('CustomerGroups/Create');
    }

    /**
     * Store a newly created customer group in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:customer_groups,name',
            'description' => 'nullable|string|max:1000',
        ]);

        CustomerGroup::create($validated);

        return to_route('customer_groups.index');
    }

    /**
     * Show the form for editing the specified customer group.
     */
    public function edit(CustomerGroup $customerGroup): Response
    {
        return Inertia::render('CustomerGroups/Edit', [
            'group' => $customerGroup,
        ]);
    }

    /**
     * Update the specified customer group in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, CustomerGroup $customerGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:customer_groups,name,'.$customerGroup->id,
            'description' => 'nullable|string|max:1000',
        ]);

        $customerGroup->update($validated);

        return to_route('customer_groups.index');
    }

    /**
     * Remove the specified customer group from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(CustomerGroup $customerGroup)
    {
        $customerGroup->delete();

        return to_route('customer_groups.index');
    }
}
