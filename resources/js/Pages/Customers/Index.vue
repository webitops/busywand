<template>
    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <header class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">Customers</h1>
                    <p class="mt-2 text-muted-foreground">
                        Manage your customer list and groups
                    </p>
                </div>
                <Button variant="default" :href="route('customers.create')">
                    <UserPlusIcon class="mr-2 h-4 w-4" />
                    Add Customer
                </Button>
            </header>

            <Card>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Customer Groups</TableHead>
                            <TableHead class="w-[100px]">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="customer in customers.data"
                            :key="customer.id"
                        >
                            <TableCell>
                                <div class="flex items-center">
                                    <Avatar class="mr-4 h-8 w-8">
                                        <AvatarImage
                                            :src="`https://avatar.vercel.sh/${customer.name}.png`"
                                            :alt="customer.name"
                                        />
                                        <AvatarFallback>
                                            {{ getInitials(customer.name) }}
                                        </AvatarFallback>
                                    </Avatar>
                                    <div>
                                        <p class="font-medium">
                                            {{ customer.name }}
                                        </p>
                                    </div>
                                </div>
                            </TableCell>
                            <TableCell>
                                <div class="flex flex-wrap gap-1">
                                    <Badge
                                        v-for="group in customer.customer_groups"
                                        :key="group.id"
                                        variant="secondary"
                                    >
                                        {{ group.name }}
                                    </Badge>
                                    <Badge
                                        v-if="
                                            customer.customer_groups.length ===
                                            0
                                        "
                                        variant="outline"
                                    >
                                        No groups
                                    </Badge>
                                </div>
                            </TableCell>
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
                                        <DropdownMenuItem
                                            :href="
                                                route(
                                                    'customers.edit',
                                                    customer.id,
                                                )
                                            "
                                        >
                                            <PencilIcon class="mr-2 h-4 w-4" />
                                            Edit
                                        </DropdownMenuItem>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuItem
                                            :href="
                                                route(
                                                    'customers.destroy',
                                                    customer.id,
                                                )
                                            "
                                            method="delete"
                                            class="text-destructive"
                                        >
                                            <TrashIcon class="mr-2 h-4 w-4" />
                                            Delete
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                        <TableRow v-if="customers.data.length === 0">
                            <TableCell
                                colspan="3"
                                class="text-center text-muted-foreground"
                            >
                                No customers found
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
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    MoreHorizontalIcon,
    PencilIcon,
    TrashIcon,
    UserPlusIcon,
} from 'lucide-vue-next';

defineProps({
    customers: Object,
});

function getInitials(name) {
    return name
        .split(' ')
        .map((word) => word[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
}
</script>
