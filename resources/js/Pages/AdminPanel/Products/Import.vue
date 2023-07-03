<!-- <script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { Inertia } from "@inertiajs/inertia";

const form = useForm({
    file: null,
    _method: 'put'
})

const uploadFile = () => {
    form.post(route('products.store.imports'), {
        preserveScroll: true,
    })
}

</script> -->

<script>

import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout, Link
    },
    data() {
        return {
            file: null,
        };
    },
    methods: {
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        importFile() {
            let formData = new FormData();
            formData.append('file', this.file);
            axios.post('/products/imports', formData).then(response => {
                console.log(response.data);
            }).catch(error => {
                console.log(error.response.data);
            });
        },
        // importFile() {
        //     let formData = new FormData();
        //     formData.append('file', this.file);
        //     axios.post('/products/imports', formData).then(response => {
        //         console.log(response.data);
        //     }).catch(error => {
        //         console.log(error.response.data);
        //     });
        // },
    },
};
</script>

<template>
    <AppLayout title="Importar Productos">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Importar Productos
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
                            <!-- <form class="w-full" @submit.prevent="uploadFile" enctype="multipart/form-data">
                                <input class="py-2" type="file" @input="form.file = $event.target.files[0]" />
                                <button type="submit"
                                    class="px-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">Importar
                                    Producto</button> -->
                            <!-- <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress> -->
                            <!-- </form> -->
                            <input type="file" @change="handleFileUpload" />
                            <button @click="importFile">Import</button>
                            <hr class="my-6">
                            <Link :href="route('products.index')"
                                class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-md mr-2">
                            Volver
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>