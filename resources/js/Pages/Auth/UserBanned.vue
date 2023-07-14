<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Usuario inhabilitado" />

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Este usuario se encuentra inhabilitado, comuniquese con los administradores.
    </div>
</template>


