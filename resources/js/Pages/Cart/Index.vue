<script>
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
// import CartItems from "@/Components/CartItems.vue";
// import Pagination from "@/Components/Pagination.vue";

// import OrderTotals from '@/Components/OrderTotals.vue';
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
            })
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
                    <p class="text-red-600 text-2xl font-semibold" v-if="$page.props.cartCount <= 0">
                        Your cart is empty!
                    </p>
                    <p class="text-red-600 text-2xl font-semibold" v-else> {{ $page.props.cartCount }}item(s) in cart
                    </p>
                    <Link :href="route('stores.index')" class="underline hover:text-red-700 transition">Continue Shopping
                    </Link>
                </div>
                <div v-if="$page.props.cartCount > 0" class="flex justify-between border-t border-b border-black py-2">
                    <div class="w-1/3">Item</div>
                    <div class="flex justify-between w-1/2">
                        <span class="flex-1 tex-center">Quantity</span>
                        <span class="flex-1 text-right">Price</span>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between border-b border-black py-2" v-for="(item, index) in  cartItems "
                        :key="index">
                        <div class="flex space-x-4 w-1/2">
                            <Link :href="route('stores.show', item.id)" class="flex flex-1">
                            <img :src="showImage() + item.options.image" :alt="item.name" class="object-cover">
                            </Link>
                            <div class="flex flex-1 flex-col justify-between">
                                <Link :href="route('stores.show', item.id)" class="flex flex-col">
                                <span>{{ item.name }}</span>
                                <span>{{ item.options.description }}</span>
                                </Link>
                                <div class="flex flex-col mt-4">
                                    <form @submit.prevent="deleteFromCart(item.rowId)">
                                        <button type="submit" class="hover:text-yellow-500">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
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
                            <span class="flex-1 text-right">
                                {{ item.price }} ea.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <div class="shadow-md rounded sm:my-2">
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
                                <button as="href" class="text-sm">Secure
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
        <!-- <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">
            <div class="flex-1">
                <div class="flex flex-col items-center mb-2 md:flex-row md:justify-between">
                    <p class="text-red-600 text-2xl font-semibold">
                        Your cart is empty!
                    </p>
                    <p class="text-red-600 text-2xl font-semibold"> item(s) in cart
                    </p>
                    <Link :href="route('stores.index')" class="underline hover:text-red-700 transition">Continue Shopping
                    </Link>
                </div>
                <div class="flex justify-between border-t border-b border-black py-2">
                    <div class="w-1/3">Item</div>
                    <div class="flex justify-between w-1/2">
                        <span class="flex-1 tex-center">Quantity</span>
                        <span class="flex-1 text-right">Price</span>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between border-b border-black py-2" v-for="(item, index) in  items "
                        :key="index">
                        <div class="flex space-x-4 w-1/2">
                            <Link :href="route('stores.show', item.id)" class="flex flex-1">
                            <img src='https://www.pexels.com/es-es/foto/fotografia-en-primer-plano-de-flores-rosas-1408221/'
                                :alt="item.name" class="object-cover">
                            </Link>
                            <div class="flex flex-1 flex-col justify-between">
                                <Link :href="route('stores.show', item.id)" class="flex flex-col">
                                <span>{{ item.name }}</span>
                                <span>{{ item.options.description }}</span>
                                </Link>
                                <div class="flex flex-col mt-4">
                                    <form @submit.prevent="remove(item.rowId)">
                                        <button type="submit" class="hover:text-yellow-500">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between w-1/2">
                            <div class="flex-1 text-center">
                                <select class="border bg-white rounded outline-none py-0" tabindex="1" v-model="item.qty"
                                    @change="update(item.rowId, item.qty)">
                                    <option :value="qty" :selected="qty === item.qty"
                                        v-for="( qty, index ) in  item.options.totalQty " :key="index">
                                        {{ qty }}
                                    </option>
                                </select>
                            </div>
                            <span class="flex-1 text-right">
                                {{ item.price }} ea.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="text-center text-red-600 text-2xl font-semibold mt-4 mb-2 md:text-left">
                    <p v-if="laterCount <= 0">You have saved no items for later!</p>
                    <p v-else>{{ laterCount }} item(s) saved for later</p>
                </div>

            </div>
            <div class="flex-1">
                <div class="shadow-md rounded sm:my-2">
                    <div class="flex flex-col items-center space-y-4 py-6 bg-gray-700">
                        <div class="flex space-x-4">
                            <span class="text-white">
                                Order Total(before tax & discount(s))
                            </span>
                            <span class="text-yellow-500">{{ subtotal }}</span>
                        </div>
                        <div>
                            <button as="href" class="text-sm">Secure
                                Checkout</button>
                        </div>
                    </div>
                    <div class="bg-gray-300 px-4 py-6">
                        <div>
                            <span class="px-4">Order Summary</span>
                            <div class="flex justify-between bg-white px-4 py-2 mt-4">
                                <span>Item(s) subtotal({{ $page.props.cartCount }})</span>
                                <span>{{ newSubtotal }}</span>
                            </div>
                            <div class="flex justify-between px-4 mt-4">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <div class="flex justify-between px-4 mt-4">
                                <span>Estimated Tax</span>
                                <span>5%</span>
                            </div>
                            <div class="bg-white px-4 py-2 mt-4">
                                <div class="flex justify-between">
                                    <span>Order Total</span>
                                    <span>{{ total }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span>({{ taxRate }}% tax rate)</span> -->
        <!-- <span>Lorem ipsum elit.</span>
                                </div>
                            </div>
                            <div class="text-center mt-4">
                                <button as="href" class="text-sm">Secure
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
        </div> -->
        <!-- <div class="flex justify-between border-t border-b border-black py-2">
            <div class="w-1/3">Item</div>
            <div class="flex justify-between w-1/2">
                <span class="flex-1 tex-center">Quantity</span>
                <span class="flex-1 text-right">Price</span>
            </div>
        </div>
        <div>
            <div class="flex justify-between border-b border-black py-2" v-for="(item, index) in items" :key="index">
                <div class="flex space-x-4 w-1/2">
                    <Link :href="route('shop.show', item.options.slug)" class="flex flex-1">
                    <img :src="'/storage/' + item.options.main_image" :alt="item.name" class="object-cover">
                    </Link>
                    <div class="flex flex-1 flex-col justify-between">
                        <Link :href="route('shop.show', item.options.slug)" class="flex flex-col">
                        <span>{{ item.name }}</span>
                        <span>{{ item.options.details }}</span>
                        </Link>
                        <div class="flex flex-col mt-4">
                            <form @submit.prevent="remove(item.rowId)">
                                <button type="submit" class="hover:text-yellow-500">
                                    Remove
                                </button>
                            </form>
                            <form @submit.prevent="later(item.rowId)">
                                <button type="submit" class="hover:text-yellow-500">
                                    {{ actionText }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="flex justify-between w-1/2">
                    <div class="flex-1 text-center">
                        <select class="border bg-white rounded outline-none py-0" tabindex="1" v-model="item.qty"
                            @change="update(item.rowId, item.qty)">
                            <option :value="qty" :selected="qty === item.qty" v-for="(qty, index) in item.options.totalQty"
                                :key="index">
                                {{ qty }}
                            </option>
                        </select>
                    </div>
                    <span class="flex-1 text-right">
                        {{ $filters.formatCurrency(item.price) }} ea.
                    </span>
                </div>
            </div>
        </div> -->

    </AppLayout>
</template>


