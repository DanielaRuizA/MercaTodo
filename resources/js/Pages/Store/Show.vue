<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';


export default {
    components: {
        AppLayout, Link
    },
    props: {
        product: Object,
    },
    data() {
        return {
            currentImg: this.product.main_image,
            isActive: 0,
            selected: false,
            openDescription: false,
            openFeatures: false,
            openReturn: false,
            openReviews: false,
            quantity: 1,
            form: this.$inertia.form({
                id: this.product.id,
                name: this.product.name,
                description: this.product.description,
                price: this.product.price,
                photo: this.product.product_photo,
                quantity: 1,
                totalQty: this.product.quantity,
            }),
            slides: this.product.alt_images,
            settings: {
                itemsToShow: 1,
                snapAlign: 'center',
            },
            // breakpoints are mobile first
            // any settings not specified will fallback to the carousel settings
            breakpoints: {
                // 700px and up
                700: {
                    itemsToShow: 3.5,
                    snapAlign: 'center',
                },
                // 1024 and up
                1024: {
                    itemsToShow: 5,
                    snapAlign: 'start',
                },
            },
        }
    },
    methods: {
        showImage() {
            return "/storage/";
        },
        submit() {
            this.form.post(this.route('cart.store', this.form), {
                preserveScroll: true,
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: `${this.form.name} has successfully been added to your cart!`
                    })
                }
            })
        },
    }
}
</script>
<template>
    <AppLayout :title="product.name">
        <section class="overflow-hidden bg-white py-11 font-poppins">
            <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full mb-8 md:w-1/2 md:mb-0">
                        <div class="sticky top-0 z-50 overflow-hidden ">
                            <div class="relative mb-6 lg:mb-10 lg:h-2/4 ">
                                <img class="hover:grow hover:shadow-lg" :src="showImage() + product.product_photo"
                                    :alt="product.name" width="450">
                            </div>
                            <div class="px-6 pb-6 mt-6 border-t border-gray-300 dark:border-gray-400 ">
                                <div class="flex flex-wrap items-center mt-6">
                                    <span class="mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="w-4 h-4 text-gray-700 dark:text-gray-400 bi bi-truck"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                                            </path>
                                        </svg>
                                    </span>
                                    <h2 class="text-lg font-bold text-gray-700 dark:text-gray-400">Free Shipping</h2>
                                </div>
                                <div class="mt-2 px-7">
                                    <a class="text-sm text-blue-400 dark:text-blue-200" href="#">Get delivery dates</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-4 md:w-1/2 ">
                        <form @submit.prevent="submit">
                            <div class="lg:pl-20">
                                <div class="mb-8 ">
                                    <h2 class="max-w-xl mb-6 text-2xl font-bold md:text-4xl uppercase">
                                        {{ product.name }}</h2>
                                    <p class="inline-block mb-6 text-4xl font-bold text-gray-700 ">
                                        <span>{{ Intl.NumberFormat('es-CO', {
                                            style: 'currency', currency: 'COP',
                                            maximumSignificantDigits: 3
                                        }).format(product.price) }}</span>
                                    </p>
                                    <p class="max-w-md text-gray-700 dark:text-gray-400">
                                        {{ product.description }}
                                    </p>
                                </div>
                                <div class="w-32 mb-8 ">
                                    <label for=""
                                        class="w-full pb-1 text-xl font-semibold text-gray-700 border-b border-blue-300 dark:border-gray-600 dark:text-gray-400">Quantity</label>
                                    <div class="relative flex flex-row w-full h-10 mt-6 bg-transparent rounded-lg">
                                        <button
                                            class="w-20 h-full text-gray-600 bg-gray-300 rounded-l outline-none cursor-pointer dark:hover:bg-gray-700 dark:text-gray-400 hover:text-gray-700 dark:bg-gray-900 hover:bg-gray-400">
                                            <span class="m-auto text-2xl font-thin">-</span>
                                        </button>
                                        <input type="number"
                                            class="flex items-center w-full font-semibold text-center text-gray-700 placeholder-gray-700 bg-gray-300 outline-none dark:text-gray-400 dark:placeholder-gray-400 dark:bg-gray-900 focus:outline-none text-md hover:text-black"
                                            placeholder="1">
                                        <button
                                            class="w-20 h-full text-gray-600 bg-gray-300 rounded-r outline-none cursor-pointer dark:hover:bg-gray-700 dark:text-gray-400 dark:bg-gray-900 hover:text-gray-700 hover:bg-gray-400">
                                            <span class="m-auto text-2xl font-thin">+</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <template v-if="product.quantity <= 0">
                                        <div class="mt-4">
                                            <span class="text-2xl font-bold text-red-400">
                                                Agotado
                                            </span>
                                        </div>
                                    </template>
                                    <template v-else-if="product.quantity <= 5">
                                        <div class="mt-4">
                                            <span class="text-xl  text-sky-400 font-bold">
                                                Pocas Unidades Disponibles
                                            </span>
                                        </div>
                                        <div class="flex items-center">
                                            <label for="quantity" class="flex-1 text-xl capitalize"> Cantidad:</label>
                                            <select class="flex-1 w-full border bg-white rounded px-3 py-1 outline-none"
                                                tabindex="1" v-model="form.quantity">
                                                <option :value="qty" :selected="qty === quantity"
                                                    v-for="(qty, index) in product.quantity" :key="index">{{ qty }}</option>
                                            </select>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex items-center">
                                            <label for="quantity" class="flex-1 text-xl capitalize">Qty:</label>
                                            <select class="flex-1 w-full border bg-white rounded px-3 py-1 outline-none"
                                                tabindex="1" v-model="form.quantity">
                                                <option :value="qty" :selected="qty === quantity"
                                                    v-for="(qty, index) in product.quantity" :key="index">{{ qty }}</option>
                                            </select>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex flex-wrap items-center gap-4">
                                    <button v-if="product.quantity > 0"
                                        class="w-full p-4 bg-blue-500 rounded-md lg:w-2/5 dark:text-gray-200 text-gray-50  uppercase hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-700">
                                        Añadir a mi bolsa </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
