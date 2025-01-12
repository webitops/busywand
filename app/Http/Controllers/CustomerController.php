<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\CustomerGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     */
    public function index(): Response
    {
        $customers = Customer::with('customerGroups')->paginate(10);

        return Inertia::render('Customers/Index', [
            'customers' => CustomerResource::collection($customers)->only(['id', 'name', 'customer_groups']),
        ]);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create(): Response
    {
        $groups = CustomerGroup::all();

        return Inertia::render('Customers/Create', [
            'groups' => $groups,
        ]);
    }

    /**
     * Store a newly created customer in storage.
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email',
            'phone' => 'nullable|string|unique:customers,phone',
            'group_ids' => 'array|exists:customer_groups,id',
        ]);

        $customer = Customer::create($validated);
        $customer->customerGroups()->sync($validated['group_ids'] ?? []);

        return to_route('customers.index');
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer): Response
    {
        $customer->load('customerGroups');

        return Inertia::render('Customers/Show', [
            'customer' => $customer,
        ]);
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer): Response
    {
        $groups = CustomerGroup::all();

        return Inertia::render('Customers/Edit', [
            'customer' => $customer->load('customerGroups'),
            'groups' => $groups,
        ]);
    }

    /**
     * Update the specified customer in storage.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:customers,email,'.$customer->id,
            'phone' => 'nullable|string|unique:customers,phone,'.$customer->id,
            'group_ids' => 'array|exists:customer_groups,id',
        ]);

        $customer->update($validated);
        $customer->customerGroups()->sync($validated['group_ids'] ?? []);

        return to_route('customers.index');
    }

    /**
     * Remove the specified customer from storage.
     *
     * @return RedirectResponse
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return to_route('customers.index');
    }
}
