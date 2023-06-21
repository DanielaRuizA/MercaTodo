<script>
import AppLayout from '@/Layouts/AppLayoutUser.vue';
import { Link, useForm } from '@inertiajs/vue3';

export default {
    components: {
        AppLayout,
        Link,
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
                status: this.user.status,
            })
        }
    },
    computed: {
        status() {
            if (this.user.status === 'Active') {
                return 'Usuario Esta habilitado'
            } else {
                return 'Usuario Esta Deshabilitado'
            }
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
        updateStatus(user) {
            const status = (user.status === 'Active') ? 'Inactive' : 'Active';
            axios.get('/change/user/status', {
                params: { status: status, user_id: user.id }
            }).then(response => {
                console.log(response.data.success);
                user.status = !user.status;
            }).catch(error => {
                console.error(error);
            });
        }
    }
}
</script>

<template>
    <AppLayout title="Edición De Usuario">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Información Del Usuario {{ user.name }}
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
                                <td class="px-3 py-2 whitespace-no-wrap text-m leading-5 text-gray-900">
                                    {{ status }}
                                </td>
                                <td class="px-3 py-5 whitespace-no-wrap text-m leading-5 text-gray-900">
                                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                        <input type="checkbox" value="" class="sr-only peer"
                                            :checked="user.status === 'Inactive'" @change="updateStatus(user)"
                                            :data-id="user.id">
                                        <div
                                            class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600">
                                        </div>
                                    </label>
                                </td>
                                <button
                                    class="px-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">Editar</button>
                            </form>
                            <hr class="my-6">
                            <div>
                                <Link :href="route('users.index')"
                                    class="bg-blue-600 hover:bg-blue-500 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded-mdpx-2 py-1 bg-blue-600 hover:bg-blue-500 text-white rounded font-bold uppercase mr-2">
                                Volver
                                </Link>
                                <button @click.prevent="destroy()" type="button"
                                    class="px-2 py-1 bg-red-600  hover:bg-red-500 text-white rounded font-bold uppercase">
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
