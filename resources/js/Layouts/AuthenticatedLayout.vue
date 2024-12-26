<script setup>
import { usePage, Link } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
</script>
<template>
    <Link
        class="text-xl font-bold text-blue-500 hover:underline"
        :href="route('dashboard')"
    >
        Backend</Link
    >
    <br />
    Hello, {{ user.name }}
    <br />
    <div class="flex gap-3">
        <Link
            class="text-blue-500 hover:underline"
            :href="route('logout')"
            method="post"
            as="button"
            >Logout
        </Link>
        <Link
            class="text-blue-500 hover:underline"
            :href="route('profile.edit')"
            >Profile
        </Link>
    </div>
    <hr />
    <slot />
</template>
