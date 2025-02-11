<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Link from '@/Components/Link.vue';
import { Button } from '@/Components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Eye, Plus } from 'lucide-vue-next';
import { formatPrice } from '../../Helpers/helpers.js';
import { Badge } from '@/Components/ui/badge/index.js';

defineProps({
    orders: Object,
});
</script>

<template>
    <AuthenticatedLayout>
        <h1 class="text-bold text-lg">Index Orders</h1>
        <div class="flex justify-end">
            <Button as-child>
                <Link :href="route('orders.create')">
                    <Plus class="h-6 w-6" />
                    Add order
                </Link>
            </Button>
        </div>

        <Table>
            <TableHeader>
                <TableRow>
                    <TableHead> Order ID</TableHead>
                    <TableHead>Customer</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead> Amount</TableHead>
                    <TableHead class="text-right">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="order in orders.data" :key="order.id">
                    <TableCell class="font-medium">
                        {{ order.order_number }}
                    </TableCell>
                    <TableCell>{{ order.customer.name }}</TableCell>
                    <TableCell>
                        <Badge>{{ order.status.name }}</Badge>
                    </TableCell>
                    <TableCell> {{ formatPrice(order.total) }}</TableCell>
                    <TableCell class="text-right">
                        <Button as-child>
                            <Link :href="route('orders.show', order.id)">
                                <Eye class="h-4 w-4" />
                            </Link>
                        </Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </AuthenticatedLayout>
</template>
