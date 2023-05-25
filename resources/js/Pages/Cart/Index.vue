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
        showImage() {
            return "/storage/";
        }
    },
    data() {
        return {

        }
    },
}
</script>
<template>
    <AppLayout title="Dashboard">

        <body class="bg-white text-gray-600 work-sans leading-normal text-base tracking-normal">
            <section class="bg-white py-8">
                <nav id="stores" class="w-full z-30 top-0 px-6 py-1">
                    <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">
                        <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl "
                            href="#">
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
                <h1 class="text-3xl font-bold mb-6">Your Cart Items</h1>
            </section>
            <div
                class="flex items-center justify-between border-b border-gray-200 px-4 py-3 text-gray-800 dark:border-gray-700 dark:text-gray-200 md:px-6">
                <h3 class="text-2xl sm:text-3xl">Cart</h3>
                <button class="hover:opacity-70" @click="$emit('close')">
                    <font-awesome-icon :icon="['fas', 'xmark']" size="xl" />
                </button>
            </div>
            <div
                class="max-h-[80vh] overflow-y-auto p-4 scrollbar-thin scrollbar-track-purple-300 scrollbar-thumb-purple-600 md:p-6">
                <div class="mb-4 flex flex-col justify-between space-y-4 sm:flex-row sm:space-y-0">
                    <secondary-button @click="$emit('close')">
                        <font-awesome-icon :icon="['fas', 'cart-plus']" class="mr-2" />
                        Continue shopping
                    </secondary-button>
                    <danger-button @click="bulkDelete">
                        <font-awesome-icon :icon="['fas', 'trash-can']" class="mr-2" />
                        Clear all
                    </danger-button>
                </div>
                <span v-if="good.old_price"
                    class="absolute left-0 top-0 bg-red-600 px-2 text-xs font-medium leading-6 text-gray-100">
                    {{ Number((good.price * 100) / good.old_price - 100).toFixed(0) }}%
                </span>
                <Link :href="route('goods.good.general', good.slug)"
                    class="mr-4 flex h-32 w-32 shrink-0 items-center justify-center">
                <img v-if="good.preview" :src="good.preview" :alt="good.title" :title="good.title"
                    class="h-full w-full rounded-lg object-cover object-center" loading="lazy" />
                </Link>
                <div class="grow">
                    <Link :href="route('goods.good.general', good.slug)" class="mb-2" :title="good.title">
                    <span class="text-sm text-gray-900 dark:text-gray-200">{{ good.title }}</span>
                    </Link>
                </div>
                <font-awesome-icon :icon="['fas', 'trash-can']"
                    class="cursor-pointer text-purple-900 hover:opacity-70 dark:text-purple-200"
                    @click.prevent="remove(good)" />
            </div>
            <div class="row flex flex-wrap justify-between py-4 md:justify-end md:py-0 md:pl-28">
                <div class="flex items-center">
                    <button :class="[
                        'mr-3',
                        items[itemId(good.id)].quantity > 1
                            ? 'cursor-pointer text-purple-600'
                            : 'cursor-not-allowed text-gray-300 dark:text-gray-500',
                    ]" :disabled="items[itemId(good.id)].quantity <= 1"
                        @click.prevent="update(good, items[itemId(good.id)].quantity - 1)">
                        <font-awesome-icon :icon="['fas', 'minus']" />
                    </button>
                    <input type="number"
                        class="w-14 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-center text-sm text-gray-900 focus:border-purple-500 focus:ring-purple-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-purple-500 dark:focus:ring-purple-500"
                        v-model="items[itemId(good.id)].quantity" @input="update(good, items[itemId(good.id)].quantity)" />
                    <font-awesome-icon :icon="['fas', 'plus']" class="ml-3 cursor-pointer text-purple-600"
                        @click.prevent="update(good, items[itemId(good.id)].quantity + 1)" />
                </div>
                <div class="ml-auto flex flex-col justify-center text-right md:ml-0 md:w-1/4">
                    <p v-if="good.old_price" class="text-sm leading-4 text-gray-400 line-through">
                        {{ formatMoney(good.old_price) }}
                    </p>
                    <p class="whitespace-nowrap text-xl font-medium text-red-600">
                        {{ formatMoney(good.price) }}
                    </p>
                </div>
            </div>
            <div class="sticky -bottom-4 flex flex-wrap items-center py-4 md:-mb-4">
                <div
                    class="flex w-full flex-col items-center rounded border border-slate-300 bg-purple-50 p-4 dark:border-slate-500 dark:bg-gray-700 md:ml-auto md:w-auto md:flex-row md:p-6">
                    <div class="mb-4 flex w-full flex-row items-center justify-between md:mb-0 md:mr-6 md:w-auto">
                        <p class="text-xl text-gray-900 dark:text-gray-200 md:hidden">Total</p>
                        <div class="ml-auto text-2xl text-gray-900 dark:text-gray-200 md:text-4xl">
                            <span>{{ formatMoney(total) }}</span>
                        </div>
                    </div>
                    <primary-button class="self-end" type="button" @click="router.get(route('checkout.index'))">
                        <font-awesome-icon :icon="['fas', 'credit-card']" class="mr-2" />
                        <span>Proceed to checkout</span>
                    </primary-button>
                </div>
            </div>
        </body>
    </AppLayout>
</template>




                
