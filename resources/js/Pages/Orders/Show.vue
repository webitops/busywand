<template>
    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <!-- Header -->
            <header class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">
                        Order #{{ order.order_number }}
                    </h1>
                    <p class="mt-2 text-muted-foreground">
                        Created {{ formatDate(order.created_at) }}
                    </p>
                </div>
                <div class="flex items-center gap-4">
                    <Button variant="outline">
                        <PrinterIcon class="mr-2 h-4 w-4" />
                        Print Order
                    </Button>
                    <Button>
                        <MailIcon class="mr-2 h-4 w-4" />
                        Email Invoice
                    </Button>
                </div>
            </header>

            <div class="grid gap-6 md:grid-cols-3">
                <!-- Order Status -->
                <Card>
                    <CardHeader>
                        <CardTitle>Order Status</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="flex flex-col gap-4">
                            <Badge
                                :variant="getStatusVariant(order.status.name)"
                                class="w-fit"
                            >
                                {{ order.status.name }}
                            </Badge>

                            <div
                                v-if="
                                    order.status.allowed_next_statuses?.length >
                                    0
                                "
                            >
                                <Label>Update Status</Label>
                                <Select
                                    v-model="statusForm.status_id"
                                    @update:model-value="updateOrderStatus"
                                >
                                    <SelectTrigger>
                                        <SelectValue
                                            placeholder="Select next status"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem
                                            v-for="status in order.status
                                                .allowed_next_statuses"
                                            :key="status.id"
                                            :value="status.id"
                                        >
                                            {{ status.name }}
                                        </SelectItem>
                                    </SelectContent>
                                </Select>
                                <p
                                    v-if="statusForm.errors.status_id"
                                    class="mt-2 text-sm text-destructive"
                                >
                                    {{ statusForm.errors.status_id }}
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Customer Info -->
                <Card>
                    <CardHeader>
                        <CardTitle>Customer Details</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="flex items-start gap-4">
                            <Avatar class="h-10 w-10">
                                <AvatarImage
                                    :src="`https://avatar.vercel.sh/${order.customer.name}.png`"
                                />
                                <AvatarFallback
                                    >{{ getInitials(order.customer.name) }}
                                </AvatarFallback>
                            </Avatar>
                            <div class="space-y-1">
                                <h3 class="font-medium">
                                    {{ order.customer.name }}
                                </h3>
                                <div class="text-sm text-muted-foreground">
                                    <p class="flex items-center">
                                        <MailIcon class="mr-2 h-4 w-4" />
                                        {{ order.customer.email }}
                                    </p>
                                    <p class="flex items-center">
                                        <PhoneIcon class="mr-2 h-4 w-4" />
                                        {{ order.customer.phone }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Order Summary -->
                <Card>
                    <CardHeader>
                        <CardTitle>Order Summary</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <dl class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <dt class="text-muted-foreground">Subtotal</dt>
                                <dd class="font-medium">
                                    {{ formatPrice(order.subtotal) }}
                                </dd>
                            </div>
                            <div class="flex justify-between text-sm">
                                <dt class="text-muted-foreground">Shipping</dt>
                                <dd class="font-medium">
                                    {{ formatPrice(order.shipping_total) }}
                                </dd>
                            </div>
                            <div class="flex justify-between text-sm">
                                <dt class="text-muted-foreground">Tax</dt>
                                <dd class="font-medium">
                                    {{ formatPrice(order.tax_total) }}
                                </dd>
                            </div>
                            <div class="flex justify-between text-sm">
                                <dt class="text-muted-foreground">Discount</dt>
                                <dd class="font-medium text-destructive">
                                    -{{ formatPrice(order.discount_total) }}
                                </dd>
                            </div>
                            <Separator />
                            <div class="flex justify-between font-medium">
                                <dt>Total</dt>
                                <dd>{{ formatPrice(order.total) }}</dd>
                            </div>
                        </dl>
                    </CardContent>
                </Card>
            </div>

            <!-- Order Items -->
            <Card class="mt-6">
                <CardHeader>
                    <CardTitle>Order Items</CardTitle>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Item</TableHead>
                                <TableHead>Quantity</TableHead>
                                <TableHead>Unit Price</TableHead>
                                <TableHead>Tax</TableHead>
                                <TableHead>Discount</TableHead>
                                <TableHead>Total</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="item in order.items"
                                :key="item.id"
                            >
                                <TableCell>
                                    <div>
                                        <p class="font-medium">
                                            {{ item.name }}
                                        </p>
                                        <p
                                            class="text-sm text-muted-foreground"
                                        >
                                            SKU: {{ item.sku }}
                                        </p>
                                    </div>
                                </TableCell>
                                <TableCell>{{ item.quantity }}</TableCell>
                                <TableCell
                                    >{{ formatPrice(item.unit_price) }}
                                </TableCell>
                                <TableCell
                                    >{{ formatPrice(item.tax_amount) }}
                                </TableCell>
                                <TableCell
                                    >{{ formatPrice(item.discount_amount) }}
                                </TableCell>
                                <TableCell class="font-medium"
                                    >{{ formatPrice(item.total) }}
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { MailIcon, PhoneIcon, PrinterIcon } from 'lucide-vue-next';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
});

const statusForm = useForm({
    status_id: null,
});

function formatPrice(price) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(Number(price));
}

function formatDate(date) {
    return new Intl.DateTimeFormat('en-US', {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(date));
}

function getInitials(name) {
    return name
        .split(' ')
        .map((word) => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
}

function getStatusVariant(status) {
    const variants = {
        Pending: 'warning',
        Processing: 'default',
        Shipped: 'secondary',
        Delivered: 'success',
        Cancelled: 'destructive',
    };
    return variants[status] || 'default';
}

function updateOrderStatus() {
    statusForm.put(route('orders.update-order-status', props.order.id), {
        preserveScroll: true,
        onSuccess: () => {
            statusForm.reset();
        },
    });
}
</script>
