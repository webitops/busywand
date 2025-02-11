<template>
    <AuthenticatedLayout>
        <div class="container mx-auto py-6">
            <header class="mb-6">
                <h1 class="text-3xl font-bold tracking-tight">Order Flow</h1>
                <p class="mt-2 text-muted-foreground">
                    View and manage order status transitions
                </p>
            </header>

            <Card>
                <CardHeader>
                    <CardTitle>Status Workflow</CardTitle>
                    <CardDescription>
                        Each status and its allowed next steps in the order
                        process
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="space-y-4">
                        <div
                            v-for="status in statuses"
                            :key="status.id"
                            class="rounded-lg border p-4"
                        >
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <CircleIcon class="h-3 w-3 text-primary" />
                                    <h3 class="font-semibold">
                                        {{ status.name }}
                                    </h3>
                                </div>
                                <Button variant="ghost" size="sm">
                                    <Settings2Icon class="h-4 w-4" />
                                </Button>
                            </div>

                            <div class="mt-4">
                                <div
                                    v-if="
                                        status.allowed_next_statuses.length > 0
                                    "
                                >
                                    <p
                                        class="mb-2 text-sm text-muted-foreground"
                                    >
                                        Can transition to:
                                    </p>
                                    <div class="flex flex-wrap gap-2">
                                        <Badge
                                            v-for="nextStatus in status.allowed_next_statuses"
                                            :key="nextStatus.id"
                                            variant="secondary"
                                        >
                                            <ArrowRightIcon
                                                class="mr-1 h-3 w-3"
                                            />
                                            {{ nextStatus.name }}
                                        </Badge>
                                    </div>
                                </div>
                                <p v-else class="text-sm text-muted-foreground">
                                    Final status - no further transitions
                                    allowed
                                </p>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-if="!statuses.length" class="py-12 text-center">
                            <GitBranchIcon
                                class="mx-auto h-12 w-12 text-muted-foreground/50"
                            />
                            <h3 class="mt-4 text-lg font-semibold">
                                No Status Workflows
                            </h3>
                            <p class="text-muted-foreground">
                                No order statuses have been configured yet
                            </p>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    ArrowRightIcon,
    CircleIcon,
    GitBranchIcon,
    Settings2Icon,
} from 'lucide-vue-next';

defineProps({
    statuses: {
        type: Array,
        required: true,
    },
});
</script>
