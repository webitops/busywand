<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { formatPrice } from '@/Helpers/helpers.js';

const props = defineProps({
    statuses: Object,
    customers: Object,
    categories: Object,
});

let form = useForm({
    customer_id: null,
    status_id: props.statuses[0]?.id ?? null,
    order: {
        variants: [],
    },
});
</script>

<template>
    <AuthenticatedLayout>
        <div class="flex w-full gap-4">
            <div class="flex-[3]">
                <h1 class="text-xl font-bold">Create Order</h1>
                <hr />
                <label
                    >Default Status:
                    <select v-model="form.status_id">
                        <option
                            v-for="status in statuses"
                            :key="status.id"
                            :value="status.id"
                        >
                            {{ status.name }}
                        </option>
                    </select>
                </label>
                <br />

                <label>
                    Customer
                    <select v-model="form.customer_id">
                        <option
                            v-for="customer in customers.data"
                            :key="customer.id"
                            :value="customer.id"
                        >
                            {{ customer.name }}
                        </option>
                    </select>
                </label>

                <hr />
                <div class="flex flex-col gap-4 p-5">
                    <div v-for="category in categories.data" :key="category.id">
                        <h2 class="text-xl font-bold">{{ category.name }}</h2>
                        <div
                            class="m-3 rounded border p-4"
                            v-for="product in category.products"
                            :key="product.id"
                        >
                            {{ product.name }}
                            <span
                                >(Variants:
                                {{ product.variants?.length ?? 0 }})</span
                            >
                            <div class="flex flex-wrap gap-2">
                                <button
                                    class="rounded border px-4 py-2 text-xs uppercase hover:bg-gray-100"
                                    v-for="variant in product.variants"
                                    :key="variant.id"
                                    @click="form.order.variants.push(variant)"
                                >
                                    {{ variant.sku }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-[1]">
                <h1 class="text-xl font-bold">Order summary</h1>
                <ul>
                    <li
                        v-for="variant in form.order.variants"
                        :key="variant.id"
                        class="flex justify-between gap-2"
                    >
                        <span>{{ variant.sku }}</span>
                        <span>{{ formatPrice(variant.price) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped></style>
