<script setup>
// Layout and Core
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';

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
import { Input } from '@/Components/ui/input';
import { Label } from '@/Components/ui/label';
import { Textarea } from '@/Components/ui/textarea';
import {
    PlusIcon,
    TrashIcon,
    CheckIcon,
    Loader2Icon,
    ArrowLeftIcon,
    TagIcon
} from 'lucide-vue-next';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select';

// Form setup
const form = useForm({
    name: '',
    sku: '',
    description: '',
    price: '',
    variants: [
        {
            sku: '',
            price: '',
            stock_quantity: 1,
            options: {}
        }
    ]
});

// Define common option types for products
const commonOptions = [
    { name: 'color', values: ['Red', 'Blue', 'Green', 'Black', 'White'] },
    { name: 'size', values: ['S', 'M', 'L', 'XL', 'XXL'] },
];

// Variables for adding options to variants
const optionToAdd = ref(null);
const valueToAdd = ref(null);

// Add an option to a variant
function addOptionToVariant(variant, optionName, optionValue) {
    variant.options = {
        ...variant.options,
        [optionName]: optionValue
    };
}

// Remove an option from a variant
function removeOptionFromVariant(variant, optionName) {
    const newOptions = { ...variant.options };
    delete newOptions[optionName];
    variant.options = newOptions;
}

// Add a new variant to the form
function addVariant() {
    form.variants.push({
        sku: '',
        price: '',
        stock_quantity: 1,
        options: {}
    });
}

// Remove a variant from the form
function removeVariant(index) {
    form.variants.splice(index, 1);
}

// Form validation
const formIsValid = computed(() => {
    return form.name && form.sku && form.price &&
           form.variants.every(variant => variant.stock_quantity > 0);
});

// Submit the form
function saveProduct() {
    if (!formIsValid.value) {
        return;
    }

    form.post(route('products.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // Redirect to products index with success message
            window.location.href = route('products.index');
        },
    });
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <header class="mb-6 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link :href="route('products.index')" class="inline-flex">
                        <Button variant="outline" size="icon" class="mr-2">
                            <ArrowLeftIcon class="h-4 w-4" />
                        </Button>
                    </Link>
                    <h1 class="text-3xl font-bold tracking-tight">Create New Product</h1>
                </div>
            </header>

            <Card>
                <CardHeader>
                    <CardTitle>Product Details</CardTitle>
                    <CardDescription>Enter the basic information for your product</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="grid gap-4">
                        <!-- Product Name -->
                        <div class="space-y-2">
                            <Label for="name">Product Name</Label>
                            <Input id="name" v-model="form.name" placeholder="Enter product name" />
                            <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
                        </div>

                        <!-- Product SKU -->
                        <div class="space-y-2">
                            <Label for="sku">SKU</Label>
                            <Input id="sku" v-model="form.sku" placeholder="Enter product SKU" />
                            <div v-if="form.errors.sku" class="text-sm text-red-500">{{ form.errors.sku }}</div>
                        </div>

                        <!-- Product Description -->
                        <div class="space-y-2">
                            <Label for="description">Description</Label>
                            <Textarea id="description" v-model="form.description" placeholder="Enter product description" />
                            <div v-if="form.errors.description" class="text-sm text-red-500">{{ form.errors.description }}</div>
                        </div>

                        <!-- Product Price -->
                        <div class="space-y-2">
                            <Label for="price">Price</Label>
                            <Input id="price" type="number" step="0.01" v-model="form.price" placeholder="Enter product price" />
                            <div v-if="form.errors.price" class="text-sm text-red-500">{{ form.errors.price }}</div>
                        </div>

                        <!-- Variants Section -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium">Product Variants</h3>
                                <Button variant="outline" size="sm" @click="addVariant">
                                    <PlusIcon class="mr-2 h-4 w-4" />
                                    Add Variant
                                </Button>
                            </div>

                            <div v-for="(variant, index) in form.variants" :key="index" class="mt-4 rounded-md border p-4">
                                <div class="flex justify-between">
                                    <h4 class="font-medium">Variant {{ index + 1 }}</h4>
                                    <Button v-if="form.variants.length > 1" variant="ghost" size="icon" @click="removeVariant(index)">
                                        <TrashIcon class="h-4 w-4" />
                                    </Button>
                                </div>

                                <div class="mt-2 grid gap-4 md:grid-cols-3">
                                    <!-- Variant SKU -->
                                    <div class="space-y-2">
                                        <Label :for="`variant-sku-${index}`">SKU</Label>
                                        <Input :id="`variant-sku-${index}`" v-model="variant.sku" placeholder="Variant SKU" />
                                        <div v-if="form.errors[`variants.${index}.sku`]" class="text-sm text-red-500">
                                            {{ form.errors[`variants.${index}.sku`] }}
                                        </div>
                                    </div>

                                    <!-- Variant Price -->
                                    <div class="space-y-2">
                                        <Label :for="`variant-price-${index}`">Price</Label>
                                        <Input :id="`variant-price-${index}`" type="number" step="0.01" v-model="variant.price" placeholder="Variant price" />
                                        <div v-if="form.errors[`variants.${index}.price`]" class="text-sm text-red-500">
                                            {{ form.errors[`variants.${index}.price`] }}
                                        </div>
                                    </div>

                                    <!-- Variant Stock -->
                                    <div class="space-y-2">
                                        <Label :for="`variant-stock-${index}`">Stock Quantity</Label>
                                        <Input :id="`variant-stock-${index}`" type="number" v-model="variant.stock_quantity" placeholder="Stock quantity" />
                                        <div v-if="form.errors[`variants.${index}.stock_quantity`]" class="text-sm text-red-500">
                                            {{ form.errors[`variants.${index}.stock_quantity`] }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Variant Options -->
                                <div class="mt-4 border-t pt-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h5 class="text-sm font-medium flex items-center">
                                            <TagIcon class="h-4 w-4 mr-1" />
                                            Options
                                        </h5>
                                    </div>

                                    <!-- Current Options -->
                                    <div v-if="Object.keys(variant.options).length > 0" class="mb-3 flex flex-wrap gap-2">
                                        <div
                                            v-for="(value, name) in variant.options"
                                            :key="name"
                                            class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs"
                                        >
                                            <span class="font-medium">{{ name }}:</span>
                                            <span class="ml-1">{{ value }}</span>
                                            <button
                                                type="button"
                                                class="ml-1 text-gray-500 hover:text-gray-700"
                                                @click="removeOptionFromVariant(variant, name)"
                                            >
                                                <TrashIcon class="h-3 w-3" />
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Add Option -->
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <Select v-model="optionToAdd" placeholder="Select option">
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select option" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem
                                                        v-for="option in commonOptions"
                                                        :key="option.name"
                                                        :value="option.name"
                                                    >
                                                        {{ option.name }}
                                                    </SelectItem>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <div>
                                            <Select v-model="valueToAdd" placeholder="Select value">
                                                <SelectTrigger>
                                                    <SelectValue placeholder="Select value" />
                                                </SelectTrigger>
                                                <SelectContent>
                                                    <SelectItem
                                                        v-for="value in optionToAdd ? commonOptions.find(o => o.name === optionToAdd)?.values || [] : []"
                                                        :key="value"
                                                        :value="value"
                                                    >
                                                        {{ value }}
                                                    </SelectItem>
                                                </SelectContent>
                                            </Select>
                                        </div>
                                        <Button
                                            variant="outline"
                                            size="sm"
                                            class="col-span-2"
                                            @click="addOptionToVariant(variant, optionToAdd, valueToAdd); optionToAdd = null; valueToAdd = null;"
                                            :disabled="!optionToAdd || !valueToAdd"
                                        >
                                            <PlusIcon class="mr-2 h-4 w-4" />
                                            Add Option
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </CardContent>
                <CardFooter>
                    <Button @click="saveProduct" :disabled="form.processing">
                        <CheckIcon v-if="!form.processing" class="mr-2 h-4 w-4" />
                        <Loader2Icon v-else class="mr-2 h-4 w-4 animate-spin" />
                        Create Product
                    </Button>
                </CardFooter>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>
