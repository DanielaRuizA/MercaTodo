<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

export default {
    props: ['product'],
    components: {
        Link,
        AppLayout,
    },
    methods: {
        showImage() {
            return "/storage/";
        }
    },
    data() {
        return {
            // currentImg: this.product.main_image,
            // isActive: 0,
            // selected: false,
            // openDescription: false,
            // openFeatures: false,
            // openReturn: false,
            // openReviews: false,
            quantity: 1,
            form: useForm({
                id: this.product.id,
                name: this.product.name,
                slug: this.product.slug,
                description: this.product.description,
                image: this.product.product_photo,
                price: this.product.price,
                quantity: 1,
                totalQty: this.product.quantity,
                // _method: 'put'
            }),
        }
    },
    mounted() {
        this.zoomImage()
    },
    methods: {
        submit() {
            this.$inertia.post(this.route('cart.store', this.product.id), this.form), {
                preserveScroll: true,
                onSuccess: () => {
                }
            }
        },
        showImage() {
            return "/storage/";
        },
        // changeCurrentImage(image, index) {
        //     if (image) {
        //         this.currentImg = image
        //         this.isActive = index
        //         this.selected = false
        //     } else {
        //         this.currentImg = this.product.main_image
        //         if (this.isActive = index) {
        //             this.selected = false
        //         } else {
        //             this.selected = true
        //         }
        //     }
        // },
        zoomImage() {
            let container = document.querySelector('#img-container')
            let img = document.querySelector('#current-img')
            container.addEventListener("mousemove", (e) => {
                let x = e.clientX - e.target.offsetLeft
                let y = e.clientY - e.target.offsetTop
                img.style.transformOrigin = `${x}px ${y}px`
                img.style.transform = "scale(3)"
            })
            container.addEventListener("mouseleave", () => {
                img.style.transformOrigin = "center"
                img.style.transform = "scale(1)"
            })
        }
    }
}
</script >

<template>
    <AppLayout :title="product.name">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:flex sm:space-x-4 sm:px-6 lg:px-8">
            <div class="flex flex-col flex-1 sm:border-r">
                <div class="border-2 overflow-hidden cursor-zoom-in h-full">
                    <div id="img-container" class="w-full h-full">
                        <img id="current-img" :src="showImage() + product.product_photo" :alt="product.name"
                            class="w-full h-full object-cover origin-center">
                    </div>
                </div>
            </div>
            <div class="flex-1 space-y-6 my-4 sm:mt-0 sm:border-l sm:pl-4">
                <form @submit.prevent="submit">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold capitalize italic">{{ product.name }}</h2>
                        <div class="text-xl capitalize italic">
                            <span>
                                Price:
                            </span>
                            <span>
                                {{ product.price }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <template v-if="product.quantity <= 0">
                            <div class="mt-4">
                                <span class="text-2xl text-red-600 font-semibold italic uppercase">
                                    Sold Out
                                </span>
                            </div>
                        </template>
                        <template v-else-if="product.quantity <= 5">
                            <div class="mt-4">
                                <span class="text-2xl text-yellow-600 font-semibold italic uppercase">
                                    Only a few left
                                </span>
                            </div>
                            <div class="flex items-center">
                                <label for="quantity" class="flex-1 text-xl capitalize">Qty:</label>
                                <select class="flex-1 w-full border bg-white rounded px-3 py-1 outline-none" tabindex="1"
                                    v-model="form.quantity">
                                    <option :value="qty" :selected="qty === quantity"
                                        v-for="(qty, index) in product.quantity" :key="index">{{ qty }}</option>
                                </select>
                            </div>
                        </template>
                        <template v-else>
                            <div class="flex items-center">
                                <label for="quantity" class="flex-1 text-xl capitalize">Qty:</label>
                                <select class="flex-1 w-full border bg-white rounded px-3 py-1 outline-none" tabindex="1"
                                    v-model="form.quantity">
                                    <option :value="qty" :selected="qty === quantity"
                                        v-for="(qty, index) in product.quantity" :key="index">{{ qty }}</option>
                                </select>
                            </div>
                        </template>
                    </div>
                    <div class="text-center mt-4" v-if="product.quantity > 0">
                        <button as="submit" class="text-sm">
                            <span>Add to Cart</span>
                        </button>
                    </div>
                </form>
                <div class="flex flex-col divide-y">
                    <div>
                        <button type="button"
                            class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8"
                            @click.prevent="openDescription = !openDescription">
                            <span>Product Description</span>
                            <svg name="angle-down" v-if="openDescription" aria-hidden="true" data-prefix="fas"
                                data-icon="angle-down" class="w-5 h-5 text-yellow-500 fill-current"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path
                                    d="M143 352.3 7 216.3a23.9 23.9 0 0 1 0-33.9l22.6-22.6a23.9 23.9 0 0 1 33.9 0l96.4 96.4 96.4-96.4a23.9 23.9 0 0 1 33.9 0l22.6 22.6a23.9 23.9 0 0 1 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z" />
                            </svg>
                            <svg name="angle-left" v-else aria-hidden="true" data-prefix="fas" data-icon="angle-left"
                                class="w-5 h-5 text-yellow-500 fill-current" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 256 512">
                                <path
                                    d="m31.7 239 136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z" />
                            </svg>
                        </button>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 lg:px-8" v-if="openDescription">
                            <p>
                                {{ product.description }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <button type="button"
                            class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8"
                            @click.prevent="openFeatures = !openFeatures">
                            <span>Product Features</span>
                            <svg name="angle-down" v-if="openFeatures" aria-hidden="true" data-prefix="fas"
                                data-icon="angle-down" class="w-5 h-5 text-yellow-500 fill-current"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path
                                    d="M143 352.3 7 216.3a23.9 23.9 0 0 1 0-33.9l22.6-22.6a23.9 23.9 0 0 1 33.9 0l96.4 96.4 96.4-96.4a23.9 23.9 0 0 1 33.9 0l22.6 22.6a23.9 23.9 0 0 1 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z" />
                            </svg>
                            <svg name="angle-left" v-else aria-hidden="true" data-prefix="fas" data-icon="angle-left"
                                class="w-5 h-5 text-yellow-500 fill-current" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 256 512">
                                <path
                                    d="m31.7 239 136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z" />
                            </svg>
                        </button>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 lg:px-8" v-if="openFeatures">
                            <p>
                                {{ product.description }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <button type="button"
                            class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8"
                            @click.prevent="openReturn = !openReturn">
                            <span>Return Policy</span>
                            <svg name="angle-down" v-if="openReturn" aria-hidden="true" data-prefix="fas"
                                data-icon="angle-down" class="w-5 h-5 text-yellow-500 fill-current"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path
                                    d="M143 352.3 7 216.3a23.9 23.9 0 0 1 0-33.9l22.6-22.6a23.9 23.9 0 0 1 33.9 0l96.4 96.4 96.4-96.4a23.9 23.9 0 0 1 33.9 0l22.6 22.6a23.9 23.9 0 0 1 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z" />
                            </svg>
                            <svg name="angle-left" v-else aria-hidden="true" data-prefix="fas" data-icon="angle-left"
                                class="w-5 h-5 text-yellow-500 fill-current" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 256 512">
                                <path
                                    d="m31.7 239 136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z" />
                            </svg>
                        </button>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 lg:px-8" v-if="openReturn">
                            <p>
                                Don't worry about returns, we'll send you a new one!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template >






























// export default {
//     components: {
//         AppLayout, Link
//     },
//     props: {
//         product: Object,
//     },
//     data() {
//         return {
            // currentImg: this.product.main_image,
            // isActive: 0,
            // selected: false,
            // openDescription: false,
            // openFeatures: false,
            // openReturn: false,
            // openReviews: false,
            // quantity: 1,
            // form: useForm({
            //     id: this.product.id,
            //     name: this.product.name,
            //     description: this.product.description,
            //     price: this.product.price,
            //     photo: this.product.product_photo,
            //     quantity: 1,
            //     //_method: 'put'
            //     // totalQty: this.product.quantity,
            // }),
            // slides: this.product.alt_images,
            // settings: {
            //     itemsToShow: 1,
            //     snapAlign: 'center',
            // },
            // breakpoints are mobile first
            // any settings not specified will fallback to the carousel settings
            // breakpoints: {
            //     // 700px and up
            //     700: {
            //         itemsToShow: 3.5,
            //         snapAlign: 'center',
            //     },
            //     // 1024 and up
            //     1024: {
            //         itemsToShow: 5,
            //         snapAlign: 'start',
            //     },
            // },
//         }
//     },
//     methods: {
//         showImage() {
//             return "/storage/";
//         },
//         submit() {
//             this.$inertia.post(this.route('cart.store', this.product.id), this.form), {
//                 preserveScroll: true,
//                 onSuccess: () => {
//                 }
//             }
//         }
//     }
// }
 <!-- </script>
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
</template>  -->
