<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

export default {
    props: ['product'],
    components: {
        Link,
        AppLayout,
    },
    data() {
        return {
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
            }),
        }
    },
    mounted() {
        this.zoomImage()
    },
    methods: {
        submit() {
            this.$inertia.post(this.route('cart.store', this.product.id), this.form, {
                preserveScroll: true,
                onSuccess: () => {
                    Toast.fire({
                        icon: 'success',
                        title: `${this.form.name} se agrego al carrito`
                    })
                }
            })
        },
        showImage(image) {
            if (image.startsWith('http')) {
                return image;
            } else {
                return "/storage/" + image;
            }
        },
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
        <section class="overflow-hidden bg-white py-11 font-poppins">
            <div class="max-w-6xl px-4 py-4 mx-auto lg:py-8 md:px-6">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full mb-8 md:w-1/2 md:mb-0">
                        <div class="sticky top-0 z-50 overflow-hidden ">
                            <div class="flex flex-col flex-1 sm:border-r">
                                <div class="border-2 overflow-hidden cursor-zoom-in h-full">
                                    <div id="img-container" class="w-full h-full">
                                        <img id="current-img" :src="showImage(product.product_photo)" :alt="product.name"
                                            class="w-full h-full object-cover origin-center">
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 pb-6 mt-6 border-t border-gray-300 ">
                                <div class="flex flex-wrap items-center mt-6">
                                    <span class="mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="w-4 h-4 text-sky-500 bi bi-truck" viewBox="0 0 16 16">
                                            <path
                                                d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                                            </path>
                                        </svg>
                                    </span>
                                    <h2 class="text-lg font-bold text-sky-500">Envió Gratis</h2>
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
                                    <p class="max-w-md text-gray-800">
                                        {{ product.description }}
                                    </p>
                                </div>
                                <div class="w-32 mb-8 ">
                                    <label class="w-full pb-1 text-xl font-semibold text-gray-900 border-b border-grey-700"
                                        v-if="product.quantity >= 5">Cantidad</label>
                                    <template v-if="product.quantity <= 0">
                                        <div class="mt-4">
                                            <span class="text-2xl font-bold text-red-400 uppercase">
                                                Agotado
                                            </span>
                                        </div>
                                    </template>
                                    <template v-else-if="product.quantity <= 5">
                                        <div class="mt-4">
                                            <p class="mb-4 flex flex-wrap items-center text-xl text-sky-400 font-bold">
                                                Pocas Unidades Disponibles
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <label for="quantity" class="flex-1 text-xl capitalize text-gray-900">
                                                Cantidad:</label>
                                            <select class="flex-1 w-full border bg-white rounded px-1 py-2 outline-none"
                                                tabindex="1" v-model="form.quantity">
                                                <option :value="qty" :selected="qty === quantity"
                                                    v-for="( qty, index ) in  product.quantity " :key="index">{{ qty }}
                                                </option>
                                            </select>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex items-center">
                                            <select class="flex-1 w-full border bg-white rounded px-3 py-1 outline-none"
                                                tabindex="1" v-model="form.quantity">
                                                <option :value="qty" :selected="qty === quantity"
                                                    v-for="( qty, index ) in  product.quantity " :key="index">{{ qty }}
                                                </option>
                                            </select>
                                        </div>
                                    </template>
                                </div>
                                <div class="flex flex-wrap items-center gap-4">
                                    <button v-if="product.quantity > 0"
                                        class="inline-flex items-center px-8 py-3 rounded-md outline-none focus:outline-none ease-linear transition-all duration-15 text-gray-50 bg-sky-500 uppercase hover:bg-sky-700">
                                        <svg aria-hidden="true" class="w-5 h-5 mr-2 -ml-1" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                                            </path>
                                        </svg>
                                        Añadir Al Carrito </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template >
