<template>
    <AuthenticatedLayout>
        <h3 class="text-lg font-medium">Customer Groups</h3>

        <hr />
        <ul>
            <li v-for="group in groups.data" :key="group.id">
                {{ group.name }} (Customers: {{ group.customers_count }})
                <Link
                    class="text-red-500"
                    :href="route('customer_groups.destroy', group.id)"
                    :method="'delete'"
                >
                    Delete
                </Link>
            </li>
        </ul>
    </AuthenticatedLayout>
</template>

<script setup>
import Link from '@/Components/Link.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    groups: {
        type: Object,
        required: true,
    },
});
</script>
