<script>
import AppLayout from '@/Layouts/AppLayout.vue';

export default {
        components: {
            AppLayout,
        },
        props: {
            product: {
                type: Object,
                required: true
                },
        },
        data () {
            return {
                form: {
                    name: '',
                    description: '',
                    price: '',
                    quantity: '',
                }
            }
        },
        methods: {
            submit() {
                this.$inertia.post(this.route('products.store'), this.form);
            },
            destroy() {
                if (confirm('¿Desea Eliminar?')) {
                    this.$inertia.delete(this.route('products.destroy', this.product.id))
                }
            }
        }
    }
</script>

<template>
    <app-layout>
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
                            <form @submit.prevent="submit">
                                <label class="block font-medium text-sm text-gray-700">
                                    Nombre
                                </label>
                                <textarea 
                                    class="form-input w-full rounded-md shadow-sm"
                                    v-model="form.name"
                                ></textarea>
                                <label class="block font-medium text-sm text-gray-700">
                                    Descripción
                                </label>
                                <textarea 
                                    class="form-input w-full rounded-md shadow-sm"
                                    v-model="form.description"
                                    rows="8"
                                ></textarea>
                                <label class="block font-medium text-sm text-gray-700">
                                    Precio
                                </label>
                                <textarea 
                                    class="form-input w-full rounded-md shadow-sm"
                                    v-model="form.price"
                                ></textarea>
                                <label class="block font-medium text-sm text-gray-700">
                                    Cantidad 
                                </label>
                                <textarea 
                                    class="form-input w-full rounded-md shadow-sm"
                                    v-model="form.quantity"
                                ></textarea>
                                <button 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md"
                                >Crear</button>
                            </form>
                            <hr class="my-6">
                            <a href="#" @click.prevent="destroy">
                                Eliminar Producto
                            </a>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </app-layout>
</template>
