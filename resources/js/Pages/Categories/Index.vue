<template>
    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <header class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight">
                    Manage Categories
                </h1>
                <p class="mt-2 text-muted-foreground">
                    Create and manage product categories
                </p>
            </header>

            <!-- Create Category Form -->
            <Card class="mb-8">
                <CardHeader>
                    <CardTitle>Add New Category</CardTitle>
                    <CardDescription>
                        Create a new category for your products
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="createCategory" class="flex gap-4">
                        <div class="flex-1">
                            <Input
                                v-model="form.name"
                                type="text"
                                placeholder="Enter category name"
                                :disabled="form.processing"
                            />
                            <p
                                v-if="form.errors.name"
                                class="mt-2 text-sm text-destructive"
                            >
                                {{ form.errors.name }}
                            </p>
                        </div>
                        <Button type="submit" :disabled="form.processing">
                            <PlusIcon
                                v-if="!form.processing"
                                class="mr-2 h-4 w-4"
                            />
                            <Loader2Icon
                                v-else
                                class="mr-2 h-4 w-4 animate-spin"
                            />
                            {{ form.processing ? 'Adding...' : 'Add Category' }}
                        </Button>
                    </form>
                </CardContent>
            </Card>

            <!-- Categories List -->
            <Card>
                <CardHeader>
                    <CardTitle>Categories</CardTitle>
                    <CardDescription>
                        List of all available categories
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead class="w-[100px]">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="category in categories.data"
                                :key="category.id"
                            >
                                <TableCell>{{ category.name }}</TableCell>
                                <TableCell>
                                    <Button
                                        variant="destructive"
                                        size="sm"
                                        :disabled="deleteForm.processing"
                                        @click="deleteCategory(category.id)"
                                    >
                                        <Loader2Icon
                                            v-if="
                                                deleteForm.processing &&
                                                targetId === category.id
                                            "
                                            class="mr-2 h-4 w-4 animate-spin"
                                        />
                                        <TrashIcon
                                            v-else
                                            class="mr-2 h-4 w-4"
                                        />
                                        {{
                                            deleteForm.processing &&
                                            targetId === category.id
                                                ? 'Deleting...'
                                                : 'Delete'
                                        }}
                                    </Button>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="categories.data.length === 0">
                                <TableCell
                                    colspan="2"
                                    class="text-center text-muted-foreground"
                                >
                                    No categories found
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
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Loader2Icon, PlusIcon, TrashIcon } from 'lucide-vue-next';

defineProps({
    categories: {
        type: Object,
        required: tre,
    },
});

const targetId = ref(null);

const form = useForm({
    name: '',
});

const deleteForm = useForm({});

function createCategory() {
    form.post(route('categories.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
}

function deleteCategory(id) {
    targetId.value = id;
    deleteForm.delete(route('categories.destroy', id), {
        preserveScroll: true,
    });
}
</script>
