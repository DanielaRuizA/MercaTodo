<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router} from '@inertiajs/vue3';


export default {
    components: {
        AppLayout, Link
    },
    props: {
        products: Object,
    }, 
}
</script>

<template>
    <app-layout>
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-6 py-3">
            <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
            <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                    <Link class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                        Store
                    </Link>
                    <link v-for="Link in products.Links" :href="route('stores')" v-html="Link.label">
                    <div class="flex items-center" id="store-nav-content">
                    <Link class="pl-3 inline-block no-underline hover:text-black" href="#">
                    <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M7 11H17V13H7zM4 7H20V9H4zM10 15H14V17H10z" />
                    </svg>
                </Link>

                <Link class="pl-3 inline-block no-underline hover:text-black" href="#">
                    <svg class="fill-current hover:text-black" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M10,18c1.846,0,3.543-0.635,4.897-1.688l4.396,4.396l1.414-1.414l-4.396-4.396C17.365,13.543,18,11.846,18,10 c0-4.411-3.589-8-8-8s-8,3.589-8,8S5.589,18,10,18z M10,4c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S6.691,4,10,4z" />
                    </svg>
                </Link>

                    </div>
            </div>
            </nav>
            </div>
            <div v-for="product in products.data" :key="product.id" class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col">
                <a href="#">
                    <img class="hover:grow hover:shadow-lg" :src="product.product_photo">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">{{ product.name }}</p>
                    </div>
                    <p class="pt-1 text-gray-900">{{ product.price }}</p>
                </a>
            </div>


<!-- <div class="container" id="app">
            <div class="row">
                <div v-for="item in items" class="col-span-3 col-6 my-1">
                    <div class="card h-100">
                        <img :src="item.img" class="card-img-top">
                        <div class="card-body">
                            <div class="card-title">{{ item.name }}</div>
                            <div>
                                <span class="badge badge-pill badge-info">${{ item.price }}</span>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            </div> -->
            <Pagination class="mt-6" :links="products.Links" />
            <div>
                <!-- <link v-for="Link in products.Links" :href="Link.url" v-html="Link.label"> -->
            </div>
        </div>
    </app-layout>
</template>