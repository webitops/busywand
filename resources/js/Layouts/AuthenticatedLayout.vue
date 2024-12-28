<script setup>
import { usePage } from '@inertiajs/vue3';
import Link from '@/Components/Link.vue';

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
        <Link :href="route('product.index')">Products</Link>
        <Link :href="route('categories.index')">Categories</Link>
        <Link :href="route('customers.index')">Customers</Link>
        <Link :href="route('customer_groups.index')">Customer Groups</Link>
        <span>|</span>
        <Link :href="route('logout')" method="post" as="button">Logout</Link>
        <Link :href="route('profile.edit')">Profile</Link>
    </div>
    <hr />
    <slot />
</template>
