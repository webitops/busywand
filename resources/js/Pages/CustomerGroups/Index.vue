<template>
    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <header class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">
                        Customer Groups
                    </h1>
                    <p class="mt-2 text-muted-foreground">
                        Manage customer segments and categories
                    </p>
                </div>
                <Button
                    variant="default"
                    :href="route('customer_groups.create')"
                >
                    <FolderPlusIcon class="mr-2 h-4 w-4" />
                    New Group
                </Button>
            </header>

            <Card>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Group Name</TableHead>
                            <TableHead>Customers</TableHead>
                            <TableHead class="w-[100px]">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="group in groups.data" :key="group.id">
                            <TableCell>
                                <div class="flex items-center gap-2">
                                    <UsersIcon
                                        class="h-4 w-4 text-muted-foreground"
                                    />
                                    <span class="font-medium">{{
                                        group.name
                                    }}</span>
                                </div>
                            </TableCell>
                            <TableCell>
                                <Badge variant="secondary">
                                    {{ group.customers_count }}
                                    {{
                                        group.customers_count === 1
                                            ? 'customer'
                                            : 'customers'
                                    }}
                                </Badge>
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
                                                    'customer_groups.edit',
                                                    group.id,
                                                )
                                            "
                                        >
                                            <PencilIcon class="mr-2 h-4 w-4" />
                                            Edit
                                        </DropdownMenuItem>
                                        <DropdownMenuItem
                                            :href="
                                                route(
                                                    'customer_groups.show',
                                                    group.id,
                                                )
                                            "
                                        >
                                            <UsersIcon class="mr-2 h-4 w-4" />
                                            View Members
                                        </DropdownMenuItem>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuItem
                                            :href="
                                                route(
                                                    'customer_groups.destroy',
                                                    group.id,
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
                        <TableRow v-if="groups.data.length === 0">
                            <TableCell
                                colspan="3"
                                class="text-center text-muted-foreground"
                            >
                                <div class="flex flex-col items-center py-6">
                                    <UsersIcon
                                        class="mb-3 h-12 w-12 text-muted-foreground/50"
                                    />
                                    <p>No customer groups found</p>
                                    <Button
                                        variant="link"
                                        :href="route('customer_groups.create')"
                                        class="mt-2"
                                    >
                                        Create your first group
                                    </Button>
                                </div>
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
    FolderPlusIcon,
    MoreHorizontalIcon,
    PencilIcon,
    TrashIcon,
    UsersIcon,
} from 'lucide-vue-next';

defineProps({
    groups: {
        type: Object,
        required: true,
    },
});
</script>
