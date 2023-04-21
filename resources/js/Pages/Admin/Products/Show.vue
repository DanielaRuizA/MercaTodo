<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';

    const props = defineProps({
        product: Object
    })
</script>

<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Producto
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">  
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <h3 class="text-lg text-gray-900">Detalle del Producto</h3>
                        <div class="shadow bg-white md:rounded-md p-4">
                            <p class="text-sm text-gray-600">{{ product.id }}</p>
                            <p>{{ product.name }}</p>
                            <p>{{ product.description }}</p>
                            <p>{{ product.product_status }}</p>
                            <p>{{ product.price }}</p>
                            <p>{{ product.quantity }}</p>
                            <hr class="my-6">
                            <Link :href="route('products.index')">
                                Volver
                            </Link>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </app-layout>
</template>


