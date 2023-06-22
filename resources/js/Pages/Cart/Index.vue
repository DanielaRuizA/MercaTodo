<script>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

export default {
    props: ['cartItems', 'total'],
    components: {
        Link,
        AppLayout,
    },
    data() {
        return {
            quantity: 1,
            index: 1,
            form: useForm({
                cartItems: this.cartItems,
                quantity: 0,
            }),
        }
    },
    methods: {
        showImage() {
            return "/storage/";
        },
        updateCart(id, quantity) {
            this.form.quantity = quantity
            this.form.patch(this.route('cart.update', id), {
                preserveScroll: true,
                onSuccess: () => {
                    console.log(this.form)
                }
            })
        },
        deleteFromCart(id) {
            this.$inertia.delete(this.route('cart.destroy', id), {
                preserveScroll: true,
                onSuccess: () => {
                }
            })
        },
    }
}
</script>
<template>
    <AppLayout title="Cart">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">
            <div class="flex-1">
                <div class="flex flex-col items-center mb-2 md:flex-row md:justify-between">
                    <p class="text-sky-700 text-4xl font-bold" v-if="$page.props.cartCount <= 0">
                        El Carro Esta Vació!
                    </p>
                    <p class="text-blue-600 text-3xl font-bold" v-else> {{ $page.props.cartCount }}
                        Productos
                        En el Carrito
                    </p>
                </div>
                <div v-if="$page.props.cartCount > 0" class="flex justify-between border border-transparent py-2">
                    <div class="w-1/3 text-xl font-semibold">Producto</div>
                    <div class="flex justify-between w-1/2">
                        <span class="flex-1 tex-center text-xl font-semibold">Cantidad</span>
                        <span class="flex-1 text-right text-xl font-semibold">Precio</span>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between border-b border-gray-200 py-2" v-for="(item, index) in  cartItems "
                        :key="index">
                        <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                            <Link :href="route('stores.show', item.id)" class="flex flex-1">
                            <img :src="showImage() + item.options.image" :alt="item.name"
                                class="h-full w-full object-cover object-center">
                            </Link>
                        </div>
                        <div class="flex flex-1 flex-col justify-between">
                            <Link :href="route('stores.show', item.id)" class="flex flex-col">
                            <span class="font-bold uppercase">{{ item.name }}</span>
                            <span>{{ item.options.description }}</span>
                            </Link>
                        </div>
                        <div class="flex justify-between w-1/2">
                            <div class="flex-1 text-center">
                                <select class="border bg-white rounded outline-none py-0" tabindex="1" v-model="item.qty"
                                    @change="updateCart(item.rowId, item.qty)">
                                    <option :value="qty" :selected="qty === item.qty"
                                        v-for="( qty, index ) in  item.options.totalQty " :key="index">
                                        {{ qty }}
                                    </option>
                                </select>
                            </div>
                            <form @submit.prevent="deleteFromCart(item.rowId)">
                                <button type="submit" class="hover:text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                            <span class="flex-1 text-right">
                                {{ Intl.NumberFormat('es-CO', {
                                    style: 'currency', currency: 'COP',
                                    maximumSignificantDigits: 3
                                }).format(item.price) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <div class="shadow-md rounded sm:my-2">
                    <div class="bg-white px-4 py-6">
                        <div>
                            <span class="px-4 text-xl text-center font-semibold">Resumen De Pedido</span>
                            <div class="flex justify-between bg-white px-4 py-2 mt-4 text-lg">
                                <span class="font-semibold">Subtotal</span>
                                <span>{{ Intl.NumberFormat('es-CO', {
                                    style: 'currency', currency: 'COP',
                                    maximumSignificantDigits: 3
                                }).format(total) }}</span>
                            </div>
                            <div class="flex justify-between bg-white px-4 py-2 mt-4 text-lg">
                                <span class="font-semibold">Cantidad De Productos </span>
                                <span>{{ $page.props.cartCount }}</span>
                            </div>
                            <div class="flex justify-between px-4 mt-4 text-lg">
                                <span class="font-semibold">Envió</span>
                                <span>Gratis</span>
                            </div>
                            <div class="bg-white px-4 py-2 mt-4 text-lg">
                                <div class="flex justify-between">
                                    <span class="font-semibold"> Total Del Pedido</span>
                                    <span>{{ Intl.NumberFormat('es-CO', {
                                        style: 'currency', currency: 'COP',
                                        maximumSignificantDigits: 3
                                    }).format(total) }}</span>
                                </div>
                            </div>
                            <div v-if="$page.props.cartCount > 0"
                                class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 ">
                                <Link :href="route('checkout.index')" class="text-lg"> CONFIRMAR PEDIDO
                                </Link>
                            </div>
                        </div>
                        <div class="text-center mt-4 text-base">
                            <Link :href="route('stores.index')"
                                class="underline hover:text-indigo-700  font-semibold transition">
                            CONTINUAR COMPRANDO</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


