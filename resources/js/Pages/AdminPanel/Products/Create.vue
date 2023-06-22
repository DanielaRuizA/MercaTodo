<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout, Link
    },
    props: {
        product: Object,
        errors: Object
    },
    data() {
        return {
            form: useForm({
                name: '',
                description: '',
                price: '',
                quantity: '',
                product_photo: '',
            })
        }
    },
    methods: {
        submit() {
            this.$inertia.post(this.route('products.store'), this.form);
        }
    }
}

</script>

<template>
    <AppLayout title="Crear Producto">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Añadir Producto
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px0">
                            <h3 class="text-lg text-gray-900">Editar Producto</h3>
                            <p class="text-sm text-gray-600">Si editas no podrás volver al estado anterior</p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <form @submit.prevent="submit" enctype="multipart/form-data">
                                <label class="block font-medium text-sm text-gray-700">
                                    Nombre
                                </label>
                                <textarea class="form-input w-full rounded-md shadow-sm" v-model="form.name"></textarea>
                                <div v-if="errors.name" class="text-red-600">
                                    {{ errors.name }}
                                </div>
                                <label class="block font-medium text-sm text-gray-700">
                                    Descripción
                                </label>
                                <textarea class="form-input w-full rounded-md shadow-sm" v-model="form.description"
                                    rows="8"></textarea>
                                <div v-if="errors.description" class="text-red-600">
                                    {{ errors.description }}
                                </div>
                                <label class="block font-medium text-sm text-gray-700">
                                    Precio
                                </label>
                                <textarea class="form-input w-full rounded-md shadow-sm" v-model="form.price"></textarea>
                                <div v-if="errors.price" class="text-red-600">
                                    {{ errors.price }}
                                </div>
                                <label class="block font-medium text-sm text-gray-700">
                                    Cantidad
                                </label>
                                <textarea class="form-input w-full rounded-md shadow-sm" v-model="form.quantity"></textarea>
                                <div v-if="errors.quantity" class="text-red-600">
                                    {{ errors.quantity }}
                                </div>
                                <input class="py-2" type="file" @input="form.product_photo = $event.target.files[0]" />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                                <div v-if="errors.product_photo" class="text-red-600">
                                    {{ errors.product_photo }}
                                </div>
                                <div class="py-3 block font-medium text-sm text-gray-700">
                                    <button
                                        class="bg-blue-600 hover:bg-blue-700 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-mdpx-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">Crear
                                        Producto</button>
                                </div>
                            </form>
                            <hr class="my-6">
                            <div>
                                <Link :href="route('products.index')"
                                    class="bg-blue-600 hover:bg-blue-700 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-mdpx-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">
                                Volver
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
