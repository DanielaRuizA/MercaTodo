<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Paginator from "@/Components/Paginator.vue"
import Pagination from "@/Components/Pagination.vue"


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
        }
    },
    data() {
        return {
            q: ''
        }
    },
    watch: {
        q: function (value) {
            this.$inertia.replace(this.route('stores.index', { q: value }))
        }
    }
}
</script>
<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Store
            </h2>
        </template>
        <!-- <pre>{{ products }}</pre> -->
        <body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
            <section class="bg-white py-8">
                <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
                    <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                            <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                                href="#">
                                Store
                            </a>
                            <div class="flex items-center" id="store-nav-content">
                                <input type="text" class="pl-3 inline-block no-underline hover:text-black"
                                    placeholder="Buscar..." v-model="q">
                                <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                                </svg>
                            </div>
                        </div>
                    </nav>
                    <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" v-for="product in products.data" :key="product.id">
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
                </div>
            </section>
        </body>
    </AppLayout>
</template>




