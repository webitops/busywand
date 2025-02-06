<script setup>
import { Button } from '@/Components/ui/button/index.js';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        Dashboard
        <Button>Test button</Button>
    </AuthenticatedLayout>
</template>
