<template>
    <AuthenticatedLayout>
        <p>Index products</p>
        <ul>
            <li v-for="product in products.data" :key="product.id">
                #{{ product.id }} {{ product.name }} -
                {{ formatPrice(product.price) }} ({{ product.variants.length }}
                variants) => (total
                <span>{{
                    Array.isArray(product.variants)
                        ? product.variants.reduce(
                              (accumulator, current) =>
                                  accumulator +
                                  Number(current.stock_quantity || 0),
                              0,
                          )
                        : 0
                }}</span>
                in stocks)
                <ul>
                    <li v-for="variant in product.variants" :key="variant.id">
                        #{{ variant.id }} - {{ product.sku }} (<span
                            v-for="attribute_value in variant.attributes"
                            :key="attribute_value.id"
                            >&nbsp;{{ attribute_value.attribute.name }}:
                            {{ attribute_value.value }},</span
                        >) {{ formatPrice(variant.price) }} =>
                        {{ variant.stock_quantity }} in stock
                    </li>
                </ul>
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

<style>
.table-auto {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f9f9f9;
}
</style>
