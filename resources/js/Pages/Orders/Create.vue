<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { formatPrice } from '../../Helpers/helpers.js';

const props = defineProps({
    statuses: Object,
    customers: Object,
    categories: Object,
});

let productPicker = ref({
    selectedCategory: props.categories.data[0],
    selectedProduct: props.categories.data[0]?.products[0],
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
        <div class="flex h-full max-h-full flex-col justify-between gap-4">
            <div>
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
                <h1 class="text-xl font-bold">Order summary</h1>
                <p
                    class="w-full p-4 text-center italic text-gray-700"
                    v-if="form.order.variants.length <= 0"
                >
                    Add products to the order...
                </p>
                <table
                    v-if="form.order.variants.length > 0"
                    class="table-auto border-collapse border border-gray-300"
                >
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-2 py-1">#</th>
                            <th class="border border-gray-300 px-2 py-1">
                                Item Name
                                <span class="text-xs uppercase">(SKU)</span>
                            </th>
                            <th class="border border-gray-300 px-2 py-1">
                                Quantity
                            </th>
                            <th class="border border-gray-300 px-2 py-1">
                                Price
                            </th>
                            <th class="border border-gray-300 px-2 py-1">
                                Tax
                            </th>
                            <th class="border border-gray-300 px-2 py-1">
                                Discount
                            </th>
                            <th class="border border-gray-300 px-2 py-1">
                                Subtotal
                            </th>
                            <th class="border border-gray-300 px-2 py-1">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(variant, key) in form.order.variants"
                            :key="variant.id"
                        >
                            <td class="border border-gray-300 px-2 py-1">
                                {{ key + 1 }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                {{ variant.product.name }}
                                <span class="text-xs uppercase"
                                    >({{ variant.sku }})</span
                                >
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                x{{ variant.quantity ?? 1 }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                {{ formatPrice(variant.price) }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                {{ formatPrice(variant.tax ?? 0) }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                {{ formatPrice(variant.discount ?? 0) }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                {{
                                    formatPrice(
                                        variant.quantity ?? 1 * variant.price,
                                    )
                                }}
                            </td>
                            <td class="border border-gray-300 px-2 py-1">
                                {{
                                    formatPrice(
                                        variant.quantity ?? 1 * variant.price,
                                    )
                                }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="">
                <div class="flex flex-col gap-4 p-5">
                    <div class="flex flex-wrap gap-2">
                        <button
                            :class="{
                                'border-red-500':
                                    productPicker.selectedCategory?.id ===
                                    category.id,
                            }"
                            @click="
                                productPicker.selectedProduct = null;
                                productPicker.selectedCategory?.id ===
                                category.id
                                    ? (productPicker.selectedCategory = null)
                                    : (productPicker.selectedCategory =
                                          category);
                            "
                            class="cursor-pointer rounded border px-3 py-1 hover:bg-gray-100"
                            v-for="category in categories.data"
                            :key="category.id"
                        >
                            {{ category.name }}
                        </button>
                    </div>
                    <hr />
                    <div
                        class="flex flex-wrap gap-2"
                        v-if="productPicker.selectedCategory"
                    >
                        <button
                            :class="{
                                'border-red-500':
                                    productPicker.selectedProduct?.id ===
                                    product.id,
                            }"
                            @click="
                                productPicker.selectedProduct?.id === product.id
                                    ? (productPicker.selectedProduct = null)
                                    : (productPicker.selectedProduct = product)
                            "
                            class="cursor-pointer rounded border px-3 py-1 hover:bg-gray-100"
                            v-for="product in productPicker.selectedCategory
                                .products"
                            :key="product.id"
                        >
                            {{ product.name }} (Variants:
                            {{ product.variants?.length ?? 0 }})
                        </button>
                    </div>
                    <div v-if="productPicker.selectedProduct">
                        <span
                            >(Variants:
                            {{
                                productPicker.selectedProduct.variants
                                    ?.length ?? 0
                            }})</span
                        >
                        <div class="flex flex-wrap gap-2">
                            <button
                                class="rounded border px-4 py-2 text-xs uppercase hover:bg-gray-100 active:bg-red-500 active:text-white"
                                v-for="variant in productPicker.selectedProduct
                                    .variants"
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
    </AuthenticatedLayout>
</template>

<style scoped></style>
