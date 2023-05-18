<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Pagination from "@/Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";


export default {
    components: {
        AppLayout, Link, Pagination
    },
    props: {
        products: Object,
    },
    methods: {
        showImage() {
            return "/storage/";
        },
        updateStatus(product) {
            const status = product.status ? 0 : 1;
            axios.get('/changeProductStatus', {
                params: { status: status, product_id: product.id }
            }).then(response => {
                console.log(response.data.success);
                product.status = !product.status;
            }).catch(error => {
                console.error(error);
            });
        }
    },
    setup() {
        const destroy = (id) => {
            if (confirm('¿Desea Eliminar?')) {
                Inertia.delete(route('products.destroy', id))
            }
        }
        return { destroy }
    },
    data() {
        return {
            q: ''
        }
    },
    watch: {
        q: function (value) {
            this.$inertia.replace(this.route('products.index', { q: value }))
        }
    }
}
</script>
<template>
    <AppLayout title="Dashboard">

        <body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
            <section class="bg-white py-8">
                <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
                    <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                            <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                                href="#">
                                Lista De Productos
                            </a>
                            <div class="flex items-center" id="store-nav-content">
                                <input type="text" class="pl-3 inline-block no-underline hover:text-black"
                                    placeholder="Buscar..." v-model="q">
                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                                </svg>
                                <Link :href="route('products.create')"
                                    class="bg-blue-500 text-white font-bold py-2 px-4 rounded-md">
                                Crear
                                </Link>
                            </div>
                        </div>
                    </nav>
                    <table class="mt-4 min-w-full divide-y divide-gray-200 border">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ID</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Nombre</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">imagen</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Precio
                                        Unitario</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Cantidad
                                        de
                                        Productos</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">ver</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Editar</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Eliminar</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                            <tr v-for="product in products.data" :key="product.id">
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ product.id }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ product.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <img :src="showImage() + product.product_photo" :alt="product.name" width="100">
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ Intl.NumberFormat('es-CO', {
                                        style: 'currency', currency: 'COP', maximumSignificantDigits: 3
                                    }).format(product.price) }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ product.quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer" :checked="product.status"
                                            @change="updateStatus(product)" :data-id="product.id">
                                        <div
                                            class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                        </div>
                                        <span
                                            class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Inhabilitado</span>
                                    </label>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <Link :href="route('products.show', product.id)"
                                        class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Ver</Link>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <Link :href="route('products.edit', product.id)"
                                        class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Editar
                                    </Link>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <button @click="destroy(product.id)" type="button"
                                        class="px-2 py-1 bg-red-600 text-white rounded font-bold uppercase">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" v-for="product in products.data"
                        :key="product.id">
                        <img class="hover:grow hover:shadow-lg" :src="showImage() + product.product_photo"
                            :alt="product.name" width="450">
                        <div class="pt-3 flex items-center justify-between">
                            <p class="">{{ product.name }}</p>
                        </div>
                        <p class="pt-1 text-gray-900">{{ Intl.NumberFormat('es-CO', {
                            style: 'currency', currency: 'COP',
                            maximumSignificantDigits: 3
                        }).format(product.price) }}</p>
                    </div>
                    <pagination class="mt-6" :links="products.links" />
                </div> -->
                <div>
                    <pagination class="mt-6" :links="products.links" />
                </div>
            </section>
        </body>
    </AppLayout>
</template>



v-for="product in products" :key="product.id"
vs
v-for="product in products.data"
                        :key="product.id"
