<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import Pagination from "@/Components/Pagination.vue"


export default {
    components: {
        AppLayout, Link, Pagination,
    },
    props: {
        products: Object,
    },
    methods: {
        showImage(image) {
            if (image.startsWith('http')) {
                return image;
            } else {
                return "/storage/" + image;
            }
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
    <AppLayout title="Mercatodo">

        <body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
            <section class="bg-white py-8">
                <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
                    <nav id="stores" class="w-full z-30 top-0 px-6 py-1">
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                            <a class="uppercase text-indigo-700 text-4xl font-bold tracking-wide no-underline" href="#">
                                Mercatodo
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
                    <div class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col" v-for="product in products.data"
                        :key="product.id">
                        <Link :href="route('stores.show', product.id)">
                        <img class="hover:grow hover:shadow-lg" :src="showImage(product.product_photo)" :alt="product.name"
                            width="450">
                        <div class="pt-3 flex items-center justify-between">
                            <p class="">{{ product.name }}</p>
                        </div>
                        <p class="pt-1 text-gray-900">{{ Intl.NumberFormat('es-CO', {
                            style: 'currency', currency: 'COP',
                            maximumSignificantDigits: 3
                        }).format(product.price) }}</p>
                        </Link>
                    </div>
                    <pagination class="mt-6" :links="products.links" />
                </div>
            </section>
        </body>
    </AppLayout>
</template>




                
