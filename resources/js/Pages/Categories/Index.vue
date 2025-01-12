<template>
    <AuthenticatedLayout>
        <h1 class="text-xl font-bold">Manage Categories</h1>
        <!-- Create Form -->
        <form @submit.prevent="createCategory">
            <input
                v-model="form.name"
                type="text"
                placeholder="Category name"
                class="border px-2 py-1"
            />
            <!-- Error Display -->
            <div v-if="form.errors.name" class="text-red-500">
                {{ form.errors.name }}
            </div>
            <br />
            <button
                type="submit"
                :disabled="form.processing"
                class="mt-2 bg-blue-500 px-3 py-1 text-white disabled:opacity-50"
            >
                {{ form.processing ? 'Adding...' : 'Add' }}
            </button>
        </form>
        <!-- Category List -->
        <ul class="mt-4">
            <li v-for="cat in categories.data" :key="cat.id">
                {{ cat.name }}
                <button
                    class="text-red-500"
                    :disabled="deleteForm.processing"
                    @click="deleteCategory(cat.id)"
                >
                    {{
                        deleteForm.processing && targetId === cat.id
                            ? 'Deleting...'
                            : 'Delete'
                    }}
                </button>
            </li>
        </ul>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    categories: {
        type: Array,
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
