<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    order: Object,
});

let statusForm = useForm({
    status_id: null,
});

const updateOrderStatus = () => {
    statusForm.put(route('orders.update-order-status', props.order.id), {
        preserveScroll: true,
        onSuccess: () => {
            statusForm.reset();
        },
    });
};

const formatPrice = (price) => {
    const numericPrice = Number(price);
    if (isNaN(numericPrice)) {
        return 'Invalid Price';
    }

    return `$${numericPrice.toFixed(2)}`;
};
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="text-bold text-lg">Show Order</h1>
        <hr class="separator" />
        <ul>
            <li>Number: #{{ order.order_number }}</li>
            <li>
                Status: {{ order.status.name }}
                <span
                    class="text-xs"
                    v-if="order.status.allowed_next_statuses?.length > 0"
                >
                    <select
                        class="rounded border border-gray-300 text-sm"
                        v-model="statusForm.status_id"
                        @change="updateOrderStatus"
                    >
                        <option :value="null" disabled>- Next status -</option>
                        <option
                            :value="nextStatus.id"
                            v-for="nextStatus in order.status
                                .allowed_next_statuses"
                            :key="nextStatus.id"
                        >
                            {{ nextStatus.name }}
                        </option>
                    </select>
                    <div
                        v-if="statusForm.errors.status_id"
                        class="text-red-500"
                    >
                        {{ statusForm.errors.status_id }}
                    </div>
                </span>
            </li>
            <li>Customer: {{ order.customer.name }}</li>
            <li>{{ order.customer.email }}</li>
            <li>{{ order.customer.phone }}</li>
        </ul>

        <table class="table-auto border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-2 py-1">#</th>
                    <th class="border border-gray-300 px-2 py-1">
                        Item Name
                        <span class="text-xs uppercase">(SKU)</span>
                    </th>
                    <th class="border border-gray-300 px-2 py-1">Quantity</th>
                    <th class="border border-gray-300 px-2 py-1">Price</th>
                    <th class="border border-gray-300 px-2 py-1">Tax</th>
                    <th class="border border-gray-300 px-2 py-1">Discount</th>
                    <th class="border border-gray-300 px-2 py-1">Subtotal</th>
                    <th class="border border-gray-300 px-2 py-1">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in order.items" :key="item.id">
                    <td class="border border-gray-300 px-2 py-1">
                        {{ index + 1 }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ item.name }}
                        <span class="text-xs uppercase">({{ item.sku }})</span>
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        x{{ item.quantity }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ formatPrice(item.unit_price) }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ formatPrice(item.tax_amount) }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ formatPrice(item.discount_amount) }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ formatPrice(item.subtotal) }}
                    </td>
                    <td class="border border-gray-300 px-2 py-1">
                        {{ formatPrice(item.total) }}
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="border-b">
                    <td colspan="7" class="text-right font-bold">Discount</td>
                    <td colspan="2">
                        {{ formatPrice(order.discount_total) }}
                    </td>
                </tr>
                <tr class="border-b">
                    <td colspan="7" class="text-right font-bold">Shipping</td>
                    <td colspan="2">
                        {{ formatPrice(order.shipping_total) }}
                    </td>
                </tr>
                <tr class="border-b">
                    <td colspan="7" class="text-right font-bold">Tax</td>
                    <td colspan="2">
                        {{ formatPrice(order.tax_total) }}
                    </td>
                </tr>
                <tr class="border-b">
                    <td colspan="7" class="text-right font-bold">Subtotal</td>
                    <td colspan="2">
                        {{ formatPrice(order.subtotal) }}
                    </td>
                </tr>
                <tr class="border-b">
                    <td colspan="7" class="text-right font-bold">Total</td>
                    <td colspan="2">{{ formatPrice(order.total) }}</td>
                </tr>
            </tfoot>
        </table>
    </AuthenticatedLayout>
</template>

<style scoped></style>
