<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm, router } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout, Link,
    },
    props: {
        orders: Object,
    },
    data() {
        return {
            form: useForm({
                id: '',
            })
        }
    },
    methods: {
        retryPayment(id) {
            router.post(route('payments.retry', id), {
                _method: 'patch',
                id: id,
            });
        },
    }
}
</script>
<template>
    <AppLayout title="Pedidos">

        <body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
            <section class="bg-white py-8">
                <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
                    <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                            <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-indigo-600 text-3xl "
                                href="#">
                                Mis Pedidos
                            </a>
                        </div>
                    </nav>
                    <table class="mt-4 min-w-full divide-y divide-gray-200 border">
                        <thead class="text-base font-semibold text-black-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">ID</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">Numero
                                        de orden</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">Fecha</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">Precio</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">Status
                                        La Orden</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">url</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            <tr v-for="order in orders" :key="order.id">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ order.id }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ order.order_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ order.created_at }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ Intl.NumberFormat('es-CO', {
                                        style: 'currency', currency: 'COP', maximumSignificantDigits: 3
                                    }).format(order.amount) }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <div v-if="order.status == 'CANCELED'"
                                        class="rounded-md px-4 py-2 bg-red-500 text-center font-semibold uppercase text-white">
                                        cancelado
                                    </div>
                                    <div v-if="order.status == 'COMPLETED'"
                                        class="rounded-md px-4 py-2 bg-lime-400 text-center font-semibold uppercase text-white">
                                        pagado
                                    </div>
                                    <div v-if="order.status == 'PENDING'"
                                        class="rounded-md px-4 py-2 bg-orange-400 text-center font-semibold uppercase text-white">
                                        pendiente
                                    </div>
                                </td>
                                <td v-if="order.status == 'PENDING' || order.status === 'CANCELED'">
                                    <button
                                        class="rounded-md px-4 py-2 bg-sky-400 text-center font-semibold text-white uppercase"
                                        @click="retryPayment(order.id)">reintentar
                                        pago</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </body>
    </AppLayout>
</template>

