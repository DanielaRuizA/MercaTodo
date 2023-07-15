<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import { Link, useForm, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import DropdownButtonStrict from '@/Components/Buttons/DropdownButtonStrict.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    filters: Object,
    orders: Object,
    success: String,
});

const date1 = ref(props.filters.date1);
const date2 = ref(props.filters.date2);
const orderStatus = ref(props.filters.orderStatus);
const orderStatusLabel = ref('Estatus De Pedidos');
const minAmount = ref(props.filters.minAmount);
const maxAmount = ref(props.filters.maxAmount);

watch(date1, value => {
    getResults();
});

watch(date2, value => {
    getResults();
});

watch(orderStatus, value => {
    getResults();
});

watch(minAmount, value => {
    getResults();
});

watch(maxAmount, value => {
    getResults();
});

const selectOrderStatus = (status, btnLabel) => {
    orderStatus.value = status;
    orderStatusLabel.value = btnLabel;
}

const getResults = () => {
    router.get('/orders/report', {
        date1: date1.value,
        date2: date2.value,
        orderStatus: orderStatus.value,
        minAmount: minAmount.value,
        maxAmount: maxAmount.value,
    }, {
        preserveState: true,
        replace: true,
    });
}

const generateReport = () => {
    let time = Math.floor(new Date().getTime() / 1000);
    time = time.toString();

    router.post(route('orders.report.export'), {
        date1: date1.value,
        date2: date2.value,
        orderStatus: orderStatus.value,
        minAmount: minAmount.value,
        maxAmount: maxAmount.value,
        time: time,
    });
}

// const openDownloadDialog = () => {
//     let time = Math.floor(new Date().getTime() / 1000);
//     time = time.toString();

//     const url = route('orders.report.export', {
//         date1: date1.value,
//         date2: date2.value,
//         orderStatus: orderStatus.value,
//         minAmount: minAmount.value,
//         maxAmount: maxAmount.value,
//         time: time,
//     });

//     window.open(url, '_blank');
// }

// const generateReport = () => {
//     openDownloadDialog();
// }

</script>
<template>
    <AppLayout title="Reporte De Pedidos">

        <body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
            <section class="bg-white py-8">
                <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
                    <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                            <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-indigo-600 text-3xl "
                                href="#">
                                Reporte De Pedidos
                            </a>
                        </div>
                        <DropdownButtonStrict class="col-span-1 rounded-md border border-gray-300 p-1 col-span-1"
                            :btn-label="orderStatusLabel">
                            <DropdownLink @click="selectOrderStatus('COMPLETED', 'Pagado')">
                                Pagado
                            </DropdownLink>
                            <DropdownLink @click="selectOrderStatus('PENDING', 'Pendiente')">
                                Pendiente
                            </DropdownLink>
                            <DropdownLink @click="selectOrderStatus('CANCELED', 'Cancelado')">
                                Cancelado
                            </DropdownLink>
                        </DropdownButtonStrict>
                        <div class="rounded-md border border-gray-300 p-1 col-span-1">
                            <div class="flex gap-2">
                                <span class="text-base leading-4 text-black uppercase tracking-wider">Fecha inicio</span>
                                <input v-model="date1" type="date" placeholder="Fecha inicio"
                                    class="px-2 py-[10px] bg-transparent text-black border border-gray-400 rounded-md ">
                                <span class="text-base leading-4 text-black uppercase tracking-wider">Fecha final</span>
                                <input v-model="date2" type="date" placeholder="Fecha final"
                                    class="px-2 py-[10px] bg-transparent text-black border border-gray-400 rounded-md">
                            </div>
                        </div>
                        <div class="rounded-md border border-gray-300 p-1 col-span-1">
                            <InputLabel class=" leading-4 text-black uppercase tracking-wider">
                                Valor Del Pedido
                            </InputLabel>
                            <div class="flex gap-2 gap-2">
                                <input v-model="minAmount" type="number" placeholder="Valor Min."
                                    class="px-2 py-[10px] w-32 bg-transparent text-black  border border-gray-400 rounded-md">
                                <input v-model="maxAmount" type="number" placeholder="Valor Max."
                                    class="px-2 py-[10px] w-32 bg-transparent text-black border border-gray-400 rounded-md">
                                <button @click="generateReport()" class="col-span-1">
                                    Generar reporte de ordenes
                                </button>
                            </div>
                        </div>
                    </nav>
                    <table v-if="orders.length > 0" class="mt-4 min-w-full divide-y divide-gray-200 border">
                        <thead class="text-base font-semibold text-black-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">ID</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">Numero
                                        De Orden</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">Fecha De
                                        Compra</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">Fecha De
                                        Pago</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">Estado del
                                        Pedido</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">Total</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-base leading-4 text-black uppercase tracking-wider">
                                        Cliente Correo</span>
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
                                    {{ order.updated_at }}
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
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ Intl.NumberFormat('es-CO', {
                                        style: 'currency', currency: 'COP', maximumSignificantDigits: 3
                                    }).format(order.amount) }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ order.email }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div>
                    <pagination class="mt-6" :links="orders.links" />
                </div> -->
            </section>
        </body>
    </AppLayout>
</template>

