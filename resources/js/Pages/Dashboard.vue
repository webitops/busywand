<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <!-- Header -->
            <header class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight">Dashboard</h1>
                <p class="mt-2 text-muted-foreground">
                    Welcome back, here's what's happening today
                </p>
            </header>

            <!-- Metrics Grid -->
            <div class="mb-8 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader
                        class="flex flex-row items-center justify-between space-y-0 pb-2"
                    >
                        <CardTitle class="text-sm font-medium"
                            >Total Customers
                        </CardTitle>
                        <UsersIcon class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ metrics.total_customers }}
                        </div>
                        <p class="text-xs text-muted-foreground">
                            Active customer base
                        </p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader
                        class="flex flex-row items-center justify-between space-y-0 pb-2"
                    >
                        <CardTitle class="text-sm font-medium"
                            >Orders This Week
                        </CardTitle>
                        <PackageIcon class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ metrics.orders_this_week }}
                        </div>
                        <p class="text-xs text-muted-foreground">
                            +{{
                                (
                                    (metrics.orders_this_week /
                                        metrics.total_orders) *
                                    100
                                ).toFixed(1)
                            }}% of total
                        </p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader
                        class="flex flex-row items-center justify-between space-y-0 pb-2"
                    >
                        <CardTitle class="text-sm font-medium"
                            >Monthly Revenue
                        </CardTitle>
                        <DollarSignIcon class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            ${{ formatNumber(metrics.revenue_this_month) }}
                        </div>
                        <p class="text-xs text-muted-foreground">
                            This month's earnings
                        </p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader
                        class="flex flex-row items-center justify-between space-y-0 pb-2"
                    >
                        <CardTitle class="text-sm font-medium"
                            >Total Orders
                        </CardTitle>
                        <ShoppingCartIcon
                            class="h-4 w-4 text-muted-foreground"
                        />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ metrics.total_orders }}
                        </div>
                        <p class="text-xs text-muted-foreground">
                            Lifetime orders
                        </p>
                    </CardContent>
                </Card>
            </div>

            <!-- Main Content Grid -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-7">
                <!-- Recent Orders -->
                <Card class="lg:col-span-4">
                    <CardHeader>
                        <CardTitle>Recent Orders</CardTitle>
                        <CardDescription
                            >Latest 5 orders in the system
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Order</TableHead>
                                    <TableHead>Customer</TableHead>
                                    <TableHead>Status</TableHead>
                                    <TableHead>Amount</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow
                                    v-for="order in recentOrders"
                                    :key="order.id"
                                >
                                    <TableCell>#{{ order.id }}</TableCell>
                                    <TableCell
                                        >{{ order.customer.name }}
                                    </TableCell>
                                    <TableCell>
                                        <Badge>{{ order.status.name }}</Badge>
                                    </TableCell>
                                    <TableCell
                                        >${{ formatNumber(order.total) }}
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>

                <!-- Top Customers -->
                <Card class="lg:col-span-3">
                    <CardHeader>
                        <CardTitle>Top Customers</CardTitle>
                        <CardDescription>By order count</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div
                                v-for="customer in topCustomers"
                                :key="customer.id"
                                class="flex items-center"
                            >
                                <Avatar class="h-9 w-9">
                                    <AvatarImage
                                        :src="`https://avatar.vercel.sh/${customer.name}.png`"
                                    />
                                    <AvatarFallback
                                        >{{ getInitials(customer.name) }}
                                    </AvatarFallback>
                                </Avatar>
                                <div class="ml-4 space-y-1">
                                    <p class="text-sm font-medium leading-none">
                                        {{ customer.name }}
                                    </p>
                                    <p class="text-sm text-muted-foreground">
                                        {{ customer.orders_count }} orders
                                    </p>
                                </div>
                                <div class="ml-auto font-medium">
                                    ${{
                                        formatNumber(customer.orders_sum_total)
                                    }}
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
} from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import {
    UsersIcon,
    PackageIcon,
    DollarSignIcon,
    ShoppingCartIcon,
} from 'lucide-vue-next';

const props = defineProps({
    metrics: Object,
    recentOrders: Array,
    ordersByStatus: Array,
    topCustomers: Array,
});

function formatNumber(number) {
    return new Intl.NumberFormat('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(number);
}

function getInitials(name) {
    return name
        .split(' ')
        .map((word) => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
}
</script>
