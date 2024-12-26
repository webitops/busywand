<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Link :href="route('login')" class="text-blue-500 hover:underline"
        ><slot />
    </Link>
</template>

<style scoped></style>
