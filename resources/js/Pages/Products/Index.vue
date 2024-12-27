<template>
    <AuthenticatedLayout>
        <p>Index products</p>
        <ul>
            <li v-for="product in products.data" :key="product.id">
                #{{ product.id }} {{ product.name }} -
                {{ formatPrice(product.price) }} ({{ product.variants_count }}
                variants)
            </li>
        </ul>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    products: Object,
});

const formatPrice = (price) => {
    const numericPrice = Number(price);
    if (isNaN(numericPrice)) {
        return 'Invalid Price';
    }

    return `$${numericPrice.toFixed(2)}`;
};
</script>
