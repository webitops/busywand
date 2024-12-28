<template>
    <AuthenticatedLayout>
        <h3 class="text-lg font-medium">Customers</h3>

        <ul>
            <li v-for="customer in customers.data" :key="customer.id">
                {{ customer.name }} [groups: (<span
                    v-for="group in customer.customer_groups"
                    :key="group.id"
                    >{{ group.name }}, </span
                >)]
                <Link
                    :method="'delete'"
                    :href="route('customers.destroy', customer.id)"
                    class="text-red-500"
                    >Delete
                </Link>
            </li>
        </ul>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Link from '@/Components/Link.vue';

defineProps({
    customers: Object,
});
</script>
