<script setup>
import { Head } from '@inertiajs/vue3';
import Link from '@/Components/Link.vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    Welcome
    <p v-if="!page.props.auth.user">
        <Link :href="route('login')">Login</Link>
        or
        <Link :href="route('register')">Register</Link>
    </p>
    <p v-if="page.props.auth.user">
        Go to <Link :href="route('dashboard')">Dashboard</Link>
    </p>
</template>
