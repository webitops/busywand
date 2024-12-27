<template>
    <AuthenticatedLayout>
        <p>Index products</p>
        <ul>
            <li v-for="product in products.data" :key="product.id">
                <Link :href="route('product.show', product.id)">
                    #{{ product.id }} {{ product.name }} -
                    {{ formatPrice(product.price) }} ({{
                        product.variants_count
                    }}
                    variants)
                </Link>
            </li>
        </ul>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Link from '@/Components/Link.vue';

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
