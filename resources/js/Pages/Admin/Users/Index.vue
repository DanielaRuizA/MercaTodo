<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

export default {
        components: {
            AppLayout, Head, Link
        },
        props: {
            users: Array,
        },
        methods: {
            submit() {
                this.$inertia.put(this.route('users.update', this.user.id), this.form)
            },
            destroy() {
                if (confirm('¿Desea Eliminar?')) {
                    this.$inertia.delete(this.route('users.destroy', this.user.id))
                }
            }
        }
    }
</script>

<template>  
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Usuarios 
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">  
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <div class="flex justify-between">
                                <input type="text" class="form-input rounded-md shadow-sm" placeholder="Buscar...">
                            </div>
                            <hr class="my-6">
                            <hr class="my-6">
                            <table>
                                <thead>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                </thead>
                                <tr v-for="user in users" :key="user.id">
                                    <td class="border px-4 py-2">
                                        {{ user.id}}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ user.name}}
                                    </td>
                                    <td class="border px-4 py-2">
                                        {{ user.email}}
                                    </td>
                                    <td class="px-4 py-2">
                                        <Link :href="route('users.show', user.id)">
                                            Ver
                                        </Link>
                                    </td>
                                        <Link :href="route('users.edit', user.id)">
                                            Editar 
                                        </Link>
                                    <td class="px-4 py-2">
                                        <a href="#" @click.prevent="destroy">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </AppLayout>
</template>
