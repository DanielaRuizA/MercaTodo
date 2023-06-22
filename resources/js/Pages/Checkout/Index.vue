<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    cartItems: Object,
    total: Object,
});

const form = useForm({
    total: props.total,
})

const processPayment = () => {
    form.post(route('payments.process'))
}

</script>
<template>
    <AppLayout title="Confirmación De Pedido">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">
            <div class="flex-1">
                <div class="flex flex-col items-center mb-2 md:flex-row md:justify-between">
                    <h1 class="flex-1 tex-center font-bold text-indigo-600 text-4xl ">Tu Pedido</h1>
                </div>
                <div class="flex justify-between border-b border-gray-200 py-2">
                    <div class="w-1/3 text-xl font-semibold">Producto</div>
                    <div class="flex justify-between w-1/2">
                        <span class="flex-1 tex-center text-xl font-semibold">Cantidad</span>
                        <span class="flex-1 text-right text-xl font-semibold">Precio</span>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between border-b border-gray-200 py-2" v-for="(item, index) in  cartItems "
                        :key="index">
                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden">
                            <div class="flex flex-1 flex-col justify-between uppercase">
                                <span>{{ item.name }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between w-1/2">
                            <div class="flex-1 tex-center">
                                {{ item.qty }}
                            </div>
                            <span class="flex-1 text-right">
                                {{ Intl.NumberFormat('es-CO', {
                                    style: 'currency', currency: 'COP',
                                    maximumSignificantDigits: 3
                                }).format(item.price) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <div class="shadow-md rounded sm:my-2">
                    <div class="bg-white px-4 py-6">
                        <div>
                            <span class="px-4 text-xl text-center font-semibold">Resumen De Pedido</span>
                            <div class="flex justify-between bg-white px-4 py-2 mt-4 text-lg">
                                <span class="font-semibold">Subtotal</span>
                                <span>{{ Intl.NumberFormat('es-CO', {
                                    style: 'currency', currency: 'COP',
                                    maximumSignificantDigits: 3
                                }).format(total) }}</span>
                            </div>
                            <div class="flex justify-between bg-white px-4 py-2 mt-4 text-lg">
                                <span class="font-semibold">Cantidad De Productos</span>
                                <span>{{ $page.props.cartCount }}</span>
                            </div>
                            <div class="flex justify-between px-4 mt-4 text-lg">
                                <span class="font-semibold">Envió</span>
                                <span>Gratis</span>
                            </div>
                            <div class="bg-white px-4 py-2 mt-4 text-lg">
                                <div class="flex justify-between">
                                    <span class="font-semibold"> Total Del Pedido</span>
                                    <span>{{ Intl.NumberFormat('es-CO', {
                                        style: 'currency', currency: 'COP',
                                        maximumSignificantDigits: 3
                                    }).format(total) }}</span>
                                </div>
                            </div>
                            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                                <button @click="processPayment" :disabled="processing" v-if="cartItems != 0"
                                    class="flex space-x-4 items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">
                                    <span class="text-white text-lg font-semibold"> TOTAL A PAGAR </span>
                                    <span class="text-white"> {{ Intl.NumberFormat('es-CO', {
                                        style: 'currency', currency: 'COP',
                                        maximumSignificantDigits: 3
                                    }).format(total) }} </span>
                                </button>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <Link :href="route('cart.index')"
                                class="underline text-base hover:text-indigo-700 font-semibold transition">
                            VOLVER AL
                            CARRITO
                            </Link>
                        </div>
                        <div class="text-center mt-4">
                            <Link :href="route('stores.index')"
                                class="underline text-base hover:text-indigo-700 font-semibold transition">CONTINUAR
                            COMPRANDO</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

