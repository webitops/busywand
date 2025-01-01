<template>
    <AuthenticatedLayout>
        <h1 class="text-xl font-bold">Index Products</h1>
        <ul>
            <li v-for="product in products.data" :key="product.id">
                <Link :href="route('products.show', product.id)">
                    #{{ product.id }} {{ product.name }} -
                    {{ formatPrice(product.price) }} ({{
                        product.variants_count
                    }}
                    variants)
                </Link>
                <Link
                    :href="route('products.destroy', product.id)"
                    as="button"
                    method="delete"
                    class="text-red-500"
                >
                    Delete
                </Link>
            </li>
        </ul>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Link from '@/Components/Link.vue';
import { formatPrice } from '@/Helpers/helpers.js';

defineProps({
    products: Object,
});
</script>

<style scoped>
/*[data-loading] {
    visibility: hidden;
}
[data-loading]::after {
    content: 'Loading...';
    visibility: visible;
}*/
</style>
