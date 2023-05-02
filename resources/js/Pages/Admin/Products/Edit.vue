<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router, useForm  } from '@inertiajs/vue3';


const props = defineProps({
    product: {
        type: Object,
        required: true
    },
});

const form = useForm ({
    id: props.product.id,
    name: props.product.name,
    description:props.product.description,
    price:props.product.price,
    quantity:props.product.quantity,
    product_photo:props.product.product_photo,
    _method: 'put'
});

const submit = () => {
    form.post(route('products.update', props.product.id),
//     {
//         forceFormData: true,}
);
}

// function submit(){
//     form.post(router('products.update', {
//                     // forceFormData: true,
//                     //_method: 'put',
//                     name: form.name,
//                     description: form.description,
//                     price:form.price,
//                     quantity:form.quantity,
//                     // product_photo:form.product_photo,
//                 }))};
            
//     //         destroy() {
    //             if (confirm('¿Desea Eliminar?')) {
    //                 this.$inertia.delete(this.route('products.destroy', this.product.id))
    //             }
    //         }
    //     }
    // }
</script>

<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Producto
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
                                <!-- <img :src="showImage() + product.product_photo" :alt="product.name" width="250"> -->
                                <input type="file" @input="form.product_photo = $event.target.files[0]" />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress>
                                <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                    {{ form.progress.percentage }}%
                                </progress> -->
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md"
                                >Editar</button>
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


