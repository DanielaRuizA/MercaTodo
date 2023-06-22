<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    product: Object
})

const showImage = () => "/storage/"

const destroy = (id) => {
    if (confirm('¿Desea Eliminar?')) {
        Inertia.delete(route('products.destroy', id))
    }
}

</script>

<template>
    <AppLayout title="Detalles Del Producto">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Producto {{ product.name }}
            </h2>
        </template>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="px-4 sm:px-0">
                <h3 class="text-base font-semibold leading-7 text-gray-900">Detalles Del Producto</h3>
            </div>
            <div class="mt-6 border-t border-gray-100">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">ID</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ product.id }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Nombre</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ product.name }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Descripcion</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ product.description }}
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Precio</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ Intl.NumberFormat('es-CO',
                            {
                                style: 'currency', currency: 'COP', maximumSignificantDigits: 3
                            }).format(product.price) }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Cantidad</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ product.quantity }}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"
                            v-if="product.status === 'Active'">
                            El Producto Esta Disponible
                        </dd>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"
                            v-if="product.status === 'Inactive'">
                            El Producto No Esta Disponible
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Imagen</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            <img :src="showImage() + product.product_photo" :alt="product.name" width="400">
                        </dd>
                    </div>
                </dl>
                <div class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    <Link :href="route('products.index')"
                        class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">
                    Volver
                    </Link>
                    <Link :href="route('products.edit', product.id)"
                        class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Editar</Link>
                    <button @click="destroy(product.id)" type="button"
                        class="px-2 py-1 bg-red-600 text-white rounded font-bold uppercase">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

