<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    total: Object,
});

const form = useForm({
    total: props.total,
})

const processPayment = () => {
    form.post(route('payments.processPayment'))
}

</script>
<template>
    <AppLayout title="Checkout">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">
            <div class="flex-1">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                    <div class="flex flex-col items-center space-y-4 py-6 bg-gray-700">
                        <div class="flex space-x-4">
                            <span class="text-white">
                                Total a Pagar
                            </span>
                            <span class="text-yellow-500">{{ total }}</span>
                        </div>
                    </div>
                    <!-- <div class="-mx-3 md:flex mb-6">
                            <div class="px-3 mb-6 w-full md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="name">
                                    Name
                                </label>
                                <input type="text"
                                    class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4"
                                    id="name" autofocus required v-model="form.name">
                                <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.name">
                                    {{ errors.name[0] }}
                                </span>
                            </div>
                        </div>
                        <div class="-mx-3 md:flex mb-6">
                            <div class="px-3 mb-6 w-full md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="lastname">
                                    Last Name
                                </label>
                                <input type="text"
                                    class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4"
                                    id="name" autofocus required v-model="form.lastname">
                                <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.name">
                                    {{ errors.lastname[0] }}
                                </span>
                            </div>
                        </div>
                        <div class="-mx-3 md:flex mb-6">
                            <div class="px-3 mb-6 w-full md:mb-0">
                                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                                    for="email">
                                    E-mail
                                </label>
                                <input type="email"
                                    class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4"
                                    id="email" required v-model="form.email">
                                <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.email">
                                    {{ errors.email[0] }}
                                </span>
                            </div>
                        </div> -->
                    <!-- <div class="p-2">
                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Medio de Pago
                            </label>
                            <select name="payment_type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                v-model="selectedPayment">
                                <option v-for="processor in paymentProcessors" :value="processor" :key="processor">
                                    {{ processor }}
                                </option>
                            </select>
                        </div> -->
                    <div class="flex justify-center">
                        <button class="text-sm" :class="{ 'opacity-50 cursor-not-allowed': disabled }"
                            @click="processPayment" :disabled="processing">
                            Pay now
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <!-- <order-totals :taxRate="cartTaxRate" :subtotal="cartSubtotal" :tax="newTax" :code="code"
                        :discount="discount" :newSubtotal="newSubtotal" :total="newTotal"></order-totals> -->
                <div class="shadow-md rounded sm:my-2">
                    <div class="flex flex-col items-center space-y-4 py-6 bg-gray-700">
                        <div class="flex space-x-4">
                            <span class="text-white">
                                Order Total(before tax & discount(s))
                            </span>
                            <span class="text-yellow-500">{{ total }}</span>
                        </div>
                        <!-- <div>
                                <button :href="route('checkout.index')" as="href" class="text-sm">Secure
                                    Checkout</button>
                            </div> -->
                    </div>
                    <div class="bg-gray-300 px-4 py-6">
                        <div>
                            <span class="px-4">Order Summary</span>
                            <div class="flex justify-between bg-white px-4 py-2 mt-4">
                                <span>Item(s) subtotal({{ $page.props.cartCount }})</span>
                                <span>{{ total }}</span>
                            </div>
                            <div class="flex justify-between px-4 mt-4">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <div class="bg-white px-4 py-2 mt-4">
                                <div class="flex justify-between">
                                    <span>Order Total</span>
                                    <span>{{ total }}</span>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button :href="route('checkout.index')" as="href" class="text-sm">Secure
                                    Checkout</button>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <Link :href="route('stores.index')" class="underline hover:text-red-700 transition">Continue
                            Shopping</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

    <!-- <h1 class="text-2xl font-semibold px-6">My Orders</h1>
            <template v-if="orders.data.length === 0">
                <template>
                    <div class="flex justify-center my-4 w-full">
                        <img :src="'/storage/images/site_images/droids.jpeg'"
                            alt="These are not the droids you are looking for!">
                    </div>
                </template>
            </template>
            <template v-else>
                <div class="flex flex-col space-y-2 px-6 py-2">
                    <div v-for="(order, index) in orders.data" :key="index">
                        <div class="flex justify-between bg-gray-700 text-sm text-white rounded-t px-6 py-2 w-full">
                            <div class="flex flex-col">
                                <span>Order Placed</span>
                                <span>{{ order.created_at }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span>Total</span>
                                <span>{{ order.billing_total }}</span>
                            </div>
                            <div class="flex flex-col text-right">
                                <span>Order # {{ order.confirmation_number }}</span>
                                <div>
                                    <yellow-button as="href" :href="route('orders.show', order.confirmation_number)"
                                        class="py-1">
                                        <span>View Invoice</span>
                                    </yellow-button>
                                </div>
                            </div>
                        </div>
                        <div class="border rounded-b divide-y space-y-4 px-6 py-2">
                            <div v-for="(product, index) in order.products" :key="index">
                                <Link :href="route('shop.show', product.slug)"
                                    class="flex justify-between space-x-4 divide-x py-6">
                                <div class="flex-1">
                                    <img :src="'/storage/' + product.main_image" :alt="product.name" class="object-cover">
                                </div>
                                <div class="flex-1 pl-4">
                                    <span>{{ product.name }}</span>
                                    <p>{{ product.details }}</p>
                                    <p>{{ product.description }}</p>
                                </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <nav>
                    <ul class="flex justify-center space-x-1 px-6 py-2">
                        <li class="rounded px-2 py-1" :class="[
                            link.url === null ? 'disabled' : '',
                            link.active ? 'bg-gray-400 text-gray-700 hover:bg-gray-900 hover:text-gray-400' : 'bg-gray-900 text-gray-400 hover:bg-gray-400 hover:text-gray-700'
                        ]" v-for="(link, index) in orders.links" :key="index">
                            <Link :href="link.url === null ? '#' : link.url" v-html="link.label">
                            </Link>
                        </li>
                    </ul>
                </nav>
            </template>
</AppLayout> -->
