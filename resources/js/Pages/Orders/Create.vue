<template>
    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <div class="flex gap-6">
                <!-- Order Details Section -->
                <div class="w-2/3">
                    <Card>
                        <CardHeader>
                            <CardTitle>Create New Order</CardTitle>
                            <CardDescription
                                >Add items and configure order details
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <div class="grid gap-4">
                                <!-- Customer Selection -->
                                <div class="space-y-2">
                                    <Label>Customer</Label>
                                    <Select v-model="form.customer_id">
                                        <SelectTrigger>
                                            <SelectValue
                                                placeholder="Select a customer"
                                            />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem
                                                v-for="customer in customers.data"
                                                :key="customer.id"
                                                :value="customer.id"
                                            >
                                                {{ customer.name }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>

                                <!-- Status Selection -->
                                <div class="space-y-2">
                                    <Label>Order Status</Label>
                                    <Select v-model="form.status_id">
                                        <SelectTrigger>
                                            <SelectValue
                                                placeholder="Select status"
                                            />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectItem
                                                v-for="status in statuses"
                                                :key="status.id"
                                                :value="status.id"
                                            >
                                                {{ status.name }}
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>
                                </div>

                                <!-- Order Items Table -->
                                <div class="mt-6">
                                    <h3 class="mb-4 font-medium">
                                        Order Items
                                    </h3>
                                    <div
                                        v-if="form.order.variants.length === 0"
                                        class="py-8 text-center text-muted-foreground"
                                    >
                                        <PackageIcon
                                            class="mx-auto mb-2 h-12 w-12 opacity-50"
                                        />
                                        <p>No items added to order yet</p>
                                    </div>
                                    <Table v-else>
                                        <TableHeader>
                                            <TableRow>
                                                <TableHead>Product</TableHead>
                                                <TableHead>Quantity</TableHead>
                                                <TableHead>Price</TableHead>
                                                <TableHead>Tax</TableHead>
                                                <TableHead>Discount</TableHead>
                                                <TableHead>Total</TableHead>
                                                <TableHead></TableHead>
                                            </TableRow>
                                        </TableHeader>
                                        <TableBody>
                                            <TableRow
                                                v-for="variant in form.order
                                                    .variants"
                                                :key="variant.id"
                                            >
                                                <TableCell>
                                                    <div>
                                                        <p class="font-medium">
                                                            {{
                                                                variant.product
                                                                    .name
                                                            }}
                                                        </p>
                                                        <p
                                                            class="text-sm text-muted-foreground"
                                                        >
                                                            SKU:
                                                            {{ variant.sku }}
                                                        </p>
                                                    </div>
                                                </TableCell>
                                                <TableCell>
                                                    <Input
                                                        type="number"
                                                        v-model="
                                                            variant.quantity
                                                        "
                                                        class="w-20"
                                                        min="1"
                                                    />
                                                </TableCell>
                                                <TableCell
                                                    >{{
                                                        formatPrice(
                                                            variant.price,
                                                        )
                                                    }}
                                                </TableCell>
                                                <TableCell
                                                    >{{
                                                        formatPrice(
                                                            variant.tax ?? 0,
                                                        )
                                                    }}
                                                </TableCell>
                                                <TableCell
                                                    >{{
                                                        formatPrice(
                                                            variant.discount ??
                                                                0,
                                                        )
                                                    }}
                                                </TableCell>
                                                <TableCell class="font-medium">
                                                    {{
                                                        formatPrice(
                                                            variant.quantity *
                                                                variant.price,
                                                        )
                                                    }}
                                                </TableCell>
                                                <TableCell>
                                                    <Button
                                                        variant="ghost"
                                                        size="icon"
                                                        @click="
                                                            removeVariant(
                                                                variant,
                                                            )
                                                        "
                                                    >
                                                        <TrashIcon
                                                            class="h-4 w-4"
                                                        />
                                                    </Button>
                                                </TableCell>
                                            </TableRow>
                                        </TableBody>
                                    </Table>

                                    <!-- Order Summary -->
                                    <div
                                        v-if="form.order.variants.length > 0"
                                        class="mt-6 space-y-2"
                                    >
                                        <div class="flex justify-end text-sm">
                                            <span class="w-24">Subtotal:</span>
                                            <span class="w-32 text-right">{{
                                                formatPrice(getSubTotal())
                                            }}</span>
                                        </div>
                                        <div class="flex justify-end text-sm">
                                            <span class="w-24">Tax:</span>
                                            <span class="w-32 text-right">{{
                                                formatPrice(getTotalTax())
                                            }}</span>
                                        </div>
                                        <div class="flex justify-end text-sm">
                                            <span class="w-24">Discount:</span>
                                            <span
                                                class="w-32 text-right text-destructive"
                                            >
                                                -{{
                                                    formatPrice(
                                                        getTotalDiscount(),
                                                    )
                                                }}
                                            </span>
                                        </div>
                                        <Separator />
                                        <div
                                            class="flex justify-end font-medium"
                                        >
                                            <span class="w-24">Total:</span>
                                            <span class="w-32 text-right">{{
                                                formatPrice(getTotal())
                                            }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                        <CardFooter>
                            <Button
                                @click="saveOrder"
                                :disabled="form.processing"
                            >
                                <CheckIcon
                                    v-if="!form.processing"
                                    class="mr-2 h-4 w-4"
                                />
                                <Loader2Icon
                                    v-else
                                    class="mr-2 h-4 w-4 animate-spin"
                                />
                                Create Order
                            </Button>
                        </CardFooter>
                    </Card>
                </div>

                <!-- Product Picker Section -->
                <div class="w-1/3">
                    <Card>
                        <CardHeader>
                            <CardTitle>Add Products</CardTitle>
                            <CardDescription
                                >Select products to add to the order
                            </CardDescription>
                        </CardHeader>
                        <CardContent>
                            <!-- Categories -->
                            <div class="space-y-4">
                                <Label>Categories</Label>
                                <div class="flex flex-wrap gap-2">
                                    <Badge
                                        v-for="category in categories.data"
                                        :key="category.id"
                                        :variant="
                                            productPicker.selectedCategory
                                                ?.id === category.id
                                                ? 'default'
                                                : 'outline'
                                        "
                                        class="cursor-pointer"
                                        @click="selectCategory(category)"
                                    >
                                        {{ category.name }}
                                    </Badge>
                                </div>

                                <!-- Products -->
                                <div
                                    v-if="productPicker.selectedCategory"
                                    class="mt-6"
                                >
                                    <Label>Products</Label>
                                    <div class="mt-2 grid gap-2">
                                        <Button
                                            v-for="product in productPicker
                                                .selectedCategory.products"
                                            :key="product.id"
                                            variant="outline"
                                            :class="{
                                                'border-primary':
                                                    productPicker
                                                        .selectedProduct?.id ===
                                                    product.id,
                                            }"
                                            @click="selectProduct(product)"
                                        >
                                            {{ product.name }}
                                            <Badge
                                                variant="secondary"
                                                class="ml-2"
                                            >
                                                {{
                                                    product.variants?.length ??
                                                    0
                                                }}
                                                variants
                                            </Badge>
                                        </Button>
                                    </div>
                                </div>

                                <!-- Variants -->
                                <div
                                    v-if="productPicker.selectedProduct"
                                    class="mt-6"
                                >
                                    <Label>Variants</Label>
                                    <div class="mt-2 grid grid-cols-2 gap-2">
                                        <Button
                                            v-for="variant in productPicker
                                                .selectedProduct.variants"
                                            :key="variant.id"
                                            size="sm"
                                            variant="outline"
                                            @click="addVariantToOrder(variant)"
                                        >
                                            {{ variant.sku }}
                                            <PlusIcon class="ml-2 h-4 w-4" />
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
// Layout and Core
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { formatPrice } from '@/Helpers/helpers.js';

// UI Components
import { Button } from '@/Components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select';
import { Input } from '@/Components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';
import { Badge } from '@/Components/ui/badge';
import { Label } from '@/Components/ui/label';
import { Separator } from '@/Components/ui/separator';

// Icons
import {
    CheckIcon,
    Loader2Icon,
    PackageIcon,
    PlusIcon,
    TrashIcon,
} from 'lucide-vue-next';

const props = defineProps({
    statuses: Array,
    customers: Object,
    categories: Object,
});

const productPicker = ref({
    selectedCategory: null,
    selectedProduct: null,
});

const form = useForm({
    customer_id: null,
    status_id: props.statuses[0]?.id ?? null,
    order: {
        variants: [],
    },
});

function saveOrder() {
    form.post(route('orders.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // form.reset();
        },
    });
}

function addVariantToOrder(variant) {
    const existingVariant = variantAlreadyInOrder(variant);
    if (existingVariant) {
        existingVariant.quantity = parseInt(existingVariant.quantity) + 1;
        return;
    }
    variant.quantity = 1;
    form.order.variants.push(variant);
}

function variantAlreadyInOrder(variant) {
    return form.order.variants.find(
        (orderVariant) => orderVariant.id === variant.id,
    );
}

function getTotalDiscount() {
    return form.order.variants.reduce(
        (total, variant) => total + (variant.discount ?? 0) * variant.quantity,
        0,
    );
}

function getTotalTax() {
    return form.order.variants.reduce(
        (total, variant) => total + (variant.tax ?? 0) * variant.quantity,
        0,
    );
}

function getSubTotal() {
    return form.order.variants.reduce(
        (total, variant) => total + variant.price * variant.quantity,
        0,
    );
}

function getTotal() {
    return getSubTotal() - getTotalDiscount();
}

function selectCategory(category) {
    productPicker.value.selectedProduct = null;
    productPicker.value.selectedCategory =
        productPicker.value.selectedCategory?.id === category.id
            ? null
            : category;
}

function selectProduct(product) {
    productPicker.value.selectedProduct =
        productPicker.value.selectedProduct?.id === product.id ? null : product;
}

function removeVariant(variant) {
    form.order.variants = form.order.variants.filter(
        (v) => v.id !== variant.id,
    );
}
</script>
