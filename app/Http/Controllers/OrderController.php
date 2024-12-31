<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function updateOrderStatus(Order $order)
    {
        $validated = request()->validate([
            'status_id' => 'required|exists:order_statuses,id',
        ]);

        if (! $order->status->allowedNextStatuses->contains($validated['status_id'])) {
            throw new \Exception('Invalid status');
        }

        $order->status_id = $validated['status_id'];
        $order->save();

        return to_route('orders.show', $order);
    }

    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'status', 'items'])->paginate(10);

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $statuses = OrderStatus::all();
        $customers = Customer::all();

        return Inertia::render('Orders/Create', [
            'statuses' => $statuses,
            'customers' => $customers,
        ]);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'status_id' => 'required|exists:order_statuses,id',
            'shipping_address' => 'required|array',
            'billing_address' => 'nullable|array',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.variant_id' => 'required|exists:variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.tax_amount' => 'nullable|numeric|min:0',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
        ]);

        $this->orderService->createOrder($validated);

        return to_route('orders.index');
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'status', 'items']);

        $order->status->load('allowedNextStatuses');

        return Inertia::render('Orders/Show', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $statuses = OrderStatus::all();
        $customers = Customer::all();

        $order->load(['items']);

        return Inertia::render('Orders/Edit', [
            'order' => $order,
            'statuses' => $statuses,
            'customers' => $customers,
        ]);
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status_id' => 'required|exists:order_statuses,id',
            'shipping_address' => 'required|array',
            'billing_address' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $this->orderService->updateOrder($order, $validated);

        return to_route('orders.index');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        $this->orderService->deleteOrder($order);

        return to_route('orders.index');
    }
}
