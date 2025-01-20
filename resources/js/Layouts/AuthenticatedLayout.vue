<script setup>
import { usePage } from '@inertiajs/vue3';
import Link from '@/Components/Link.vue';

const user = usePage().props.auth.user.data;
</script>
<template>
    <div class="flex h-full">
        <div class="w-64 bg-white p-4">
            <Link
                class="text-xl font-bold text-blue-500 hover:underline"
                :href="route('dashboard')"
            >
                Backend
            </Link>
            <br />
            Hello, {{ user.name }}
            <hr class="separator" />
            <div class="flex flex-col gap-1">
                <Link :href="route('orders.index')">Orders</Link>
                <Link :href="route('products.index')">Products</Link>
                <Link :href="route('categories.index')">Categories</Link>
                <Link :href="route('customers.index')">Customers</Link>
                <Link :href="route('customer_groups.index')"
                    >Customer Groups
                </Link>
                <Link :href="route('order-statuses.index')"
                    >Order Statuses
                </Link>
                <hr class="separator" />
                <Link :href="route('logout')" method="post" as="button"
                    >Logout
                </Link>
                <Link :href="route('profile.edit')">Profile</Link>
            </div>
        </div>
        <div class="h-full flex-1 p-4">
            <slot />
        </div>
    </div>
</template>
