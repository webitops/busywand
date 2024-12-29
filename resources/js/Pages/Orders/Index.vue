<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Link from '@/Components/Link.vue';

defineProps({
    orders: Array,
});
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="text-bold text-lg">Index Orders</h1>
        <hr class="separator" />
        <div>
            <ul>
                <li v-for="order in orders.data" :key="order.id">
                    <Link :href="route('orders.show', order.id)">
                        {{ order.order_number }}
                    </Link>
                    <span class="text-xs font-bold uppercase"
                        >(Status:{{ order.status.name }})</span
                    >
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
