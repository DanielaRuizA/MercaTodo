<script setup>
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';

</script>

<template>
    <div>

        <Head :title="title" />
        <div class="min-h-screen bg-white">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('register')"
                                    class="ml-4 font-semibold hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                    Register</NavLink>
                                <NavLink :href="route('login')" class="font-semibold hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm
                                focus:outline-red-500">
                                    Log in</NavLink>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
