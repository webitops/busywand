<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    product: Object,
});
</script>

<template>
    <AuthenticatedLayout>
        Show product: {{ product.name }}
        <ul>
            <li
                class="odd:bg-gray-100"
                v-for="variant in product.variants"
                :key="variant.id"
            >
                <span class="font-bold">
                    #{{ variant.id }} - {{ variant.sku }}</span
                >
                <ul class="ml-8 list-disc">
                    <li
                        v-for="attribute_value in variant.attributes"
                        :key="attribute_value.id"
                    >
                        {{ attribute_value.attribute.name }}:
                        {{ attribute_value.value }}
                    </li>
                </ul>
            </li>
        </ul>
    </AuthenticatedLayout>
</template>

<style scoped></style>
