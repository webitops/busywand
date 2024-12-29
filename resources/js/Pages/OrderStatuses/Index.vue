<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    statuses: Array,
});
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="text-xl font-bold">Index Order Statuses</h1>

        <ul>
            <li v-for="status in statuses" :key="status.id">
                {{ status.name }}
                <span
                    class="rounded border px-3 py-1 text-sm"
                    v-if="status.allowed_next_statuses.length > 0"
                >
                    <span class="font-bold">Next</span>:
                    <span
                        v-for="nextStatus in status.allowed_next_statuses"
                        :key="nextStatus.id"
                        >{{ nextStatus.name }},
                    </span>
                </span>
            </li>
        </ul>
    </AuthenticatedLayout>
</template>

<style scoped></style>
