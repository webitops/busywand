<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import Link from '@/Components/Link.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Separator } from '@/components/ui/separator';
import { Button } from '@/Components/ui/button/index.js';

const page = usePage();

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <div class="grid h-full place-items-center">
        <Card class="w-[350px]">
            <CardHeader>
                <CardTitle>Busywant is ready.</CardTitle>
                <CardDescription
                    >Proceed to the next step to manage your business.
                </CardDescription>
            </CardHeader>
            <CardContent>
                <div
                    v-if="!page.props.auth.user"
                    class="flex items-center justify-center gap-4"
                >
                    <Button>
                        <Link :href="route('login')">Login</Link>
                    </Button>
                    <Separator orientation="vertical" label="or" />
                    <Button variant="outline">
                        <Link :href="route('register')">Register</Link>
                    </Button>
                </div>
                <p v-if="page.props.auth.user">
                    Go to
                    <Link :href="route('dashboard')">Dashboard</Link>
                </p>
            </CardContent>
        </Card>
    </div>
</template>
