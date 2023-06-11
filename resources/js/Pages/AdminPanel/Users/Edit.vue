<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout,
    },
    props: {
        user: Object,
        errors: Object
    },
    data() {
        return {
            form: useForm({
                name: this.user.name,
                email: this.user.email,
                // status: this.user.status,
            })
        }
    },
    computed: {
        status() {
            return this.user.status === 0 ? 1 : 0;
        },
        buttonText() {
            return this.user.status === 0 ? 'Inactivo' : 'Activo';
        },
        buttonClass() {
            return 'btn btn-' + (this.user.status === 0 ? 'danger' : 'success');
        }
    },
    methods: {
        submit() {
            this.$inertia.put(this.route('users.update', this.user.id), this.form);
        },
        destroy() {
            if (confirm('¿Desea Eliminar?')) {
                this.$inertia.delete(this.route('users.destroy', this.user.id))
            }
        },
        submitForm() {
            this.$inertia.put(this.route('update.status', this.user.id), this.form);
        }
    }
}
</script>

<template>
    <!-- <AppLayout> -->
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edición de Usuario
    </h2>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px0">
                        <h3 class="text-lg text-gray-900">Editar Usuario</h3>
                        <p class="text-sm text-gray-600">Si editas no podrás volver al estado anterior</p>
                    </div>
                </div>
                <div class="md:col-span-2 mt-5 md:mt-0">
                    <div class="shadow bg-white md:rounded-md p-4">
                        <form @submit.prevent="submit">
                            <label class="block font-medium text-sm text-gray-700">
                                Nombre
                            </label>
                            <textarea class="form-input w-full rounded-md shadow-sm" v-model="form.name"></textarea>
                            <div v-if="errors.name" class="text-red-600">
                                {{ errors.name }}
                            </div>
                            <label class="block font-medium text-sm text-gray-700">
                                Correo
                            </label>
                            <textarea class="form-input w-full rounded-md shadow-sm" v-model="form.email"
                                rows="8"></textarea>
                            <div v-if="errors.email" class="text-red-600">
                                {{ errors.email }}
                            </div>
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">Editar</button>
                        </form>
                        <Link :href="route('users.index')"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                        Volver </Link>
                        <hr class="my-6">
                        <a @click.prevent="destroy">
                            Eliminar Usuario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </AppLayout> -->
</template>
