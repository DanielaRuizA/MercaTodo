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
            const status = (product.status === 'Active') ? 'Inactive' : 'Active';
            axios.get('change/product/status', {
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
            Swal.fire({
                title: '¿Desea Eliminar?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.value) {
                    Inertia.delete(route('products.destroy', id)).then(() => {
                        Swal.fire(
                            'Eliminado',
                            'El producto ha sido eliminado exitosamente',
                            'success'
                        );
                    });
                }
            });
        };
        return { destroy };
        // const destroy = (id) => {
        //     if (confirm('¿Desea Eliminar?')) {
        //         Inertia.delete(route('products.destroy', id))
        //     }
        // }
        // return { destroy }
    },
    data() {
        return {
            search: ''
        }
    },
    watch: {
        search: function (value) {
            this.$inertia.replace(this.route('products.index', { search: value }))
        }
    }
}
</script>
<template>
    <AppLayout title="Lista De Productos">

        <body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
            <section class="bg-white py-8">
                <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
                    <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                            <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-2xl "
                                href="#">
                                Lista De Productos
                            </a>
                            <div class="flex items-center" id="store-nav-content">
                                <Link :href="route('products.create')"
                                    class="bg-blue-600 hover:bg-blue-700 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-mdpx-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">
                                Crear Producto
                                </Link>
                                <Link :href="route('products.export')"
                                    class="bg-blue-600 hover:bg-blue-700 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-mdpx-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">
                                Exportar
                                </Link>
                                <Link :href="route('products.show.imports')"
                                    class="bg-blue-600 hover:bg-blue-700 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-mdpx-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">
                                Importar
                                </Link>
                                <input type="text" class="pl-3 inline-block no-underline hover:text-black"
                                    placeholder="Buscar..." v-model="search">
                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                                </svg>
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
                                <th class="px-4 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Inhabilitado</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span
                                        class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Detalles</span>
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
                                <td class="p-16 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    {{ product.quantity }}
                                </td>
                                <td class="px-4 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer"
                                            :checked="product.status === 'Inactive'" @change="updateStatus(product)"
                                            :data-id="product.id">
                                        <div
                                            class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                        </div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                                    <Link :href="route('products.show', product.id)"
                                        class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Detalles
                                    </Link>
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
                <div>
                    <pagination class="mt-6" :links="products.links" />
                </div>
            </section>
        </body>
    </AppLayout>
</template>

