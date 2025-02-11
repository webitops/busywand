<template>
    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <header class="mb-6 flex items-center justify-between">
                <h1 class="text-3xl font-bold tracking-tight">Products</h1>
                <Button variant="default" :href="route('products.create')">
                    <PlusIcon class="mr-2 h-4 w-4" />
                    Add Product
                </Button>
            </header>

            <Card>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>ID</TableHead>
                            <TableHead>Name</TableHead>
                            <TableHead>Price</TableHead>
                            <TableHead>Variants</TableHead>
                            <TableHead class="w-[100px]">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="product in products.data"
                            :key="product.id"
                        >
                            <TableCell>{{ product.id }}</TableCell>
                            <TableCell>
                                <Link
                                    :href="route('products.show', product.id)"
                                >
                                    {{ product.name }}
                                </Link>
                            </TableCell>
                            <TableCell
                                >{{ formatPrice(product.price) }}
                            </TableCell>
                            <TableCell>{{ product.variants_count }}</TableCell>
                            <TableCell>
                                <DropdownMenu>
                                    <DropdownMenuTrigger asChild>
                                        <Button variant="ghost" size="icon">
                                            <MoreHorizontalIcon
                                                class="h-4 w-4"
                                            />
                                            <span class="sr-only">Actions</span>
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem as-child>
                                            <Link
                                                :href="
                                                    route(
                                                        'products.edit',
                                                        product.id,
                                                    )
                                                "
                                                class="flex gap-2"
                                            >
                                                <PencilIcon class="h-4 w-4" />
                                                Edit
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem
                                            class="text-destructive"
                                        >
                                            <Link
                                                class="flex gap-2"
                                                :href="
                                                    route(
                                                        'products.destroy',
                                                        product.id,
                                                    )
                                                "
                                                method="delete"
                                                as="button"
                                            >
                                                <TrashIcon class="h-4 w-4" />
                                                Delete
                                            </Link>
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Link from '@/Components/Link.vue';
import { formatPrice } from '@/Helpers/helpers.js';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
} from '@/components/ui/table';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
} from '@/components/ui/dropdown-menu';
import {
    MoreHorizontalIcon,
    PencilIcon,
    PlusIcon,
    TrashIcon,
} from 'lucide-vue-next';
import { TableRow } from '@/Components/ui/table/index.js';
import { DropdownMenuTrigger } from '@/Components/ui/dropdown-menu/index.js';

defineProps({
    products: Object,
});
</script>
