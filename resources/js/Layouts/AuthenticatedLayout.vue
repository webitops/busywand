<script setup>
import { Badge } from '@/components/ui/badge';

import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Input } from '@/components/ui/input';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import {
    Bell,
    Boxes,
    CircleFadingArrowUp,
    CircleUser,
    Home,
    Menu,
    Package,
    Package2,
    Search,
    ShoppingCart,
    TrendingUpDown,
    Users,
} from 'lucide-vue-next';
import { Icon } from '@iconify/vue';
import Link from '@/Components/Link.vue';

import { useColorMode } from '@vueuse/core';

// Pass { disableTransition: false } to enable transitions
const mode = useColorMode();
</script>

<template>
    <div
        class="grid min-h-screen w-full md:grid-cols-[220px_1fr] lg:grid-cols-[280px_1fr]"
    >
        <div class="hidden border-r bg-muted/40 md:block">
            <div class="flex h-full max-h-screen flex-col gap-2">
                <div
                    class="flex h-14 items-center border-b px-4 lg:h-[60px] lg:px-6"
                >
                    <a href="/" class="flex items-center gap-2 font-semibold">
                        <Package2 class="h-6 w-6" />
                        <span class="">Acme Inc</span>
                    </a>
                    <Button
                        variant="outline"
                        size="icon"
                        class="ml-auto h-8 w-8"
                    >
                        <Bell class="h-4 w-4" />
                        <span class="sr-only">Toggle notifications</span>
                    </Button>
                </div>
                <div class="flex-1">
                    <nav
                        class="grid items-start px-2 text-sm font-medium lg:px-4"
                    >
                        <Link
                            :href="route('dashboard')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                        >
                            <Home class="h-4 w-4" />
                            Dashboard
                        </Link>
                        <Link
                            :href="route('orders.index')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                        >
                            <ShoppingCart class="h-4 w-4" />
                            Orders
                            <Badge
                                class="ml-auto flex h-6 w-6 shrink-0 items-center justify-center rounded-full"
                            >
                                6
                            </Badge>
                        </Link>
                        <Link
                            :href="route('products.index')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                        >
                            <Package class="h-4 w-4" />
                            Products
                        </Link>
                        <Link
                            :href="route('categories.index')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                        >
                            <Boxes class="h-4 w-4" />
                            Categories
                        </Link>
                        <Link
                            :href="route('customers.index')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                        >
                            <Users class="h-4 w-4" />
                            Customers
                        </Link>
                        <Link
                            :href="route('customer_groups.index')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                        >
                            <TrendingUpDown class="h-4 w-4" />
                            Customer Groups
                        </Link>
                        <Link
                            :href="route('order-statuses.index')"
                            class="flex items-center gap-3 rounded-lg px-3 py-2 text-muted-foreground transition-all hover:text-primary"
                        >
                            <CircleFadingArrowUp class="h-4 w-4" />
                            Order Statuses
                        </Link>
                    </nav>
                </div>
                <div class="mt-auto p-4">
                    <Card>
                        <CardHeader class="p-2 pt-0 md:p-4">
                            <CardTitle>Upgrade to Pro</CardTitle>
                            <CardDescription>
                                Unlock all features and get unlimited access to
                                our support team.
                            </CardDescription>
                        </CardHeader>
                        <CardContent class="p-2 pt-0 md:p-4 md:pt-0">
                            <Button size="sm" class="w-full"> Upgrade</Button>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <header
                class="flex h-14 items-center gap-4 border-b bg-muted/40 px-4 lg:h-[60px] lg:px-6"
            >
                <Sheet>
                    <SheetTrigger as-child>
                        <Button
                            variant="outline"
                            size="icon"
                            class="shrink-0 md:hidden"
                        >
                            <Menu class="h-5 w-5" />
                            <span class="sr-only">Toggle navigation menu</span>
                        </Button>
                    </SheetTrigger>
                    <SheetContent side="left" class="flex flex-col">
                        <nav class="grid gap-2 text-lg font-medium">
                            <Link
                                :href="route('dashboard')"
                                class="flex items-center gap-2 text-lg font-semibold"
                            >
                                <Package2 class="h-6 w-6" />
                                <span class="sr-only">Acme Inc</span>
                            </Link>
                            <Link
                                :href="route('dashboard')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                            >
                                <Home class="h-5 w-5" />
                                Dashboard
                            </Link>
                            <Link
                                :href="route('orders.index')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl bg-muted px-3 py-2 text-foreground hover:text-foreground"
                            >
                                <ShoppingCart class="h-5 w-5" />
                                Orders
                                <Badge
                                    class="ml-auto flex h-6 w-6 shrink-0 items-center justify-center rounded-full"
                                >
                                    6
                                </Badge>
                            </Link>
                            <Link
                                :href="route('products.index')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                            >
                                <Package class="h-5 w-5" />
                                Products
                            </Link>
                            <Link
                                :href="route('categories.index')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                            >
                                <Boxes class="h-5 w-5" />
                                Categories
                            </Link>
                            <Link
                                :href="route('customers.index')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                            >
                                <Users class="h-5 w-5" />
                                Customers
                            </Link>
                            <Link
                                :href="route('customer_groups.index')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                            >
                                <TrendingUpDown class="h-5 w-5" />
                                Customer groups
                            </Link>
                            <Link
                                :href="route('order-statuses.index')"
                                class="mx-[-0.65rem] flex items-center gap-4 rounded-xl px-3 py-2 text-muted-foreground hover:text-foreground"
                            >
                                <CircleFadingArrowUp class="h-5 w-5" />
                                Order Statuses
                            </Link>
                        </nav>
                        <div class="mt-auto">
                            <Card>
                                <CardHeader>
                                    <CardTitle>Upgrade to Pro</CardTitle>
                                    <CardDescription>
                                        Unlock all features and get unlimited
                                        access to our support team.
                                    </CardDescription>
                                </CardHeader>
                                <CardContent>
                                    <Button size="sm" class="w-full">
                                        Upgrade
                                    </Button>
                                </CardContent>
                            </Card>
                        </div>
                    </SheetContent>
                </Sheet>
                <div class="w-full flex-1">
                    <form>
                        <div class="relative">
                            <Search
                                class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"
                            />
                            <Input
                                type="search"
                                placeholder="Search products..."
                                class="w-full appearance-none bg-background pl-8 shadow-none md:w-2/3 lg:w-1/3"
                            />
                        </div>
                    </form>
                </div>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline">
                            <Icon
                                icon="radix-icons:moon"
                                class="h-[1.2rem] w-[1.2rem] rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0"
                            />
                            <Icon
                                icon="radix-icons:sun"
                                class="absolute h-[1.2rem] w-[1.2rem] rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100"
                            />
                            <span class="sr-only">Toggle theme</span>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuItem @click="mode = 'light'">
                            Light
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="mode = 'dark'">
                            Dark
                        </DropdownMenuItem>
                        <DropdownMenuItem @click="mode = 'auto'">
                            System
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button
                            variant="secondary"
                            size="icon"
                            class="rounded-full"
                        >
                            <CircleUser class="h-5 w-5" />
                            <span class="sr-only">Toggle user menu</span>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuLabel>
                            <Link :href="route('profile.edit')">Profile</Link>
                        </DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem>Settings</DropdownMenuItem>
                        <DropdownMenuItem>Support</DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem>
                            <Link :href="route('logout')" method="post"
                                >Logout
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </header>
            <main class="flex flex-1 flex-col gap-4 p-4 lg:gap-6 lg:p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
