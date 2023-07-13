<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { computed } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js';

const props = defineProps({
    product: Object,
    errors: Object
});

const form = useForm({
    id: props.product.id,
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    quantity: props.product.quantity,
    product_photo: props.product.product_photo,
    status: props.product.status,
    _method: 'put'
});

const submit = () => {
    form.post(route('products.update', props.product.id), {
        onSuccess: () => {
            Toast.fire({
                icon: 'success',
                title: 'El producto a sido editado!'
            })
        }
    }
    );
}

// function showImage() {
//     return "/storage/";
// }

function showImage(image) {
    if (image.startsWith('http')) {
        return image;
    } else {
        return "/storage/" + image;
    }
}

function updateStatus(product) {
    const status = (product.status === 'Active') ? 'Inactive' : 'Active';
    axios.get('/change/product/status', {
        params: { status: status, product_id: product.id }
    }).then(response => {
        console.log(response.data.success);
        product.status = !product.status;
    }).catch(error => {
        console.error(error);
    });
}

const status = computed(() => {
    if (props.product.status === 'Active') {
        return 'El Producto Esta Disponible'
    } else {
        return 'El Producto No Esta Disponible'
    }
});

const destroy = (id) => {
    Swal.fire({
        title: '¿Desea Eliminar?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
    }).then((result) => {
        if (result.value) {
            Inertia.delete(route('products.destroy', id)).then(() => {
                Swal.fire(
                    'Eliminado',
                    'El producto ha sido eliminado exitosamente',
                    'success'
                );
            });
        }
    });
};
// const destroy = (id) => {
//     if (confirm('¿Desea Eliminar?')) {
//         Inertia.delete(route('products.destroy', id))
//     }
// }
</script>

<template>
    <AppLayout title="Edición Del Producto">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Producto {{ product.name }}
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
                                <td class="px-4 py-4 whitespace-no-wrap  block font-medium text-m leading-5 text-gray-900">
                                    {{ status }}
                                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer"
                                            :checked="product.status === 'Inactive'" @change="updateStatus(product)"
                                            :data-id="product.id">
                                        <div
                                            class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                        </div>
                                    </label>
                                </td>
                                <img class="py-2" :src="showImage(product.product_photo)" :alt="product.name" width="250">
                                <input class="py-2" type="file" @input="form.product_photo = $event.target.files[0]" />
                                <div v-if="errors.product_photo" class="text-red-600">
                                    {{ errors.product_photo }}
                                </div>
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>

                                <div class="py-2">
                                    <button type="submit"
                                        class="px-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">Editar
                                        Producto</button>
                                </div>
                            </form>
                            <hr class="my-6">
                            <Link :href="route('products.index')"
                                class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-md mr-2">
                            Volver
                            </Link>
                            <button @click="destroy(product.id)" type="button"
                                class="px-2 py-1 bg-red-600 hover:bg-red-500 text-white rounded font-bold uppercase">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>